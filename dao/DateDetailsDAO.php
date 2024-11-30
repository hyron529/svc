<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/DateDetails.php';

class DaoDateDetails extends DB {
    //Array para almacenar marcas
    public $datedeatils = array();

    //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
    public function __construct($base) {
        $this->dbname = $base;
    }

    public function getDate($emailBrand) {
        $consulta = "SELECT time FROM date_list WHERE emailBrand=:emailBrand and isOccuped=false";

        $param = array(":emailBrand" => $emailBrand);

        $this->ConsultaDatos($consulta, $param);
    
        return $this->filas[0] ?? null;
    }

    public function occuped($time) {
        $consulta = "UPDATE date_list SET isOccuped=true where time=:time";
    
        $param = array(":time" => $time);
    
        $this->ConsultaSimple($consulta, $param);
      }
}
?>
