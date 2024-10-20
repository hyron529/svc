<?php

//Creación de la clase usuario, donde definimos todos sus atributos
//para poder trabajar con ellos
class User { 
    private $email;
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