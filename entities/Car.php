<?php

//Creación de la clase coche, donde definimos todos sus atributos
//para poder trabajar con ellos
class Car
{

  private $id;
  private $model_name;
  private $fabrication_year;
  private $base_price;
  private $fuel_type;
  private $transmission;
  private $base_color;
  private $trunk_capacity;
  private $power;
  private $autonomy;
  private $num_seats;
  private $car_type;
  private $image;
  private $stock;
  private $emailBrand;

  public function __get($name)
  {
    return $this->$name;
  }

  public function __set($name, $value)
  {
    return $this->$name = $value;
  }
}

?>