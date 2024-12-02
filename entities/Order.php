<?php

//Creación de la clase pedido, donde definimos todos sus atributos
//para poder trabajar con ellos
class Order
{

  private $id;
  private $order_date;
  private $idClient;
  private $sent;


  public function __get($name)
  {
    return $this->$name;
  }

  public function __set($name, $value)
  {
    return $this->$name = $value;
  }
}
