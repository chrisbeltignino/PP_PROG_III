<?php
/**
*verificarAutoBD.php: Se recibe por POST el parámetro obj_auto, que será una cadena JSON (patente), si coincide
*                     con algún registro de la base de datos (invocar al método traer) 
*                     retornará los datos del objeto (invocar al toJSON).Caso contrario, un JSON vacío ({}).
*/
require_once("./clases/autoBD.php");
use Tignino_Christian\AutoBD;

$auto_JSON = isset($_POST['obj_auto']) ? $_POST['obj_auto'] : null;

$lectura = json_decode($auto_JSON, true);

$patente = isset($lectura['patente']) ? $lectura['patente'] : '';

if (AutoBD::existe($patente)) 
{
    echo "Existe.";
} 
else 
{
    echo "No existe.";
}

?>