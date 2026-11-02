<?php
require_once '../app/core/Controller.php';
require_once '../app/models/User.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Muestra el formulario de login
    public function index() {
        if (isset($_SESSION['user_id'])) {
            // CORRECCIÓN: Ahora apunta a /inicio según el nuevo web.php
            header('Location: /crm_callcenter/public/inicio');
            exit;
        }
        $this->view('auth/login', ['titulo' => 'Login - GESTIONA CRM']);
    }

    // Procesa el envío del formulario
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            // Verificar si el usuario existe y la contraseña es correcta
            if ($user && password_verify($password, $user['password_hash'])) {
                // Llenar variables de sesión con los datos obtenidos de los JOINs
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nombre'] = $user['nombre'];
                $_SESSION['user_role'] = $user['rol'];
                
                // CORRECCIÓN: Redirección estricta a /inicio
                header('Location: /crm_callcenter/public/inicio');
                exit;
            } else {
                $this->view('auth/login', [
                    'titulo' => 'Login - GESTIONA CRM',
                    'error' => 'Correo o contraseña incorrectos'
                ]);
            }
        }
    }

    // Cierra la sesión
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /crm_callcenter/public/auth');
        exit;
    }

    // --- FUNCIÓN TEMPORAL PARA CREAR EL PRIMER ADMIN ---
    public function setup() {
        $passwordHash = password_hash('123456', PASSWORD_DEFAULT);
        
        $this->userModel->createUser([
            'nombre' => 'Hernán Admin',
            'email' => 'admin@gestiona.com',
            'password_hash' => $passwordHash,
            'role' => 'admin'
        ]);

        echo "¡Administrador maestro creado! Ya puedes ir al Login e ingresar con: <b>admin@gestiona.com</b> y contraseña <b>123456</b>";
    }
}