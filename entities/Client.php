<?php

//Creación de la clase cliente, donde definimos todos sus atributos
//para poder trabajar con ellos
class Client { 
    private $name;
    private $surname;
    private $birthdate;
    private $nationality;
    private $email;
    private $role;
    private $password;

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name,  $value) {
        return $this->$name = $value;
    }

} 

?>