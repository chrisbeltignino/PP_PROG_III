<?php
require_once "./clases/auto.php";

use Tignino_Christian\Auto;

$auto = new Auto($_POST["patente"]);

/**$patente = isset($_POST["patente"]) ? $_POST["patente"] : null;
$marca = isset($_POST["marca"]) ? $_POST["marca"] : null;
$color = isset($_POST["color"]) ? $_POST["color"] : null;
$precio = isset($_POST["precio"]) ? $_POST["precio"] : null; */



echo Auto::verificarAutoJSON($auto);

?>