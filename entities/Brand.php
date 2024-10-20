<?php

//Creación de la clase marca, donde definimos todos sus atributos
//para poder trabajar con ellos
class Brand{

    private $name;
    private $foundation_date;
    private $country;
    private $headquarter;
    private $email;
    private $website;
    private $password;
    private $role;

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name,  $value) {
        return $this->$name = $value;
    }
}

?>