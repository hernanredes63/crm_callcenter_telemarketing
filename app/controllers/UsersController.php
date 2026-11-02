<?php
require_once '../app/core/Controller.php';
require_once '../app/models/User.php';

class UsersController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // SEGURIDAD: Solo permitir acceso si el rol es admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /crm_callcenter/public/inicio');
            exit;
        }
    }

    // Listado de usuarios
    public function index() {
        $users = $this->userModel->getAllUsers();
        $this->view('users/index', [
            'titulo' => 'Gestión de Usuarios - GESTIONA CRM',
            'users' => $users
        ]);
    }

    // Vista de formulario para crear usuario
    public function create() {
        $this->view('users/create', [
            'titulo' => 'Nuevo Usuario - GESTIONA CRM'
        ]);
    }

    // Procesar la creación del usuario
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $role = $_POST['role']; // admin, supervisor, agente, vendedor, marketing

            // Encriptar contraseña de forma segura
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->createUser([
                'nombre' => $nombre,
                'email' => $email,
                'password_hash' => $passwordHash,
                'role' => $role
            ]);

            header('Location: /crm_callcenter/public/users');
            exit;
        }
    }


    // Cargar la vista de edición con los datos del usuario
    public function edit($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            header('Location: /crm_callcenter/public/users');
            exit;
        }
        $this->view('users/edit', [
            'titulo' => 'Editar Usuario - GESTIONA CRM',
            'user' => $user
        ]);
    }

    // Guardar los cambios del usuario
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'email' => trim($_POST['email']),
                'role' => $_POST['role'],
                'password_hash' => !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null
            ];

            $this->userModel->updateUser($id, $data);
            header('Location: /crm_callcenter/public/users');
            exit;
        }
    }

    // Eliminar usuario de forma segura
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Protección de seguridad: Evitar que el admin se borre a sí mismo
            if ($id != $_SESSION['user_id']) {
                $this->userModel->deleteUser($id);
            }
            header('Location: /crm_callcenter/public/users');
            exit;
        }
    }

    // Cargar la vista de detalles del usuario (solo lectura)
    public function show($id) {
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            header('Location: /crm_callcenter/public/users');
            exit;
        }
        $this->view('users/show', [
            'titulo' => 'Detalles del Usuario - GESTIONA CRM',
            'user' => $user
        ]);
    }
}