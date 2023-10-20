<?php

require_once "./clases/autoBD.php";
use Tignino_Christian\AutoBD;

$auto_json = isset($_POST["auto_json"]) ? $_POST["auto_json"] : null;

$lectura = json_decode($auto_json, true);

$auto = new AutoBD($lectura["patente"], $lectura["marca"], $lectura["color"], $lectura["precio"]);

if(AutoBD::eliminar($auto->GetPatente()))
{
    echo "Se pudo borrar.";
    $auto->guardarJSON('clases/archivos/autos_eliminados.json'); // cambiar path
}
else
{
    echo "No se pudo borrar.";
}

?>