<?php 

session_start();

if(isset($_SESSION['client'])) {
    echo json_encode(array('valid' => true, 'role' => $_SESSION['client']['role']));
} else {
    echo json_encode(array('valid' => false, 'error' => 'user not found'));
}

?>