<?php 
//Obtenemos los datos del formulario como un JSON
$data = json_decode(file_get_contents('php://input'), true);

//Llamamos a los daos necesarios para trbajar con la entidad cliente
require_once '../dao/ClientDAO.php';
require_once '../entities/Client.php';
require_once '../entities/User.php';
require_once '../dao/UserDAO.php';

//Nombre de la BBDD que necesitamos
$base = "svc";

//Definimos la instancia del dao de clientes
$daoclient = new DaoClient($base);
$daouser = new DaoUser($base);

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

$user = new User();
$user->__set("email", $data['email']);
$user->__set("password", $clientpassword);
$user->__set("role", "client");

//Insertamos el nuevo cliente en la BBDD con el dao
$daoclient->insertClient($client);
$daouser->insertUser($user);

echo 'Registro exitoso';
?>