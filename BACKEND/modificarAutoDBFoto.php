<?php
use Tignino_Christian\AutoBD;

require_once 'clases/autoBD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

        $autoJson = $_POST['auto_json'];

        $autoData = json_decode($autoJson, true);

        $foto = $_FILES['foto'];
        $fotoTmp = $foto['tmp_name'];

        $pathFoto = isset($autoData['pathFoto']) ? $autoData['pathFoto'] : '';

        
        $auto = new AutoBD(
            $autoData['marca'],
            $autoData['patente'],
            $autoData['color'],
            $autoData['precio'],
           
            $pathFoto
        );

        $exitoModificar = $auto->modificar();

        if ($exitoModificar) {
           
            $rutaFotoOriginal = $auto->$pathFoto;
            $nombreFotoModificada = $autoData['patente']  . '.modificado.' . date('His') . '.jpg';
            $rutaFotoModificada = './autosModificados/' . $nombreFotoModificada;  
            
            if (move_uploaded_file($fotoTmp, $rutaFotoModificada)) {
                
                unlink($rutaFotoOriginal);
                
                echo json_encode(array('exito' => true, 'mensaje' => 'auto modificado exitosamente.'));
            } else {
                echo json_encode(array('exito' => false, 'mensaje' => 'No se pudo mover la foto.'));
            }
        } else {
            echo json_encode(array('exito' => true, 'mensaje' => 'se pudo modificar el auto en la base de datos.'));
        }
    } else {
        echo json_encode(array('exito' => true, 'mensaje' => 'Se ha subido  foto.'));
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    // Se obtienen los autos modificados de la base de datos
    $autosModificados = AutoBD::traer();

    // Se muestra la información de los autos modificados y sus imágenes en una tabla HTML
    echo "<table border='1'>";
    echo "<tr><th>Patente</th><th>Marca</th><th>Color</th><th>Precio</th><th>Foto</th></tr>";

    foreach ($autosModificados as $auto) {
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