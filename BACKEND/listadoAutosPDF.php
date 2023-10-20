<?php
/**
* ---------------------------------------------------------Parte 4----------------------------------------------------------------
* En el directorio raíz del proyecto, agregar la siguiente página:
*
* listadoAutosPDF.php: (GET) Generar un listado de los autos de la base de datos y mostrarlo con las siguientes características:
*        ● Encabezado (apellido y nombre del alumno a la izquierda y número de página a la derecha).
*        ● Cuerpo (Título del listado, listado completo de los autos con su respectiva foto).
*        ● Pie de página (fecha actual, centrada).
 */
require __DIR__ . '/../vendor/autoload.php'; // Asegúrate de incluir la librería FPDF

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Tabla de BD',0,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

// Carga de datos
function cargarDatos($datos) {
    $this->SetFont('Arial','B',12);
    // Agregar título
    $this->Cell(0,10,'Listado de Autos',0,1,'L');
    // Encabezados
    $this->Cell(50,10,'Patente',1,0,'C');
    $this->Cell(50,10,'Marca',1,0,'C');
    $this->Cell(40,10,'Color',1,0,'C');
    $this->Cell(50,10,'Precio',1,1,'C');
    // Datos
    foreach($datos as $row) {
        $this->Cell(50,10,$row['patente'],1,0,'C');
        $this->Cell(50,10,$row['marca'],1,0,'C');
        $this->Cell(40,10,$row['color'],1,0,'C');
        $this->Cell(50,10,$row['precio'],1,1,'C');
    }
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$datos = array(
    array('patente' => 'AYF714', 'marca' => 'Renault', 'color' => 'gris', 'precio' => 150000),
    array('patente' => 'TOC623', 'marca' => 'Fiat', 'color' => 'blanco', 'precio' => 198000),
    array('patente' => 'AB555DC', 'marca' => 'Ford', 'color' => 'verde', 'precio' => 256900),
    array('patente' => 'AA666AA', 'marca' => 'Chevrolet', 'color' => 'rojo', 'precio' => 323200)
); // Debes reemplazar esto con la data obtenida de la base de datos

$pdf->cargarDatos($datos);
$pdf->Output('F', 'listadoAutos.pdf');
?>