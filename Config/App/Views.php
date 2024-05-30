<?php
//la vista gestiona los directorios
class Views{

    public function getView($pagina, $vista, $data="")
    {
        //si la vista es principal se va a la raíz
        if ($pagina == "principal") {
            $vista = "Views/".$vista.".php";
            //sino se crea directorio
        }else{
            $vista = "Views/".$pagina."/".$vista.".php";
        }
        require $vista;
    }
}
?>