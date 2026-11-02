<?php
require_once '../app/core/Model.php';

class Lead extends Model {

    // --- 1. LECTURA Y FILTROS (Módulo Principal) ---
    public function getLeadsFiltrados($busqueda = '', $temperatura = '', $mql_id = '') {
        // Hacemos JOIN con lead_telefonos para obtener el número principal
        $sql = "SELECT l.id, l.fecha_lead, l.nombre, t.telefono, e.nombre AS empresa, c.nombre AS campana, 
                       cn.nombre AS canal, m.nivel AS mql, l.temperatura, a.nombre AS agente, l.derivado_ventas 
                FROM leads l
                LEFT JOIN lead_telefonos t ON l.id = t.lead_id AND t.es_principal = 1
                LEFT JOIN empresas e ON l.empresa_id = e.id
                LEFT JOIN campanas c ON l.campana_id = c.id
                LEFT JOIN canales cn ON l.canal_id = cn.id
                LEFT JOIN mql_status m ON l.mql_id = m.id
                LEFT JOIN agentes a ON l.agente_id = a.id
                WHERE 1=1 ";
        
        $params = [];
        
        if (!empty($busqueda)) {
            $sql .= " AND (l.nombre LIKE :busqueda OR t.telefono LIKE :busqueda OR l.email LIKE :busqueda) ";
            $params['busqueda'] = "%$busqueda%";
        }
        if (!empty($temperatura) && $temperatura !== 'Todas') {
            $sql .= " AND l.temperatura = :temperatura ";
            $params['temperatura'] = $temperatura;
        }
        if (!empty($mql_id) && $mql_id !== 'Todos') {
            $sql .= " AND l.mql_id = :mql_id ";
            $params['mql_id'] = $mql_id;
        }
        
        $sql .= " ORDER BY l.fecha_lead DESC, l.id DESC";
        return $this->getAll($sql, $params);
    }

    // --- 2. CREACIÓN (Formulario Nuevo Lead) ---
    public function getCatalogos() {
        return [
            'paises'     => $this->getAll("SELECT id, nombre FROM paises ORDER BY nombre"),
            'ciudades'   => $this->getAll("SELECT id, nombre, pais_id FROM ciudad ORDER BY nombre"),
            'empresas'   => $this->getAll("SELECT id, nombre FROM empresas ORDER BY nombre"),
            'proyectos'  => $this->getAll("SELECT id, nombre, empresa_id FROM proyectos ORDER BY nombre"),
            'campanas'   => $this->getAll("SELECT id, nombre, empresa_id FROM campanas ORDER BY nombre"),
            'canales'    => $this->getAll("SELECT id, nombre FROM canales ORDER BY nombre"),
            'mqls'       => $this->getAll("SELECT id, nivel FROM mql_status ORDER BY id"),
            'agentes'    => $this->getAll("SELECT id, nombre FROM agentes WHERE activo = 1 ORDER BY nombre"),
            'vendedores' => $this->getAll("SELECT id, nombre FROM vendedor WHERE activo = 1 ORDER BY nombre")
        ];
    }

    // Retorna el ID autoincrementable generado (entero)
    public function createLead(array $data) {
        $sql = "INSERT INTO leads 
                (nombre, email, ciudad_id, empresa_id, campana_id, proyecto_id, canal_id, mql_id, temperatura, tipo_pago, comentario, agente_id, fecha_lead) 
                VALUES 
                (:nombre, :email, :ciudad_id, :empresa_id, :campana_id, :proyecto_id, :canal_id, :mql_id, :temperatura, :tipo_pago, :comentario, :agente_id, :fecha_lead)";
        
        $this->query($sql, [
            'nombre'      => $data['nombre'],
            'email'       => !empty($data['email']) ? $data['email'] : null,
            'ciudad_id'   => !empty($data['ciudad_id']) ? (int)$data['ciudad_id'] : null,
            'empresa_id'  => !empty($data['empresa_id']) ? (int)$data['empresa_id'] : null,
            'campana_id'  => !empty($data['campana_id']) ? (int)$data['campana_id'] : null,
            'proyecto_id' => !empty($data['proyecto_id']) ? (int)$data['proyecto_id'] : null,
            'canal_id'    => !empty($data['canal_id']) ? (int)$data['canal_id'] : null,
            'mql_id'      => !empty($data['mql_id']) ? (int)$data['mql_id'] : null,
            'temperatura' => !empty($data['temperatura']) ? $data['temperatura'] : 'frio',
            'tipo_pago'   => !empty($data['tipo_pago']) ? $data['tipo_pago'] : null,
            'comentario'  => !empty($data['comentario']) ? $data['comentario'] : null,
            'agente_id'   => !empty($data['agente_id']) ? (int)$data['agente_id'] : null,
            'fecha_lead'  => !empty($data['fecha_lead']) ? $data['fecha_lead'] : date('Y-m-d')
        ]);
        
        return $this->getLastInsertId();
    }

    // Inserta en la tabla normalizada de teléfonos
    public function addTelefono($lead_id, $telefono) {
        $this->query("INSERT INTO lead_telefonos (lead_id, telefono, tipo, es_principal) VALUES (:lead_id, :telefono, 'movil', 1)", [
            'lead_id' => (int)$lead_id, 
            'telefono' => $telefono
        ]);
    }

