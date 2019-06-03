<?php
require_once("IniciarRepo.php");
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);


if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $cs = $_POST["cs"];
    $top = $_POST["top"];
    $query = $_POST["query"];
}else{
    $cs = $_GET["cs"];
    $top = $_GET["top"];
    $query = $_GET["query"];
}


if (!isset($Buscador)) {  
    $Buscador = new \Buscador\Buscador;
}

$Buscador->ConfigurarBusqueda( $cs, $top );

echo implode("\r\n",$Buscador->Buscar($query,$_SESSION['DatosBuscador']));

?>