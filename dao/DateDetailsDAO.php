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
        $consulta = "SELECT id, time FROM date_list WHERE emailBrand=:emailBrand and isOccuped=false";

        $param = array(":emailBrand" => $emailBrand);

        $this->ConsultaDatos($consulta, $param);
    
        return $this->filas[0] ?? null;
    }


    public function getDateDetails($emailBrand) {
        $consulta = "SELECT * FROM date_list WHERE emailBrand=:emailBrand";
    
        $param = array(":emailBrand" => $emailBrand);
    
        $this->datedeatils = array();
    
        $this->ConsultaDatos($consulta, $param);
    
        foreach ($this->filas as $row) {
          $date = new DateDetails();
    
          $date->__set("id", $row["id"]);
          $date->__set("time", $row["time"]);
          $date->__set("isOccuped", $row["isOccuped"]);
          $date->__set("emailBrand", $row["emailBrand"]);
          
          $this->datedeatils[] = $date;
        }
    }


    public function occuped($time, $id) {
        $consulta = "UPDATE date_list SET isOccuped=true where time=:time and id=:id";
    
        $param = array(":time" => $time,
        ":id" => $id);

        $this->ConsultaSimple($consulta, $param);
    }

    public function insert($time, $emailBrand) {
        $consulta = "INSERT INTO date_list VALUES(:time, 0, :emailBrand, null)";
        
        $param = array(
            ":time" => $time,
            ":emailBrand" => $emailBrand
        );
    
        $this->ConsultaSimple($consulta, $param);
    }

    public function delete($id) {
        $consulta = "DELETE FROM date_list WHERE id=:id";
    
        $param = array(
            ":id" => $id
        );
    
        $this->ConsultaSimple($consulta, $param);
      }
}
?>
