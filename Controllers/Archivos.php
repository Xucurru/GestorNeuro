<?php
class Archivos extends Controller
{
    private $id_usuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->id_usuario = $_SESSION['id'];
    }

    public function index()
    {
        $data['title'] = 'Neuro - Archivos';
        $data['active'] = 'todos';
        $data['script'] = 'file.js';
        $data['archivos'] = $this->model->getArchivos($this->id_usuario);


        $carpetas = $this->model->getCarpetas($this->id_usuario);
        for ($i = 0; $i < count($carpetas); $i++) {
            $carpetas[$i]['color'] = substr(md5($carpetas[$i]['id']), 0, 6);
            $carpetas[$i]['fecha'] = time_ago(strtotime($carpetas[$i]['fecha_create']));
        }
        $data['carpetas'] = $carpetas;

        $this->views->getView('archivos', 'index', $data);
    }

    public function getUsuarios()
    {
        $valor = $_GET['q'];
        $data = $this->model->getUsuarios($valor);
        $res = 0;
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['text'] = $data[$i]['nombre'] . ' - ' . $data[$i]['correo'];
        }
        echo json_encode($data);
        die();
    }

    public function compartir()
    {
        $usuarios = $_POST['usuarios'];
        //Verificar que se envia 1 archivo
        if (empty($_POST['archivos'])) {
            echo json_encode($res = array('tipo' => 'warning', 'mensaje' => 'Debes seleccionar al menos 1 archivo'));
        } else {
            //Compartimos cada archivo enviado a cada correo enviado
            $archivos = $_POST['archivos'];
            
            $res = 0;
            for ($i=0; $i < count($archivos); $i++) { 
                    $id_archivo = $archivos[$i];
                for ($e = 0; $e < count($usuarios); $e++) {
                    $dato = $this->model->getUsuario($usuarios[$e]);
                    $res = $this->model->getDetalle($dato['correo'], $id_archivo);
                    //Si res esta vacio se registra un nuevo detalle_archivo
                    if (empty($res)) {
                        $res = $this->model->compartirArchivo($dato['correo'], $id_archivo, $this->id_usuario);
                    } else {
                        $res = array('tipo' => 'warning', 'mensaje' => 'El archivo ' .'ya se ha compartido con ' . $dato['correo']);
                        echo json_encode($res);
                        die();
                    }
                }
            }
            if ($res > 0) {
                echo json_encode($res = array('tipo' => 'success', 'mensaje' => 'Archivo Compartido'));
            } else {
                echo json_encode($res = array('tipo' => 'error', 'mensaje' => 'Error al Compartir'));
            }
        }
    }

    public function verArchivos($id_carpeta)
    {   
        $data = $this->model->getArchivosCarpeta($id_carpeta);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function verDetalle($id_carpeta)
    {   
        $data = $this->model->getArchivosCompartidos($id_carpeta);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
