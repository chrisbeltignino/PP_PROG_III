<?php
namespace Tignino_Christian
{
    /*
    Crear, en ./clases, la interface IParte1. Esta interface poseerá los métodos:
    ● agregar: agrega, a partir de la instancia actual, un nuevo registro en la tabla autos (patente, marca, color, precio, foto), de la base de datos garage_bd. Retorna true, si se pudo agregar, false, caso contrario. 
    ● traer: este método estático retorna un array de objetos de tipo AutoBD, recuperados de la base de datos.
    */
    interface IParte1
    {
        public function agregar():bool;

        public static function traer():array;
    }
}
?>