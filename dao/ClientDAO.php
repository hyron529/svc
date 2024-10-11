<?php
require_once '../bd/libreriaPDO.php';
require_once '../entities/Client.php';

class DaoClient extends DB {
    public $clients = array();

    public function __construct($base) {
        $this->dbname = $base;
    }

    public function insertClient($client) {
        $consulta = "INSERT INTO client VALUES (:name, :surname, :birthdate, :nationality, :email, :role, :password)";

        $param = array(
            ":name" => $client->__get('name'),
            ":surname" => $client->__get('surname'),
            ":birthdate" => $client->__get('birthdate'),
            ":nationality" => $client->__get('nationality'),
            ":email" => $client->__get('email'),
            ":role" => $client->__get('role'),
            ":password" => $client->__get('password')
        );

        $this->ConsultaSimple($consulta, $param);
    }


    public function login($user, $password){
        $consulta = "SELECT email, role FROM client WHERE email=:email and password=:password";

        $param = array(
            ":email" => $user,
            ":password" => $password
        );

        $this->ConsultaDatos($consulta, $param);

        return $this->filas[0] ?? null;
    }
}
?>

