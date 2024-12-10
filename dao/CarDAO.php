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

  public function getCar($idCar) {
    $consulta = "SELECT emailBrand , model_name, image, base_price FROM car WHERE id=:idcar";
   
    $param = array(
      ":idcar" => $idCar
    );

    $this->ConsultaDatos($consulta, $param);

    return $this->filas[0] ?? null;
  }

  public function getCars($model)
  {
    $consulta = "SELECT * FROM car";
    $param = array();

    if($model != "") {
      $consulta .= " WHERE model_name LIKE :model ";
      $param[':model'] = $model."%";
    }

    $this->cars = array();

    $this->ConsultaDatos($consulta, $param);

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


  public function getCarsBrand($emailBrand)
  {
    $consulta = "SELECT * FROM car WHERE emailBrand=:emailBrand";

    $this->cars = array();

    $param = array(":emailBrand" => $emailBrand);

    $this->ConsultaDatos($consulta, $param);


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

  public function deleteCar($id) {
    $consulta = "DELETE FROM car WHERE id=:id";

    $param = array(
        ":id" => $id
    );

    $this->ConsultaSimple($consulta, $param);
  }

  public function insertCar($car) {
    $consulta = "INSERT INTO car VALUES (null, :model_name, :fabrication_year, :base_price, :fuel_type, :transmission, :base_color, :power, :autonomy, :trunk_capacity, :num_seats, :car_type, :emailBrand, :image, :stock)";

    $param = array(
        ":model_name" => $car->__get('model_name'),
        ":fabrication_year" => $car->__get('fabrication_year'),
        ":base_price" => $car->__get('base_price'),
        ":fuel_type" => $car->__get('fuel_type'),
        ":transmission" => $car->__get('transmission'),
        ":base_color" => $car->__get('base_color'),
        ":power" => $car->__get('power'),
        ":autonomy" => $car->__get('autonomy'),
        ":trunk_capacity" => $car->__get('trunk_capacity'),
        ":num_seats" => $car->__get('num_seats'),
        ":car_type" => $car->__get('car_type'),
        ":emailBrand" => $car->__get('emailBrand'),
        ":image" => $car->__get('image'),
        ":stock" => $car->__get('stock')
    );

    $this->ConsultaSimple($consulta, $param);
  }



  public function deleteStock ($quantity, $id) {
    $consulta = "UPDATE car SET stock = stock - :quantity WHERE id=:id AND stock > 0;";

    $param = array(
      ":id" => $id,
      ":quantity" => $quantity,
    );

    $this->ConsultaSimple($consulta, $param);
  }
}
?>
