<?php
class PrincipalModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    //Funcion que comprueba si existe un usuario  validado con un correo
    public function getUsuario($correo){
        return $this->select("SELECT * FROM usuarios WHERE correo = '$correo' AND (estado = 1 or estado = 2)");
    }

    //Funcion que registra un usuario nuevo
    public function registraUsuario($nombre, $apellido, $correo, $telefono, $direccion, $clave){
        $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, clave) VALUES (?,?,?,?,?,?)";
        $datos = array($nombre, $apellido, $correo,$telefono, $direccion, $clave);
        return $this->insertar($sql, $datos);
    }
}

?>