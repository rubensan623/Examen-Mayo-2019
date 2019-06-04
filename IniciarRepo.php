<?php
error_reporting(0);
session_start();
require_once("Buscador.php");



ini_set('memory_limit', '-1');

if (!isset($_SESSION['DatosBuscador'])) {
    $Buscador = new \Buscador\Buscador;
    $_SESSION['DatosBuscador'] = $Buscador->cargarDatos('D:\palabras.txt');
    echo "Repositorio Cargado en Memoria";
} 


?>