<?php
require_once("clases/autoBD.php");
use Tignino_Christian\AutoBD;

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $autoJson = $_POST['auto_json'];

    $autoData = json_decode($autoJson, true);

    // Crear una instancia de autoBD
    $auto = new AutoBD(
        $autoData['patente'],
        $autoData['marca'],
        $autoData['color'],
        $autoData['precio'],      
        $autoData['pathFoto']
    );

    if ($auto->eliminar($autoData['patente'])) 
    {
        $resultado = $auto->guardarEnArchivo();
        echo $resultado;
    } else {
        echo json_encode(array('exito' => false, 'mensaje' => 'No se pudo eliminar el auto de la base de datos.'));
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener y mostrar los autos borrados en una tabla HTML con sus respectivas imágenes
    $autos = AutoBD::traer();
    echo "<table border='1'>
    <tr>
    <th>Patente</th>
    <th>Marca</th>
    <th>Color</th>
    <th>Precio</th>
    <th>Imagen</th>
    </tr>";

    foreach ($autos as $auto) {
        echo "<tr>";
        echo "<td>" . $auto->GetPatente() . "</td>";
        echo "<td>" . $auto->GetMarca() . "</td>";
        echo "<td>" . $auto->GetColor() . "</td>";
        echo "<td>" . $auto->GetPrecio() . "</td>";
        if ($auto->GetFoto() !== null) {
            echo "<td><img src='" . $auto->GetFoto() . "' style='width:50px;height:50px;'></td>";
        } else {
            echo "<td>No hay imagen disponible</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>