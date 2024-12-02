<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/User.php';

class DaoUser extends DB {
    //Array para almacenar clientes
    public $users = array();

    //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
    public function __construct($base) {
        $this->dbname = $base;
    }

    public function insertUser($user) {
        $consulta = "INSERT INTO user VALUES (:email, :password, :role)";

        $param = array(
            ":email" => $user->__get('email'),
            ":password" => $user->__get('password'),
            ":role" => $user->__get('role')
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
        $consulta = "SELECT email, role FROM user WHERE email=:email and password=:password";

        $param = array(
            ":email" => $user,
            ":password" => $password
        );

        $this->ConsultaDatos($consulta, $param);

        return $this->filas[0] ?? null;
    }

    public function updatePassword($user, $password) {
        $consulta = "UPDATE USER SET password=:password where email=:email";

        $param = array(
            ":email" => $user,
            ":password" => $password
        );

        $this->ConsultaSimple($consulta, $param);
    }

    public function updateEmail($user, $newEmail) {
        $consulta = "UPDATE USER SET email=:newEmail where email=:email";

        $param = array(
            ":email" => $user,
            ":newEmail" => $newEmail
        );

        $this->ConsultaSimple($consulta, $param);
    }

    public function emailUsed($emailClient) {
        $consulta = "SELECT count(*) as exist FROM user WHERE email=:emailClient";

        $param = array(
            ":emailClient" => $emailClient
        );

        $this->ConsultaDatos($consulta, $param);

        // Comprobamos si existe alguna fila para dicho usuario
        $rowCount = $this->filas[0]['exist'] ?? 0;

        return $rowCount > 0;
    }
}
?>


