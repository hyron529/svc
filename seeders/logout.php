<?php 

//Realización del cierre de sesion del usuario y lo 
//redirigimos a la página principal

session_start();
session_destroy();
header("Location: /svc/");
//Detenemos la ejecución del script
exit();
?>