<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión si es necesario
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Cargar el motor de rutas
require_once '../app/core/Router.php';

// 2. Cargar el catálogo de rutas autorizadas (que a su vez dispara el dispatch)
require_once '../routes/web.php';