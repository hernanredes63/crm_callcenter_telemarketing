<?php
class Router {
    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    // Registrar rutas GET
    public function get($route, $action) {
        $this->routes['GET'][$route] = $action;
    }

    // Registrar rutas POST
    public function post($route, $action) {
        $this->routes['POST'][$route] = $action;
    }

    // Despachar la ruta actual
    public function dispatch() {
        // Capturar la URL actual y limpiar el formato
        $uri = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $uri = '/' . $uri; 
        if ($uri == '//') $uri = '/'; 

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$requestMethod] as $route => $action) {
            // Convertir parámetros como {id} a expresiones regulares para capturarlos
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
            $pattern = "@^" . $pattern . "$@D";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Eliminar la coincidencia global, dejando solo los parámetros
                return $this->executeAction($action, $matches);
            }
        }

        // Si la ruta no está registrada, lanzar 404
        http_response_code(404);
        die("Error 404: La ruta solicitada no existe o el método HTTP es incorrecto.");
    }

    private function executeAction($action, $params) {
        list($controllerName, $method) = explode('@', $action);
        
        $file = '../app/controllers/' . $controllerName . '.php';
        if (file_exists($file)) {
            require_once $file;
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                return call_user_func_array([$controller, $method], $params);
            }
        }
        die("Error 500: Controlador o método no encontrado.");
    }
}