<?php

define('CHARSET', 'ANSI');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

require_once("IniciarRepo.php");

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $cs = $_POST["cs"];
    $top = $_POST["top"];
    $query = $_POST["query"];
}else{
    $cs = $_GET["cs"];
    $top = $_GET["top"];
    $query = $_GET["query"];
}

if ($query==""){
    echo json_encode(array("cantidad" => 0, "datos" => array(), "err"=>"Se requiere parametro 'query'"));
    die();
}


if (!isset($Buscador)) {  
    $Buscador = new \Buscador\Buscador;
}

$Buscador->ConfigurarBusqueda( $cs, $top );

echo json_encode($Buscador->Buscar($query,$_SESSION['DatosBuscador']));

?>