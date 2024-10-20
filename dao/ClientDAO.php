<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/Client.php';

class DaoClient extends DB {
    //Array para almacenar clientes
    public $clients = array();

    //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
    public function __construct($base) {
        $this->dbname = $base;
    }

    /*  
        Método para insertar un cliente en la BBDD
        Realizamos la consulta que nos va a permitor insertar nuevos clientes
        Asignamos los valores del cliente a los parámetros definidos en la consulta
        Finalmente, llamamos a consultaSimple para ejecutar la consulta y realizar la inserción 
    */
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

    /*
        Método que nos va a permitir iniciar sesión
        Definimos la consulta para poder buscar a un cliente en la BBDD
        Pasamos los parámetros de la consulta y la ejecutamos
        Devolvemos la primera fila encontrada o null si no encuentra nada
    */
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

