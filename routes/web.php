<?php
// Instanciar el nuevo enrutador
$router = new Router();

// --- RAÍZ E INICIO (Dashboard) ---
$router->get('/', 'HomeController@index');
$router->get('/inicio', 'HomeController@index');
$router->get('/home', 'HomeController@index');


// --- MÓDULO USUARIOS (Solo Administradores) ---
$router->get('/users', 'UsersController@index');
$router->get('/users/create', 'UsersController@create');
$router->post('/users/store', 'UsersController@store');

// Nuevas rutas para Editar y Eliminar
$router->get('/users/edit/{id}', 'UsersController@edit');
$router->post('/users/update/{id}', 'UsersController@update');
$router->post('/users/delete/{id}', 'UsersController@delete');
$router->get('/users/show/{id}', 'UsersController@show');



// --- MÓDULO AUTH (Autenticación) ---
$router->get('/auth', 'AuthController@index');           // Vista del formulario de Login
$router->post('/auth/login', 'AuthController@login');    // Procesar los datos del Login
$router->get('/auth/logout', 'AuthController@logout');   // Destruir sesión y salir


// --- MÓDULO LEADS (Principal) ---
$router->get('/leads', 'LeadsController@index');
$router->get('/leads/create', 'LeadsController@create');
$router->post('/leads/store', 'LeadsController@store');

// Endpoint con parámetro {id} para eliminar
$router->post('/leads/delete/{id}', 'LeadsController@delete');
$router->post('/leads/seguimiento', 'LeadsController@guardarSeguimiento');

// --- MÓDULO LEADS (Consultas AJAX para selects dinámicos) ---
$router->get('/leads/getCiudades/{id}', 'LeadsController@getCiudades');
$router->get('/leads/getCampanas/{id}', 'LeadsController@getCampanas');
$router->get('/leads/getProyectos/{id}', 'LeadsController@getProyectos');

// NUEVAS RUTAS DE EDICIÓN (Asegúrate de que estén aquí)
$router->get('/leads/edit/{id}', 'LeadsController@edit');
$router->post('/leads/update/{id}', 'LeadsController@update');
$router->post('/leads/derivar/{id}', 'LeadsController@derivar');

// Ejecutar el enrutador (ESTA LÍNEA SIEMPRE DEBE SER LA ÚLTIMA DEL ARCHIVO)
$router->dispatch();