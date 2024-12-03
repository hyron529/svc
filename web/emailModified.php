<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="SVC Team">
        <meta name="description" content="Web destinada a la compra de vehículos de marcas emergentes.">
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Bienvenido a su compraventa de confianza!" />
        <meta property="og:url" content="https://svc.cloud" />
        <meta property="og:image" content="../public/miniatura.png" />
        <meta property="og:site_name" content="SVC" />
        </meta>
        <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon" />
        <title>SVC - Modificar Correo</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php
        require_once('../dao/UserDAO.php');
        require_once('../utils/alert.php');
        require_once('../dao/ClientDAO.php');

        // Sesion
        session_start();

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client'])) {
            header("Location: /svc/");
        }

        // Recogemos el correo del usuario
        $username = $_SESSION['client']['name'];

        //BBDD de nuestro sistema
        $base = "svc";

        //Creamos las instancias de nuestros daos
        $daouser = new DaoUser($base);
        $daoclient = new DaoClient($base);
        $alert = new AlertGenerator();

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client'])) {
            header("Location: /svc/");
        }

        if(isset($_POST['Modificar'])) {
            $oldEmail = $_POST['oldEmail'];
            $newEmail = $_POST['newEmail'];
            $password = $_POST['password'];

            if (($oldEmail == '') || ($newEmail == '') || ($password == '')) {
                echo $alert->dangerAlert("Debe introducir datos en todos los campos.");
            } else {
                if(($daouser->emailUsed($newEmail))|| ($oldEmail == $newEmail) || ($oldEmail != $username)) {
                    echo $alert->dangerAlert("Datos no validos.");
                } else {
                    //Declaramos los salt para encriptar la contraseña
                    $saltInit = "!@$#";
                    $saltEnd = "$%&@";

                    //Utilizamos sha1 para la encriptación
                    $clientpassword = sha1($saltInit . $password . $saltEnd);

                    $row = $daouser->login($oldEmail, $clientpassword);

                    if($row) { 
                        if($_SESSION['client']['role'] == 'client') {
                            $daoclient->updateEmail($oldEmail, $newEmail);
                        }
                        echo $alert->successAlert("Contraseña cambiada correctamente, cerrando sesion.");
                        $daouser->updateEmail($oldEmail, $newEmail);
                        sleep(5);
                        header("Location: /svc/seeders/logout.php");
                    } else {
                        echo $alert->dangerAlert("Datos no validos.");
                    }
                }
            }
        }
    ?>
    <body class='bg-color'>
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="login-card p-5">
                <h2 class="text-center mb-4">
                    <span class="text-red">M</span>ODIFICAR <span class="text-red">C</span>ORREO
                </h2>
                <form name="femail" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                    <div class="mb-3">
                        <label for="oldEmail" class="form-label">Correo Actual</label>
                        <input type="text" name="oldEmail" class="form-control" placeholder="Introduzca su correo actual.">
                    </div>
                    <div class="mb-3">
                        <label for="newEmail" class="form-label">Nuevo Correo</label>
                        <input type="text" name="newEmail" class="form-control" placeholder="Introduzca el nuevo correo.">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Introduzca su contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Introduzca su contraseña.">
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <input type="submit" class="btn btn-primary" value="Modificar" name="Modificar">
                    </div>
                </form>
            </div>
        </div>
        <?php require_once('../utils/scripts.php'); ?>
    </body>
</html>