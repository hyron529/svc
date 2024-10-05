<?php

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