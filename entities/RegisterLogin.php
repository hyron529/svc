<?php

//Creación de la clase register, donde vamos a guardar los atributos
//para crear el registro de nuestros usuarios
class RegisterLogin { 
    private $user;
    private $password;
    private $date;
    private $access;

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name,  $value) {
        return $this->$name = $value;
    }

} 

?>