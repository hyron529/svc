<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/Color.php';

class DaoColor extends DB
{
  //Array para almacenar clientes
  public $colors = array();

  //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
  public function __construct($base)
  {
    $this->dbname = $base;
  }

  public function getColor($colorid) {
    $consulta = "SELECT name, price FROM color WHERE id=:colorid";
   
    $param = array(
      ":colorid" => $colorid
    );

    $this->ConsultaDatos($consulta, $param);

    return $this->filas[0] ?? null;
  }

  public function getColors($emailBrand) {
    $consulta = "SELECT * FROM color WHERE emailBrand=:emailBrand";

    $param = array(":emailBrand" => $emailBrand);

    $this->colors = array();

    $this->ConsultaDatos($consulta, $param);

    foreach ($this->filas as $row) {
      $color = new Color();

      $color->__set("id", $row["id"]);
      $color->__set("name", $row["name"]);
      $color->__set("price", $row["price"]);
      $color->__set("emailBrand", $row["emailBrand"]);
      
      $this->colors[] = $color;
    }
  }

  public function colorInsert($color) {
    $consulta = "INSERT INTO color VALUES (null, :name, :price, :emailBrand)";

    $param = array(
        ":name" => $color->__get('name'),
        ":price" => $color->__get('price'),
        ":emailBrand" => $color->__get('emailBrand')
    );

    $this->ConsultaSimple($consulta, $param);
  }

  
  public function deletecolor($id) {
    $consulta = "DELETE FROM color WHERE id=:id";

    $param = array(
        ":id" => $id
    );

    $this->ConsultaSimple($consulta, $param);
  }
}
?>

