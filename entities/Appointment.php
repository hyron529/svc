<?php

//Creación de la clase citas, donde definimos todos sus atributos
//para poder trabajar con ellos
class Appointment{

    private $id;
    private $title;
    private $description;
    private $date;
    private $idClient;
    private $emailBrand;
    private $type;

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name,  $value) {
        return $this->$name = $value;
    }
}

?>