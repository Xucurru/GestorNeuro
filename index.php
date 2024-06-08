<?php
//carga la configuracion de la bbdd
require_once 'Config/Config.php';
//carga las funciones reutilizables
require_once 'Config/Functions.php';
//carga la vista
$ruta = !empty($_GET['url']) ? $_GET['url'] : "principal/index";
$array = explode("/", $ruta);
$controller = ucfirst($array[0]);
$metodo = "index";
$parametro = "";
if (!empty($array[1])) {
    if ($array[1] != "") {
        $metodo = $array[1];
    }
}
if (!empty($array[2])) {
    if ($array[2] != "") {
        for ($i = 2; $i < count($array); $i++) {
            $parametro .= $array[$i] . ",";
        }
        $parametro = trim($parametro, ",");
    }
}
//carga la configuracion de la app
require_once 'Config/App/Autoload.php';
//carga los controladores
$dirControllers = "Controllers/" . $controller . ".php";
if (file_exists($dirControllers)) {
    require_once $dirControllers;
    $controller = new $controller();
    if (method_exists($controller, $metodo)) {
        $controller->$metodo($parametro);
    } else {
        echo 'No existe el modelo';
        header("Location: $BASE_URL/GestorNeuro/errorpage");
        exit();
    }
} else {
    echo 'No existe el controlador';
    header("Location: $BASE_URL/GestorNeuro/errorpage");
    exit();
}