    public function addSeguimientoInicial($lead_id) {
        $this->query("INSERT INTO seguimientos (lead_id, iteracion, estado, comentario) VALUES (:lead_id, 1, 'se_envio_mensaje', 'Mensaje inicial enviado desde la creación del lead')", [
            'lead_id' => (int)$lead_id
        ]);
    }

    // --- 3. ACCIONES DE LA TABLA (Eliminar y Seguimiento) ---
    public function deleteLead($id) {
        // ON DELETE CASCADE en la BD se encarga de lead_telefonos y seguimientos automáticamente
        $this->query("DELETE FROM leads WHERE id = :id", ['id' => (int)$id]);
    }

    public function addSeguimiento($data) {
        // Calcular iteración (Max 7 según tu CHECK constraint de base de datos)
        $res = $this->getAll("SELECT MAX(iteracion) as max_it FROM seguimientos WHERE lead_id = :lead_id", ['lead_id' => (int)$data['lead_id']]);
        $iteracion = ($res[0]['max_it']) ? $res[0]['max_it'] + 1 : 1;
        if ($iteracion > 7) $iteracion = 7;

        $this->query("INSERT INTO seguimientos (lead_id, iteracion, estado, comentario) VALUES (:lead_id, :iteracion, :estado, :comentario)", [
            'lead_id' => (int)$data['lead_id'], 
            'iteracion' => $iteracion, 
            'estado' => $data['estado'], 
            'comentario' => $data['comentario']
        ]);

        if(!empty($data['temperatura'])) {
            $this->query("UPDATE leads SET temperatura = :temp WHERE id = :id", [
                'temp' => $data['temperatura'], 
                'id' => (int)$data['lead_id']
            ]);
        }
    }


   
   // Obtener un lead específico por ID (Uniendo ciudad para recuperar el país y teléfonos para el número)
    public function getLeadById($id) {
        $sql = "SELECT l.*, t.telefono, c.pais_id 
                FROM leads l 
                LEFT JOIN lead_telefonos t ON l.id = t.lead_id AND t.es_principal = 1
                LEFT JOIN ciudad c ON l.ciudad_id = c.id
                WHERE l.id = :id LIMIT 1";
                
        $resultado = $this->getAll($sql, ['id' => (int)$id]);
        return !empty($resultado) ? $resultado[0] : null;
    }

   // Actualizar los datos del lead en sus tablas correspondientes
    public function updateLead($id, $data) {
        // 1. Actualizar tabla principal leads (SOLO con las columnas que realmente existen)
        $sql = "UPDATE leads SET 
                nombre = :nombre, ciudad_id = :ciudad_id, email = :email, fecha_lead = :fecha_lead,
                empresa_id = :empresa_id, campana_id = :campana_id, proyecto_id = :proyecto_id,
                canal_id = :canal_id, mql_id = :mql_id, temperatura = :temperatura,
                tipo_pago = :tipo_pago, comentario = :comentario, agente_id = :agente_id
                WHERE id = :id";
        
        $this->query($sql, [
            'nombre'      => $data['nombre'],
            'ciudad_id'   => !empty($data['ciudad_id']) ? (int)$data['ciudad_id'] : null,
            'email'       => !empty($data['email']) ? $data['email'] : null,
            'fecha_lead'  => !empty($data['fecha_lead']) ? $data['fecha_lead'] : null,
            'empresa_id'  => !empty($data['empresa_id']) ? (int)$data['empresa_id'] : null,
            'campana_id'  => !empty($data['campana_id']) ? (int)$data['campana_id'] : null,
            'proyecto_id' => !empty($data['proyecto_id']) ? (int)$data['proyecto_id'] : null,
            'canal_id'    => !empty($data['canal_id']) ? (int)$data['canal_id'] : null,
            'mql_id'      => !empty($data['mql_id']) ? (int)$data['mql_id'] : null,
            'temperatura' => !empty($data['temperatura']) ? $data['temperatura'] : 'frio',
            'tipo_pago'   => !empty($data['tipo_pago']) ? $data['tipo_pago'] : null,
            'comentario'  => !empty($data['comentario']) ? $data['comentario'] : null,
            'agente_id'   => !empty($data['agente_id']) ? (int)$data['agente_id'] : null,
            'id'          => (int)$id
        ]);

        // 2. Actualizar el teléfono replicando la estructura de tu addTelefono()
        $this->query("DELETE FROM lead_telefonos WHERE lead_id = :id", ['id' => (int)$id]);
        
        if (!empty(trim($data['telefono']))) {
            $this->query("INSERT INTO lead_telefonos (lead_id, telefono, tipo, es_principal) 
                          VALUES (:id, :telefono, 'movil', 1)", [
                'id' => (int)$id, 
                'telefono' => trim($data['telefono'])
            ]);
        }
    }

    // Marcar lead como derivado y asignarle el vendedor
    public function derivarLead($id, $vendedor_id) {
        $sql = "UPDATE leads SET derivado_ventas = 1, vendedor_id = :vendedor_id WHERE id = :id";
        $this->query($sql, [
            'vendedor_id' => (int)$vendedor_id,
            'id' => (int)$id
        ]);
    }
}