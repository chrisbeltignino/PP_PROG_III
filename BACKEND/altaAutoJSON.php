<?php
/*altaAutoJSON.php: Se recibe por POST la patente, la marca, el color y el precio. Invocar al método guardarJSON y
pasarle './archivos/autos.json' cómo parámetro.
*/
require_once "./clases/auto.php";

use Tignino_Christian\Auto;

$a = new Auto($_POST["patente"],$_POST["marca"],$_POST["color"],$_POST["precio"]);

echo $a->guardarJSON("clases/archivos/autos.json");
?>