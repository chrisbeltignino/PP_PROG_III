<?php
namespace Tignino_Christian
{
    require_once "AccesoDatos.php";
    require_once "auto.php";
    require_once "IParte1.php";
    require_once "IParte2.php";
    require_once "IParte3.php";

    use Tignino_Christian\Auto;
    use Tignino_Christian\IParte1;
    use Tignino_Christian\IParte2;
    use Tignino_Christian\IParte3;
    use POO\AccesoDatos;
    use stdClass;
    use PDO;

    //autoBD.php. Crear, en ./clases, la clase AutoBD (hereda de Auto) con atributo protegido: pathFoto(cadena)
    class AutoBD extends Auto implements IParte1 , IParte2 , IParte3
    {
        protected $pathFoto;

        /*Un constructor (con parámetros opcionales), un método de instancia toJSON(), que retornará los datos de la instancia (en una cadena con formato JSON).
        */
        public function __construct(string $patente, string $marca, string $color, float $precio, string $pathFoto = "")
        {
            parent::__construct($patente,$marca,$color,$precio);
            $this->pathFoto = $pathFoto;
        }

        public function SetFoto(string $foto)
        {
            $this->pathFoto = $foto;
        }
        public function GetPatente()
        {
            return $this->patente;
        }
        public function GetMarca()
        {
            return $this->marca;
        }
        public function GetColor()
        {
            return $this->color;
        }
        public function GetPrecio()
        {
            return $this->precio;
        }
        public function GetFoto()
        {
            return $this->pathFoto;
        }

        /*
        ● agregar: agrega, a partir de la instancia actual, un nuevo registro en la tabla autos (patente, marca, color, precio, foto), de la base de datos garage_bd. 
                   Retorna true, si se pudo agregar, false, caso contrario.
        */
        public function agregar(): bool
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $query = $objetoAccesoDato->retornarConsulta("INSERT INTO autos(patente, marca, color, precio, foto) 
                                                                     VALUES(:patente, :marca, :color, :precio, :foto)");
            //$stmt = $pdo->prepare($query);
            $query->bindValue(':patente', $this->patente, PDO::PARAM_STR);
            $query->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $query->bindValue(':color', $this->color, PDO::PARAM_STR);
            $query->bindValue(':precio', $this->precio, PDO::PARAM_STR);
            $query->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

            $query->execute();

            if($query->rowCount() != 0)
            {
                $retorno = true;
            }
    
            return $retorno;
        }

        /*
        ● traer: este método estático retorna un array de objetos de tipo AutoBD, recuperados de la base de datos.
        */
        public static function traer():array
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $autos = [];

            $query = $objetoAccesoDato->retornarConsulta("SELECT * FROM autos");

            $query->execute();

            while ($row = $query->fetch(PDO::FETCH_ASSOC))
            {
                $auto = new AutoBD($row["patente"], $row["marca"],$row["color"], $row["precio"] );

                if ($row["foto"] != null) 
                {
                    $auto->pathFoto = $row["foto"];
                }

                $autos[] = $auto;
            }
            return $autos; 
        }

        /////////////////////////////////////////----PARTE 2----/////////////////////////////////////////

        /**
         * ● eliminar: este método estático, elimina de la base de datos el registro coincidente con la patente recibida cómo       
         *             parámetro. Retorna true, si se pudo eliminar, false, caso contrario.
         */
        public static function eliminar($patente): bool
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->retornarConsulta("DELETE FROM autos WHERE patente = :patente");

            $consulta->bindValue(":patente", $patente, PDO::PARAM_STR);

            $consulta->execute();

            if ($consulta->rowCount() != 0) {
                $retorno = true;
            }

            return $retorno;
        }

        /**
         * ● modificar: Modifica en la base de datos el registro coincidente con la instancia actual (comparar por patente). Retorna 
         *              true, si se pudo modificar, false, caso contrario.
         */
        public function modificar(): bool
        {
            $retorno = false;
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->retornarConsulta("UPDATE autos SET marca = :marca, color = :color, precio = :precio WHERE patente = :patente");
    
            $consulta->bindValue(':patente', $this->patente, PDO::PARAM_STR);
            $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
          
            
            $consulta->execute();

            if($consulta->rowCount() != 0)
            {
                $retorno = true;
            }
    
            return $retorno;
        }

        /////////////////////////////////////////----PARTE 3----/////////////////////////////////////////

        /**
         * Si se pudo borrar en la base de datos, invocar al método guardarJSON y pasarle cómo parámetro el valor './archivos/autos_eliminados.json'.
         */
        public function guardarEnArchivo() : string
        {
            $path = 'clases/archivos/autos_borrados.txt';
            $carpetaImagenes = './autosBorrados/';

            $archivo = fopen($path, "a");
            $exito = false;
            $mensaje = "No se pudo guardar en el archivo";

            if($archivo != false)
            {
                fwrite($archivo, $this->patente."." .  $this->marca ."." . $this->color."." . $this->precio."." . $this->pathFoto . "\r\n");
                $exito = true;
                $mensaje = "Se guardo correctamente en el archivo";

                // Mover la foto al subdirectorio autosBorrados con el nuevo nombre
                $nuevaUbicacionFoto = $carpetaImagenes . $this->patente . ".borrado." . date("His") . ".jpg";
                if (file_exists($this->pathFoto)) 
                {
                    rename($this->pathFoto, $nuevaUbicacionFoto);
                }
            }
            // Invocar al método guardarJSON con './archivos/autos_eliminados.json'
            $this->guardarJSON('clases/archivos/autos_eliminados.json');

            fclose($archivo);            
            
            return json_encode(array('exito' => $exito, 'mensaje' => $mensaje));
        }

        public static function existe($patente) : bool
        {
            $retorno = false;

            $array = AutoBD::traer();

            foreach($array as $comprobar)
            {
                if($patente == $comprobar->patente)
                {
                    $retorno = true;
                    break;
                }
            }

            return $retorno;
        }

        public static function mostrarBorradosJSON()
        {
            $archivo = "./autos_borrados.txt";
    
            if (file_exists($archivo)) 
            {
                $contenido = file_get_contents($archivo);
        
                if ($contenido) 
                {
                    echo $contenido;
                }
                else 
                {
                    echo "El archivo está vacío.";
                }
            } 
            else 
            {
                echo "El archivo no existe.";
            }
        }   
    }
}
?>