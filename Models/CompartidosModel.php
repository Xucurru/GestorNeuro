<?php
class CompartidosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    //Funcion que lista los archivos compartidos de 1 usuario
    public function getArchivosCompartidos($correo)
    {
        $sql = "SELECT d.id, d.correo, a.nombre AS archivo, u.nombre FROM detalle_archivos d INNER JOIN archivos a on d.id_archivo = a.id INNER JOIN usuarios u ON d.id_usuario = u.id WHERE d.correo = '$correo' AND d.estado = 1";
        return $this->selectAll($sql);
    }

    //Funcion que lista detalles de 1 archivo compartido
    public function getDetalle($id_detalle)
    {
        $sql = "SELECT d.id, d.fecha_add, d.correo, d.id_archivo, a.nombre , a.id_carpeta, u.correo AS correo_archivo  FROM detalle_archivos d INNER JOIN archivos a on d.id_archivo = a.id INNER JOIN carpetas c ON a.id_carpeta = c.id INNER JOIN usuarios u ON d.id_usuario = u.id WHERE d.id = $id_detalle AND d.estado = 1";
        return $this->select($sql);
    }

    public function delete($id)
    {
        $sql = "UPDATE detalle_archivos SET estado = ? WHERE id = ?";
        $datos = array(0, $id);
        return $this->save($sql, $datos);
    }

}

?>
