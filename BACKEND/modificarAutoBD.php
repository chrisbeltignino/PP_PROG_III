<?php
/**
 * modificarAutoBD.php: Se recibirán por POST los siguientes valores: auto_json (patente, marca, color y precio, en
 *                      formato de cadena JSON) para modificar un auto en la base de datos. Invocar al método modificar.
 */
require_once 'clases/autoBD.php';
use Tignino_Christian\AutoBD;

$obj = json_decode($_POST['auto_json']);

$newauto = new AutoBD($obj->patente, $obj->marca, $obj->color, $obj->precio);

if($newauto->modificar())
{
    echo "Se modifico correctamente";
}else {
    echo "No se modifico correctamente";
}

?>