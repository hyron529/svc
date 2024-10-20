<?php 

//Reanudamos la sesión
session_start();

//Si existe client, es porque el cliente ha iniciado sesión adecauadamente, y devolvemos un JSON 
//indicando la vaidez y el rol del usuario
if(isset($_SESSION['client'])) {
    echo json_encode(array('valid' => true, 'role' => $_SESSION['client']['role']));
} else {
    //Sin una sesión activa, devolvemos al JSON que dicho usuario no ha sido encontrado
    echo json_encode(array('valid' => false, 'error' => 'user not found'));
}

?>