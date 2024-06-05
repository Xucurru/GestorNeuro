<?php
class AdminModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    //Funcion que devuelve la primera carpeta de 1 usuario
    public function getFirstCarpeta($id_usuario)
    {
        $sql = "SELECT id FROM carpetas WHERE id_usuario = $id_usuario LIMIT 1";
        return $this->select($sql);
    }

    //Funcion que registra una carpeta en 1 usuario
    public function crearCarpeta($nombre, $id_usuario)
    {
        $sql = "INSERT INTO carpetas (nombre, id_usuario) VALUES (?,?)";
        $datos = array($nombre, $id_usuario);
        return $this->insertar($sql, $datos);
    }

    //Funcion que edita un usuario
    public function modificar($nombre, $apellido, $correo, $telefono, $direccion,  $rol, $id,)
    {
        $sql = "UPDATE usuarios SET nombre=?, apellido=?, correo=?, telefono=?, direccion=?, rol=? WHERE id=?";
        $datos = array($nombre, $apellido, $correo, $telefono, $direccion, $rol, $id);
        return $this->save($sql, $datos);
    }

    //Funcion que lista las 9 ultimas las carpetas de 1 usuario
    public function getcarpetas($id_usuario)
    {
        $sql = "SELECT * FROM carpetas WHERE id_usuario = $id_usuario AND (estado = 1 OR estado = 2) ORDER BY id DESC LIMIT 9";
        return $this->selectAll($sql);
    }

    //Funcion que lista los 10 ultimos archivos de 1 usuario
    public function getArchivosRecientes($id_usuario)
    {
        $sql = "SELECT a.* FROM archivos a INNER JOIN carpetas c ON a.id_carpeta = c.id WHERE (c.id_usuario = $id_usuario) AND (a.estado = 1) ORDER BY a.id DESC LIMIT 10";
        return $this->selectAll($sql);
    }

    //Funcion que lista los archivo de 1 carpeta
    public function getArchivos($id_carpeta, $id_usuario)
    {
        $sql = "SELECT a.* FROM archivos a INNER JOIN carpetas c ON a.id_carpeta = c.id WHERE a.id_carpeta = $id_carpeta AND c.id_usuario = $id_usuario ORDER BY a.id DESC";
        return $this->selectAll($sql);
    }
    //Funcion que devuelve 1 usuario
    public function getUsuario($id)
    {
        $sql = "SELECT id, nombre, apellido, correo, telefono, direccion, rol, perfil, fecha, estado FROM usuarios WHERE id = $id";
        return $this->select($sql);
    }



    //Funcion que verifica que un usuario con tal item esta verificado
    public function verificar($item, $nombre, $id_usuario)
    {
        //Verificando para modificar
        if ($id_usuario > 0) {
            $sql = "SELECT id FROM carpetas WHERE $item = '$nombre' AND id_usuario = $id_usuario AND estado = 1";
            //Verificando para registrar
        } else {
            $sql = "SELECT id FROM carpetas WHERE $item = '$nombre' AND estado = 1";
        }
        return $this->select($sql);
    }

    public function delete($id)
    {
        $sql = "UPDATE carpetas SET estado = ? WHERE id = ?";
        $datos = array(0, $id);
        return $this->save($sql, $datos);
    }

    //subir archivos
    public function subirArchivo($nombre, $tipo, $id_carpeta)
    {
        if(is_array($id_carpeta)){
            $id_carpeta = $id_carpeta['id'];
        }

        $sql = "INSERT INTO archivos (nombre, tipo, id_carpeta) VALUES (?,?, ?)";
        $datos = array($nombre, $tipo, $id_carpeta);
        return $this->insertar($sql, $datos);
    }
}
