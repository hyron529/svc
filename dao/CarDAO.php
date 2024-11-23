<?php
//Incluimos las librerías que necesitamos para gestionar los daos del car
require_once '../bd/libreriaPDO.php';
require_once '../entities/Car.php';

class DaoCar extends DB
{
  //Array para almacenar clientes
  public $cars = array();

  //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
  public function __construct($base)
  {
    $this->dbname = $base;
  }

  public function getCars()
  {
    $consulta = "SELECT * FROM car";

    $this->cars = array();

    $this->ConsultaDatos($consulta);


    foreach ($this->filas as $row) {
      $car = new Car();

      $car->__set("id", $row["id"]);
      $car->__set("model_name", $row["model_name"]);
      $car->__set("fabrication_year", $row["fabrication_year"]);
      $car->__set("base_price", $row["base_price"]);
      $car->__set("fuel_type", $row["fuel_type"]);
      $car->__set("transmission", $row["transmission"]);
      $car->__set("base_color", $row["base_color"]);
      $car->__set("power", $row["power"]);
      $car->__set("autonomy", $row["autonomy"]);
      $car->__set("num_seats", $row["num_seats"]);
      $car->__set("car_type", $row["car_type"]);
      $car->__set("image", $row["image"]);
      $car->__set("stock", $row["stock"]);
      $car->__set("emailBrand", $row["emailBrand"]);

      $this->cars[] = $car;
    }
  }

}
?>
