<?php
require_once '../app/core/Controller.php';

class HomeController extends Controller {
    public function index() {
        $data = [
            'titulo' => 'Bienvenido a GESTIONA CRM'
        ];
        $this->view('home/index', $data);
    }
}