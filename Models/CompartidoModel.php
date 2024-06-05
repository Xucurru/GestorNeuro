<?php
class CompartidoModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    //Funcion que lista los archivo de 1 carpeta
    public function getArchivos($id_usuario)
    {
        $sql = "SELECT a.*, d.fecha_add, d.correo FROM archivos a INNER JOIN detalle_archivos d ON a.id = d.id_archivo WHERE  d.id_usuario = 1 AND a.estado = 1 ORDER BY a.id DESC";
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
    
}

?>
