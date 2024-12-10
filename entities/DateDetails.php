<?php

//Creación de la clase date details, donde definimos todos sus atributos
//para poder trabajar con ellos
class DateDetails
{

  private $id;
  private $time;
  private $isOccuped;
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