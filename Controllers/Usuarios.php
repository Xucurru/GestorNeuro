<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {
        $data['title'] = 'Gestion de Usuarios';
        $data['script'] = 'usuarios.js';
        $this->views->getView('usuarios', 'index', $data);
    }

    //Lista todos los usuariosC
    public function listar()
    {
        $data = $this->model->getUsuarios();

        for ($i = 0; $i < count($data); $i++) {
            //El admin no se puede eliminar
            if ($data[$i]['estado'] == 2) {
                $data[$i]['acciones'] = 'ADMIN';
            } else {
                $data[$i]['acciones'] = '<div>
                 <a href="#" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')">
                     <span class="material-icons">edit</span>
                 </a>
                 <a href="#" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')">
                     <span class="material-icons">delete</span>
                 </a>
             </div>';
            }
            $data[$i]['nombres'] = $data[$i]['nombre'] . ' ' . $data[$i]['apellido'];
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    //Regsitra un nuevo usuario
    public function guardar()
    {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);
        $rol = $_POST['rol'];
        $id_usuario = $_POST['id_usuario'];

        //Todos los campos existen
        if (empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($direccion) || empty($clave) || empty($rol)) {
            $res = array('tipo' => "warning", 'mensaje' => "TODOS LOS CAMPOS SON REQUERIDOS");
        } else {
            //Si id_usuario esta vacio se registra
            if (empty($id_usuario)) {
                //Verificion de correo
                $vericacionCorreo = $this->model->verificar('correo', $correo, 0);
                if (empty($vericacionCorreo)) {
                    //Verificacion de telefono
                    $vericacionTelefono = $this->model->verificar('telefono', $telefono, 0);
                    if (empty($vericacionTelefono)) {
                        //Si la comprobacion es exitosa guardamos un nuevo usuario
                        $data = $this->model->registrar($nombre, $apellido, $correo, $telefono, $direccion, $clave, $rol);
                        if ($data > 0) {
                            $res = array('tipo' => 'success', 'mensaje' => 'Nuevo Usuario Registrado Correctamente');
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Error al Registrar Nuevo Usuario');
                        }
                    } else {
                        $res = array('tipo' => 'warning', 'mensaje' => 'El telefono ya existe');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El correo ya existe');
                } //Sino esta id_usuario vacio se edita
            } else {
                //Verificion de correo
                $vericacionCorreo = $this->model->verificar('correo', $correo, $id_usuario);
                if (empty($vericacionCorreo)) {
                    //Verificacion de telefono
                    $vericacionTelefono = $this->model->verificar('telefono', $telefono, $id_usuario);
                    if (empty($vericacionTelefono)) {
                        //Si la comprobacion es exitosa guardamos un nuevo usuario
                        $data = $this->model->modificar($nombre, $apellido, $correo, $telefono, $direccion, $rol, $id_usuario);
                        if ($data == 1) {
                            $res = array('tipo' => 'success', 'mensaje' => 'Usuario Modificado Correctamente');
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Error al Modificar el Usuario');
                        }
                    } else {
                        $res = array('tipo' => 'warning', 'mensaje' => 'El telefono ya existe');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El correo ya existe');
                }
            }
        }
        echo json_encode($res);
        die();
    }
    //Edita un usuario por el id
    public function editar($id)
    {
        $data = $this->model->getUsuario($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Elimina un usuario por el id
    public function delete($id)
    {
        $data = $this->model->delete($id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Usuario dado de Baja');
            echo json_encode($res);
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al eliminar el usuario');
            echo json_encode($res);
        }
        die();
    }
}
