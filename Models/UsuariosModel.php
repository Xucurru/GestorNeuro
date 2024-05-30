<?php
class UsuariosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    //Funcion que registra un nuevo usuario
    public function registrar($nombre, $apellido, $correo, $telefono, $direccion, $clave, $rol )
    {
        $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, clave, rol) VALUES (?,?,?,?,?,?,?)";
        $datos = array($nombre, $apellido, $correo, $telefono, $direccion, $clave, $rol);
        return $this->insertar($sql, $datos);
    }

    //Funcion que edita un usuario
    public function modificar($nombre, $apellido, $correo, $telefono, $direccion,  $rol, $id,)
    {
        $sql = "UPDATE usuarios SET nombre=?, apellido=?, correo=?, telefono=?, direccion=?, rol=? WHERE id=?";
        $datos = array($nombre, $apellido, $correo, $telefono, $direccion, $rol, $id);
        return $this->save($sql, $datos);
        
    }

    //Funcion que lista todos los usuarios
    public function getUsuarios()
    {
        $sql = "SELECT id, nombre, apellido, correo, telefono, direccion, rol, perfil, fecha, estado FROM usuarios WHERE estado = 1 or estado = 2";
        return $this->selectAll($sql);
    }

    //Funcion que devuelve 1 usuario
    public function getUsuario($id)
    {
        $sql = "SELECT id, nombre, apellido, correo, telefono, direccion, rol, perfil, fecha, estado FROM usuarios WHERE id = $id";
        return $this->select($sql);
    }



    //Funcion que verifica que un usuario con tal item esta verificado
    public function verificar($item, $nombre, $id)
    {
        //Verificando para modificar
        if($id > 0){
            $sql = "SELECT id FROM usuarios WHERE $item = '$nombre' AND id !=$id AND estado = 1";
        //Verificando para registrar
        }else{
            $sql = "SELECT id FROM usuarios WHERE $item = '$nombre' AND estado = 1";
        }
        return $this->select($sql);
    }

    public function delete($id)
    {
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $datos = array(0, $id);
        return $this->save($sql, $datos);
    }
}
