<?php

//Creación de la clase extra, donde definimos todos sus atributos
//para poder trabajar con ellos
class Extra
{

  private $id;
  private $name;
  private $price;
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