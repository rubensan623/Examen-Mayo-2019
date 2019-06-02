<?php
session_start();

require_once("Buscador.php");
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);
error_reporting(1);
ini_set('memory_limit', '-1');

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $cs = $_POST["cs"];
    $top = $_POST["top"];
    $query = $_POST["query"];
}else{
    $cs = $_GET["cs"];
    $top = $_GET["top"];
    $query = $_GET["query"];
}

$Buscador = new \Buscador\Buscador;

if (!isset($_SESSION['DatosBuscador'])) {  
    $_SESSION['DatosBuscador'] = $Buscador->cargarDatos('D:\palabras.txt');
}

$Buscador->ConfigurarBusqueda( $cs, $top );

echo implode("\r\n",$Buscador->Buscar($query,$_SESSION['DatosBuscador']));

?>