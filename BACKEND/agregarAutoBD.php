<?php

require_once("./clases/autoBD.php");
use Tignino_Christian\AutoBD;

// Se obtienen los valores recibidos por POST
$patente = isset($_POST['patente']) ? $_POST['patente'] : null;
$marca = isset($_POST['marca']) ? $_POST['marca'] : null;
$color = isset($_POST['color']) ? $_POST['color'] : null;
$precio = isset($_POST['precio']) ? $_POST['precio'] : null;
$foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;

$tipo = explode("/",$foto["type"]);
$tipo = $tipo[1];
$destino = trim('autos/imagenes/') . "." . $marca . "." . date("His") . "." . $tipo; // puede cambiar
move_uploaded_file($foto["tmp_name"], $destino);

if (file_exists($destino)) 
{
    $uploadOk = FALSE; //echo "El archivo ya existe. Verifique!!!";
}
if ($_FILES["foto"]["size"] > 5000000000000 ) 
{
    $uploadOk = FALSE;// echo "El archivo es demasiado grande. Verifique!!!";
}
$tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);
if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif" && $tipoArchivo != "png") 
{ 
    $uploadOk = FALSE;//   echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
}

// Se instancia un objeto de la clase AutoBD
$auto = new AutoBD($patente, $marca, $color, $precio, $destino);

// Se verifica si el auto ya existe en la base de datos
$autos = $auto->traer();

// Se verifica si el auto ya existe
if ($auto->existe($patente)) {
    $mensaje = "El auto ya existe en la base de datos.";
    $existe = false;
} else {
    // Se intenta agregar el nuevo auto
    if ($auto->agregar()) {
        // Se mueve la imagen a la carpeta de imágenes
        $nombreArchivo = $patente . '.' . time() . '.' . pathinfo($foto['name'], PATHINFO_EXTENSION);
        $rutaImagen = "./autos/imagenes/" . $nombreArchivo;
        move_uploaded_file($foto['tmp_name'], $rutaImagen);

        $existe = true;
        $mensaje = "Auto agregado correctamente.";
    } else {
        $mensaje = "No se pudo agregar el auto en la base de datos.";
    }
}

// Se retorna un JSON con el resultado
echo json_encode(array("éxito" => $existe ? false : true, "mensaje" => $mensaje));

/*

$patente = isset($_POST['patente']) ? $_POST['patente'] : null;
$marca = isset($_POST['marca']) ? $_POST['marca'] : null;
$color = isset($_POST['color']) ? $_POST['color'] : null;
$precio = isset($_POST['precio']) ? $_POST['precio'] : null;
$foto = isset($_FILES['foto']) ? $_FILES['foto'] : null;

date_default_timezone_set('America/Argentina/Buenos_Aires');
$tipo = explode("/",$foto["type"]);
$tipo = $tipo[1];
$path = 'autos/imagenes/'; // cambiar path
$destino = trim($path) . "." . $marca . "." . date("His") . "." . $tipo; // puede cambiar
move_uploaded_file($foto["tmp_name"], $destino);

echo $foto["tmp_name"];

if (file_exists($destino)) 
{
    $uploadOk = FALSE; //echo "El archivo ya existe. Verifique!!!";
}
if ($_FILES["foto"]["size"] > 5000000000000 ) 
{
    $uploadOk = FALSE;// echo "El archivo es demasiado grande. Verifique!!!";
}
$tipoArchivo = pathinfo($destino, PATHINFO_EXTENSION);
if($tipoArchivo != "jpg" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif" && $tipoArchivo != "png") 
{ 
    $uploadOk = FALSE;//   echo "Solo son permitidas imagenes con extension JPG, JPEG, PNG o GIF.";
}

$auto = new autoBD($patente, $marca, $color, $precio, $destino);

if($auto->existe($patente))
{
    echo "El auto ya existia.";
}
else
{
    echo "el auto se añadio";
  $auto->agregar();
}
*/
?> 