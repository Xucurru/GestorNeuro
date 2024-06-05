<?php
class Eliminados extends Controller
{
    private $id_usuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['id'])) {
            header("Location: ".BASE_URL); 
            exit();
        }
        $this->id_usuario = $_SESSION['id'];
    }

    public function index()
    {
        $data['title'] = 'Neuro - Panel de administracion';
        $data['active'] = 'recent';
        $data['script'] = 'file.js';
        $carpetas = $this->model->getCarpetas($this->id_usuario);
        $data['archivos'] = $this->model->getArchivos($this->id_usuario);

        for ($i = 0; $i < count($data['archivos']); $i++) {
            $data['archivos'][$i]['fecha'] = time_ago(strtotime($data['archivos'][$i]['fecha_create']));
        }

        for ($i = 0; $i < count($carpetas); $i++) {
            $carpetas[$i]['color'] = substr(md5($carpetas[$i]['id']), 0, 6);
            $carpetas[$i]['fecha'] = time_ago(strtotime($carpetas[$i]['fecha_create']));
        }
        $data['carpetas'] = $carpetas;
        $this->views->getView('admin', 'eliminados', $data);
    }

    public function crearcarpeta()
    {
        $nombre = $_POST['nombre'];

        if (empty($nombre)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'El nombre es requerido');
        } else {
            $vericacionNombre = $this->model->verificar('nombre', $nombre, $this->id_usuario);
            if (empty($vericacionNombre)) {
                $data = $this->model->crearCarpeta($nombre, $this->id_usuario);
                if ($data > 0) {
                    $res = array('tipo' => 'success', 'mensaje' => 'Carpeta Creada');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'Error al Crear el Carpeta');
                }
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'La Carpeta ya existe');
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    //sube el archivo a la bbdd
    public function subirarchivo(){
        $id_carpeta = (empty($_POST['id_carpeta'])) ? (-1) : $_POST['id_carpeta'];
        $archivo = $_FILES['file'];
        $name = $archivo['name'];
        $type = $archivo['type'];
        $tmp_name = $archivo['tmp_name'];

        //si id carpeta es -1 es porque no se ha pasado ninguna carpeta
        if($id_carpeta == -1){
            //se buscará la primera carpeta que creó el usuario
            $id_carpeta = $this->model->getFirstCarpeta($this->id_usuario);
            if(empty($id_carpeta)){
                //si el resultado es vacio se creara 1 carpeta default al usuario
                $id_carpeta = $this->model->crearCarpeta('default', $this->id_usuario);
            }
            //una vez recogido el id_carpeta se subirá el archivo a la carpeta
        }
        $data = $this->model->subirArchivo($name, $type,  $id_carpeta);
        //si lo sube correctamente se guardará el archivo en un carpeta local
        if ($data > 0) {
            $destino = 'Assets/archivos';
            if(!file_exists($destino)){
                mkdir($destino);
            }
            $carpeta = $destino .'/' .$id_carpeta;
            if(!file_exists($carpeta)){
                mkdir($carpeta);
            }

            move_uploaded_file($tmp_name, $carpeta .'/'.$name);
            $res = array('tipo' => 'success', 'mensaje' => 'Archivo Subido');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al Subir el Archivo');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    //ver archivos
    public function ver($id_carpeta){
        $data['active'] = 'detalle';
        $data['title'] = 'Neuro - Archivos';
        //$data['script'] = 'file.js';
        $data['archivos'] = $this->model->getArchivos($id_carpeta, $this->id_usuario);
        $this->views->getView('admin', 'archivos', $data);
    }

  


}
