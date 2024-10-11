<?php 
session_start();
session_destroy();
header("Location: /svc/");
exit();
?>