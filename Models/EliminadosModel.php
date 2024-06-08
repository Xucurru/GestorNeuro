<?php
class EliminadosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    //Funcion que lista los archivo de 1 carpeta
    public function getArchivos($id_usuario)
    {
        $sql = "SELECT a.* FROM archivos a INNER JOIN carpetas c ON a.id_carpeta = c.id WHERE  c.id_usuario = $id_usuario AND a.estado != 1 ORDER BY a.id DESC";
        return $this->selectAll($sql);
    }

    //Funcion que lista los archivo de 1 usuario y carpeta
    public function getArchivosC($id_usuario, $id_carpeta)
    {
        $sql = "SELECT a.* FROM archivos a INNER JOIN carpetas c ON a.id_carpeta = c.id WHERE  c.id_usuario = $id_usuario AND a.id_carpeta = $id_carpeta AND a.estado != 1 ORDER BY a.id DESC";
        return $this->selectAll($sql);
    }

    //Funcion que lista todas las carpetas de 1 usuario
    public function getcarpetas($id_usuario)
    {
        $sql = "SELECT * FROM carpetas WHERE id_usuario = $id_usuario AND (estado = 1 OR estado = 2) ORDER BY id DESC";
        return $this->selectAll($sql);
    }

    public function getUsuarios($valor)
    {
        $sql = "SELECT * FROM usuarios WHERE (correo LIKE '%".$valor."%' OR nombre LIKE '%".$valor."%') AND (estado = 1 OR estado = 2) LIMIT 10";
        return $this->selectAll($sql);
    }

    //Devuelve el correo de 1 usuario
    public function getUsuario($id_usuario)
    {
        $sql = "SELECT correo FROM usuarios WHERE id = $id_usuario AND (estado = 1 OR estado = 2)";
        return $this->select($sql);
    }

    //Comparte un archivo con otro usuario
    public function compartirArchivo($correo, $id_archivo, $id_usuario)
    {
        $sql = "INSERT INTO detalle_archivos (correo, id_archivo, id_usuario) VALUES (?,?,?)";
        $array = array($correo, $id_archivo, $id_usuario);
        return $this->insertar($sql, $array);
    }

    //Devuelve el id del detalle archivo si el correo y el archivo existen
    public function getDetalle($correo, $id_archivo){
        $sql = "SELECT id FROM detalle_archivos WHERE correo = '$correo' AND id_archivo = $id_archivo";
        return $this->select($sql);
    }

    //devuelve los archivos de 1 carpeta
    public function getArchivosCarpeta($id_carpeta)
    {
        $sql = "SELECT * FROM archivos WHERE  id_carpeta = $id_carpeta";
        return $this->selectAll($sql);
    }

    //devuelve de todos los archivo de una carpeta: el id del detalle, el correo de a quien se a compartido el archivo, el nombre del archivo
    public function getArchivosCompartidos($id_carpeta)
    {
        $sql = "SELECT d.id, d.correo, a.nombre FROM detalle_archivos d INNER JOIN archivos a ON d.id_archivo = a.id WHERE a.id_carpeta = $id_carpeta";
        return $this->selectAll($sql);
    }
    
    public function restaurar($id_archivo, $id_usuario){
        $sql = "UPDATE archivos SET estado = ? WHERE id = ?";
        $datos = array(1, $id_archivo);
        return $this->save($sql, $datos);
    }

    public function eliminarDef($id_archivo, $id_usuario){
        $sql = "DELETE FROM archivos WHERE estado = ? AND id = ?";
        $datos = array(0, $id_archivo);
        return $this->save($sql, $datos);
    }
}

?>
