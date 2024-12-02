<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/Client.php';

class DaoClient extends DB
{
  //Array para almacenar clientes
  public $clients = array();

  //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
  public function __construct($base)
  {
    $this->dbname = $base;
  }

  /*  
      Método para insertar un cliente en la BBDD
      Realizamos la consulta que nos va a permitir insertar nuevos clientes
      Asignamos los valores del cliente a los parámetros definidos en la consulta
      Finalmente, llamamos a consultaSimple para ejecutar la consulta y realizar la inserción 
  */
  public function insertClient($client)
  {
    $consulta = "INSERT INTO client VALUES (:name, :surname, :birthdate, :nationality, :email, :id)";

    $param = array(
      ":name" => $client->__get('name'),
      ":surname" => $client->__get('surname'),
      ":birthdate" => $client->__get('birthdate'),
      ":nationality" => $client->__get('nationality'),
      ":email" => $client->__get('email'),
      ":id" => $client->__get('id')
    );

    $this->ConsultaSimple($consulta, $param);
  }

  public function getClientCode($emailClient) {
    $consulta = "SELECT id FROM client WHERE email=:emailClient";

    $param = array(
      ":emailClient" => $emailClient
    );

    $this->ConsultaDatos($consulta, $param);

    return $this->filas[0] ?? null;
  }

  public function updateEmail($user, $newEmail) {
    $consulta = "UPDATE client SET email=:newEmail where email=:email";

    $param = array(
        ":email" => $user,
        ":newEmail" => $newEmail
    );

    $this->ConsultaSimple($consulta, $param);
  }
}
?>

