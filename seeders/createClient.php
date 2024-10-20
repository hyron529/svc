<?php 
//Obtenemos los datos del formulario como un JSON
$data = json_decode(file_get_contents('php://input'), true);

//Llamamos a los daos necesarios para trbajar con la entidad cliente
require_once '../dao/ClientDAO.php';
require_once '../entities/Client.php';

//Nombre de la BBDD que necesitamos
$base = "svc";

//Definimos la instancia del dao de clientes
$daoclient = new DaoClient($base);

//Definimos salts para encriptar la contraseña
$saltInit = "!@$#";
$saltEnd = "$%&@";

//Encriptamos la contraseña
$clientpassword = sha1($saltInit . $data['password']. $saltEnd);

//Creamos la nueva instancia de cliente y asignamos los valores enviados
//a los atributos del objeto cliente
$client = new Client();
$client->__set("name", $data['name']);
$client->__set("surname", $data['surname']);
$client->__set("birthdate", $data['birthdate']);
$client->__set("nationality", $data['nationality']);
$client->__set("email", $data['email']);
$client->__set("role", "client");
$client->__set("password", $clientpassword);

//Insertamos el nuevo cliente en la BBDD con el dao
$daoclient->insertClient($client);

echo 'Registro exitoso';
?>