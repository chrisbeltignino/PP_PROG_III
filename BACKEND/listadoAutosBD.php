<!DOCTYPE html>
<html>
<head>
    <title>Listado de Autos</title>
</head>
<body>
    <h1>Listado de Autos</h1>
    <table border="1">
        <tr>
            <th>Patente</th>
            <th>Marca</th>
            <th>Color</th>
            <th>Precio</th>
            <th>Foto</th>
        </tr>
        <?php
        /**
         *listadoAutosBD.php: (GET) Se mostrará el listado completo de los autos (obtenidos de la base de datos) en una tabla (HTML con cabecera). Invocar al método traer.
         */

        require_once "clases/autoBD.php";

        use Tignino_Christian\AutoBD;

        $autos = AutoBD::traer();

        foreach ($autos as $auto) {
            echo "<tr>";
            echo "<td>" . $auto->GetPatente() . "</td>";
            echo "<td>" . $auto->GetMarca() . "</td>";
            echo "<td>" . $auto->GetColor() . "</td>";
            echo "<td>" . $auto->GetPrecio() . "</td>";
            echo "<td><img src='" . $auto->GetFoto() . "' alt='Foto del neumático'></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>