<?php
class Errorpage extends Controller
{
    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function index(){
        $data['title'] = 'Iniciar Sesion';
        $this->views->getView('error', 'error' , $data);
    }
}
