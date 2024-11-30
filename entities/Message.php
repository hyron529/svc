<?php

//Creación de la clase message, donde definimos todos sus atributos
//para poder trabajar con ellos
class Message
{

  private $id;
  private $message;
  private $id_appointment;  
  private $sender;
  private $role;

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