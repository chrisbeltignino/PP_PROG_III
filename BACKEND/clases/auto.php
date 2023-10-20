<?php 
namespace Tignino_Christian
{
    use stdClass;

    class Auto
    {
        protected string $patente;
        protected string $marca;
        protected string $color;
        protected float $precio;

        public function __construct(string $patente = "", string $marca = "", string $color = "", float $precio = 0)
        {
            $this->patente = $patente;
            $this->marca = $marca;
            $this->color = $color;
            $this->precio = $precio;
        }

        public function GetPatente()
        {
            return $this->patente;
        }

        public function toJSON():string{
            return json_encode(get_object_vars($this));
        }

        //Método de instancia guardarJSON($path), que agregará al auto en el path recibido por parámetro. Retornará un 
        //JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
        public function guardarJSON($path) : string {
            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "Error al guardar.";

            $contenidoActual = self::traerJSON($path);
            $contenidoActual = file_get_contents($path);
            
            $objetosExistente = json_decode($contenidoActual);
            //var_dump($contenidoActual);
            //var_dump($objetosExistente);
            $objetosExistente[] = json_decode($this->toJSON());
            
            $retorno = file_put_contents($path, json_encode($objetosExistente));
            
            if($retorno !== false)
            {
                $obj->exito = true;
                $obj->mensaje = "Guardado con éxito.";
            }

            //fclose($archivo);
            return json_encode($obj);
            
        }

        //Método de clase verificarAutoJSON($auto), que recorrerá el array obtenido del método traerJSON y retornará un
        //JSON que contendrá: existe(bool) y mensaje(string).
        public static function verificarAutoJSON(Auto $auto):string
        {
            $path = "clases/archivos/autos.json";

            $objRta = new stdClass();
            $objRta->exito = false;
            $objRta->mensaje = "No se encontro el auto";

            $arrAutos = Auto::traerJSON($path);
            foreach($arrAutos as $autoAComprobar)
            {
                //var_dump($arrAutos);
                if($auto->GetPatente() == $autoAComprobar->patente)
                {
                    $objRta->exito = true;
                    $objRta->mensaje = 'El auto esta registrado.';
                }
            }

            return json_encode($objRta);
        }

        //Método de clase traerJSON($path), que retornará un array de objetos de tipo auto (recuperados del path).
        public static function traerJSON($path){
            $retorno = array();
            $str = "";
            $ar = fopen($path, "r");

            while(!feof($ar))
            {
                $str = fgets($ar);

                if($str != "")
                {
                    array_push($retorno, json_decode($str));
                }
            }

            fclose($ar);

            return $retorno;
        }

        public static function TraerTodosJSON(string $path)
        {
            $autos = [];
            $ar = fopen($path, "r");

            while (!feof($ar)) 
            {
                $linea = fgets($ar);
                $autos = json_decode($linea);
        
                if (isset($autos)) 
                {
                    $autos[] = $autos;
                }
            }

            fclose($ar);

            return json_encode($autos, JSON_PRETTY_PRINT);
        }
    }
}
?>