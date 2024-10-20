<?php 
//Obtenemos los datos del formulario como un JSON
$data = json_decode(file_get_contents('php://input'), true);

//Llamamos a los daos necesarios para trbajar con la entidad marca
require_once '../dao/BrandDAO.php';
require_once '../entities/Brand.php';
require_once '../entities/User.php';
require_once '../dao/UserDAO.php';

//Nombre de la BBDD que necesitamos
$base = "svc";

//Definimos la instancia de los daos
$daobrand = new DaoBrand($base);
$daouser = new DaoUser($base);

//Definimos salts para encriptar la contraseña
$saltInit = "!@$#";
$saltEnd = "$%&@";

//Encriptamos la contraseña
$brandpassword = sha1($saltInit . $data['password']. $saltEnd);

//Creamos la nueva instancia de marca y asignamos los valores enviados
//a los atributos del objeto marca
$brand = new Brand();
$brand->__set("name", $data['brandName']);
$brand->__set("foundation_date", $data['foundationDate']);
$brand->__set("country", $data['country']);
$brand->__set("headquarter", $data['headquarters']);
$brand->__set("email", $data['email']);
$brand->__set("website", "website");

$user = new User();
$user->__set("email", $data['email']);
$user->__set("password", $brandpassword);
$user->__set("role", "brand");

//Insertamos el nuevo marca en la BBDD con el dao
$daobrand->insertBrand($brand);
$daouser->insertUser($user);

echo 'Registro exitoso';
?>