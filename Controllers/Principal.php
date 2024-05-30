<?php
class Principal extends Controller
{
    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function index(){
        $data['title'] = 'Iniciar Sesion';
        $this->views->getView('principal', 'index' , $data);
    }

    ##VALIDAR LOGIN##
    public function validar(){
        $correo = $_POST['correo'];
        $clave = $_POST['clave'];
        //Llamada al modelo de principalModel 
        $data = $this->model->getUsuario($correo);
        //Verifica si ha recibido 1 usuario
        if(!empty($data)){
            //Verifica la contraseña es correcta
            if(password_verify($clave, $data['clave'])){
                $_SESSION['id'] = $data['id'];
                $_SESSION['correo'] = $data['correo'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['estado'] = $data['estado'];
                //Contraseña y email correctos
                $res = array('tipo' => 'success', 'mensaje' => 'Bienvenido a Neuro!');
            }else{
                //Contraseña incorrecta
                $res = array('tipo' => 'warning', 'mensaje' => 'el Email o la Contraseña  son incorrectos');
            }
        }else{
            //Email incorrecto
            $res = array('tipo' => 'warning', 'mensaje' => 'el Email o la Contraseña  son incorrectos');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    ##VALIDAR REGISTRO##
    public function validarR(){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
        //Llamada al modelo de principalModel 
        $data = $this->model->getUsuario($correo);
        //Verifica si ha recibido 1 usuario
        if(!empty($data)){
            $res = array('tipo' => 'error', 'mensaje' => 'El correo no es válido');
        }else{
            //Crea el usuario
            $data = $this->model->registraUsuario($nombre, $apellido, $correo, $telefono, $direccion, $clave);
            
            //Si lo crea inicia sesion
            if(!empty($data)){
                $_SESSION['id'] = $data;
                $_SESSION['correo'] = $correo;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['estado'] = 1;
                $res = array('tipo' => 'success', 'mensaje' => 'Bienvenido a Neuro!');
            }else{
                $res = array('tipo' => 'error', 'mensaje' => 'Algo no ha salido bien');
            };
            }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    ##CERRAR SESION##
    public function salir(){
        session_destroy();
        header('Location: '. BASE_URL);
    }
}
