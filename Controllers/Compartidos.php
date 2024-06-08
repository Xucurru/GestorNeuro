<?php
class Compartidos extends Controller
{
    private $id_usuario;
    private $correo;
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['id'])) {
            header("Location: " . BASE_URL);
            exit();
        }
        $this->id_usuario = $_SESSION['id'];
        $this->correo = $_SESSION['correo'];
    }

    public function index()
    {
        $data['title'] = 'Neuro - Compartidos';
        $data['script'] = 'compartidos.js';
        $data['archivos'] = $this->model->getArchivosCompartidos($this->correo);

        $this->views->getView('admin', 'compartidos', $data);
    }
    public function verDetalle($id_detalle)
    {
        $data = $this->model->getDetalle($id_detalle);
        $data['fecha'] = time_ago(strtotime($data['fecha_add']));
        echo json_encode($data);
        die();
    }

    //Elimina un compartido por el id
    public function delete($id)
    {
        $data = $this->model->delete($id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'El archivo se ha dejado de compartir');
            echo json_encode($res);
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al dejar de compartir el archivo');
            echo json_encode($res);
        }
        die();
    }
}
