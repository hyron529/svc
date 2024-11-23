<?php

//Creación de la clase pedido, donde definimos todos sus atributos
//para poder trabajar con ellos
class OrderDetails
{

  private $quantity;
  private $extra;
  private $color;
  private $id_order;
  private $id_car;


  public function __get($name)
  {
    return $this->$name;
  }

  public function __set($name, $value)
  {
    return $this->$name = $value;
  }
}

