<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/Extra.php';

class DaoExtra extends DB
{
  //Array para almacenar clientes
  public $extras = array();

  //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
  public function __construct($base)
  {
    $this->dbname = $base;
  }

  public function getExtra($extraId) {
    $consulta = "SELECT name, price FROM extra WHERE id=:extraId";
   
    $param = array(
      ":extraId" => $extraId
    );

    $this->ConsultaDatos($consulta, $param);

    return $this->filas[0] ?? null;
  }

  public function getExtras($emailBrand) {
    $consulta = "SELECT * FROM extra WHERE emailBrand=:emailBrand";

    $param = array(":emailBrand" => $emailBrand);

    $this->extras = array();

    $this->ConsultaDatos($consulta, $param);

    foreach ($this->filas as $row) {
      $extra = new Extra();

      $extra->__set("id", $row["id"]);
      $extra->__set("name", $row["name"]);
      $extra->__set("price", $row["price"]);
      $extra->__set("emailBrand", $row["emailBrand"]);
      
      $this->extras[] = $extra;
    }
  }
}
?>
