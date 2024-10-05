<?php 
// get form data
$data = json_decode(file_get_contents('php://input'), true);

// Dao require
require_once '../dao/ClientDAO.php';
require_once '../entities/Client.php';

// bd name
$base = "svc";

// create dao
$daoclient = new DaoClient($base);

$saltInit = "!@$#";
$saltEnd = "$%&@";

$clientpassword = sha1($saltInit . $data['password']. $saltEnd);

$client = new Client();
$client->__set("name", $data['name']);
$client->__set("surname", $data['surname']);
$client->__set("birthdate", $data['birthdate']);
$client->__set("nationality", $data['nationality']);
$client->__set("email", $data['email']);
$client->__set("role", "client");
$client->__set("password", $clientpassword);

$daoclient->insertClient($client);

echo 'Registro exitoso';
?>