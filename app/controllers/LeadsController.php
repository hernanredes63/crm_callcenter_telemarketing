<?php
require_once '../app/core/Controller.php';
require_once '../app/models/Lead.php';

class LeadsController extends Controller {
    private $leadModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /crm_callcenter/public/auth');
            exit;
        }
        $this->leadModel = new Lead();
    }

    // --- 1. VISTA PRINCIPAL (Con Filtros) ---
    public function index() {
        $busqueda = $_GET['busqueda'] ?? '';
        $temperatura = $_GET['temperatura'] ?? 'Todas';
        $mql = $_GET['mql'] ?? 'Todos';

        $leads = $this->leadModel->getLeadsFiltrados($busqueda, $temperatura, $mql);
        $catalogos = $this->leadModel->getCatalogos(); 
        
        $this->view('leads/index', [
            'titulo' => 'Leads - GESTIONA CRM',
            'leads' => $leads,
            'filtros' => compact('busqueda', 'temperatura', 'mql'),
            'catalogos' => $catalogos
        ]);
    }

    // --- 2. VISTA DE CREACIÓN Y GUARDADO ---
    public function create() {
        $catalogos = $this->leadModel->getCatalogos();
        $this->view('leads/create', [
            'titulo' => 'Nuevo Lead - GESTIONA CRM',
            'catalogos' => $catalogos
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // 1. Guardar el lead en la tabla principal y obtener el ID autoincrementable
                $lead_id = $this->leadModel->createLead($_POST);
                
                // 2. Guardar el teléfono en la tabla normalizada "lead_telefonos" usando el ID obtenido
                if (!empty(trim($_POST['telefono']))) {
                    $this->leadModel->addTelefono($lead_id, trim($_POST['telefono']));
                }

                // 3. Registrar el primer seguimiento automáticamente si el agente activó el switch
                if (isset($_POST['se_envio_mensaje']) && $_POST['se_envio_mensaje'] === 'on') {
                    $this->leadModel->addSeguimientoInicial($lead_id);
                }
                
                header('Location: /crm_callcenter/public/leads');
                exit;
            } catch (Exception $e) {
                die("Error al guardar en BD: " . $e->getMessage());
            }
        }
    }

    // --- 3. ACCIONES DE LA TABLA ---
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->leadModel->deleteLead($id);
            header('Location: /crm_callcenter/public/leads');
            exit;
        }
    }

    public function guardarSeguimiento() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->leadModel->addSeguimiento($_POST);
            header('Location: /crm_callcenter/public/leads');
            exit;
        }
    }

    // --- 4. ENDPOINTS AJAX PARA CAMPOS DINÁMICOS ---
    public function getCiudades($pais_id) {
        echo json_encode($this->leadModel->getAll("SELECT id, nombre FROM ciudad WHERE pais_id = :pais_id ORDER BY nombre", ['pais_id' => (int)$pais_id]));
    }
    public function getCampanas($empresa_id) {
        echo json_encode($this->leadModel->getAll("SELECT id, nombre FROM campanas WHERE empresa_id = :empresa_id ORDER BY nombre", ['empresa_id' => (int)$empresa_id]));
    }
    public function getProyectos($empresa_id) {
        echo json_encode($this->leadModel->getAll("SELECT id, nombre FROM proyectos WHERE empresa_id = :empresa_id ORDER BY nombre", ['empresa_id' => (int)$empresa_id]));
    }


    // Cargar la vista de edición con los datos del Lead
    public function edit($id) {
        $lead = $this->leadModel->getLeadById($id);
        
        if (!$lead) {
            header('Location: /crm_callcenter/public/leads');
            exit;
        }

        // Usamos tu método existente que ya trae todo estructurado
        $catalogos = $this->leadModel->getCatalogos();

        $this->view('leads/edit', [
            'titulo' => 'Editar Lead - GESTIONA CRM',
            'lead' => $lead,
            'catalogos' => $catalogos
        ]);
    }

    // Procesar la actualización del Lead
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre'           => trim($_POST['nombre']),
                'pais_id'          => !empty($_POST['pais_id']) ? $_POST['pais_id'] : null,
                'ciudad_id'        => !empty($_POST['ciudad_id']) ? $_POST['ciudad_id'] : null,
                'email'            => trim($_POST['email']),
                'telefono'         => trim($_POST['telefono']),
                'fecha_lead'       => $_POST['fecha_lead'],
                
                'empresa_id'       => !empty($_POST['empresa_id']) ? $_POST['empresa_id'] : null,
                'campana_id'       => !empty($_POST['campana_id']) ? $_POST['campana_id'] : null,
                'proyecto_id'      => !empty($_POST['proyecto_id']) ? $_POST['proyecto_id'] : null,
                
                'canal_id'         => !empty($_POST['canal_id']) ? $_POST['canal_id'] : null,
                'mql_id'           => !empty($_POST['mql_id']) ? $_POST['mql_id'] : null,
                'temperatura'      => $_POST['temperatura'],
                
                'tipo_pago'        => $_POST['tipo_pago'],
                'agente_id'        => !empty($_POST['agente_id']) ? $_POST['agente_id'] : null,
                // Manejo del checkbox switch:
                'se_envio_mensaje' => isset($_POST['se_envio_mensaje']) ? 1 : 0, 
                'comentario'       => trim($_POST['comentario'])
            ];

            $this->leadModel->updateLead($id, $data);
            header('Location: /crm_callcenter/public/leads');
            exit;
        }
    }

    // Procesar la derivación rápida a un vendedor
    public function derivar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['vendedor_id'])) {
            $this->leadModel->derivarLead($id, $_POST['vendedor_id']);
            // Recargar la misma página de edición para ver el cuadro verde de éxito
            header('Location: /crm_callcenter/public/leads/edit/' . $id);
            exit;
        }
    }
}