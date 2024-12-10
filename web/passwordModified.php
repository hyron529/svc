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
        <title>SVC - Modificar contraseña</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php 
        require_once('../dao/UserDAO.php');
        require_once('../utils/alert.php');

        // Sesion
        session_start();

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client'])) {
            header("Location: /svc/");
        }

        $username = $_SESSION['client']['name'];

        //BBDD de nuestro sistema
        $base = "svc";

        //Creamos las instancias de nuestros daos
        $daouser = new DaoUser($base);
        $alert = new AlertGenerator();

      
        if(isset($_POST['Modificar'])) {
            $passwordOld = $_POST['passwordOld'];
            $passwordNew = $_POST['passwordNew'];

            if (($passwordOld == '') || ($passwordNew == '')) {
                echo $alert->dangerAlert("Debe introducir las contraseñas.");
            } else {
                //Declaramos los salt para encriptar la contraseña
                $saltInit = "!@$#";
                $saltEnd = "$%&@";

                //Utilizamos sha1 para la encriptación
                $clientpasswordOld = sha1($saltInit . $passwordOld . $saltEnd);

                $row = $daouser->login($username, $clientpasswordOld);

                if($row) {
                    echo $alert->successAlert("Contraseña cambiada correctamente, cerrando sesión.");
                    $clientpasswordnew = sha1($saltInit . $passwordNew . $saltEnd);
                    $daouser->updatePassword($username, $clientpasswordnew);
                    sleep(5);
                    header("Location: /svc/seeders/logout.php");
                } else {
                    echo $alert->dangerAlert("Error. La contraseña antigua no coincide");
                }
            }
        }
    ?>
    <body class='bg-color'>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-card p-5">
            <h2 class="text-center mb-4">
                <span class="text-red">M</span>ODIFICAR <span class="text-red">C</span>ONTRASEÑA
            </h2>
            <form name="femail" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                <div class="mb-3">
                    <label for="passwordOld" class="form-label">Contraseña Actual</label>
                    <input type="password" name="passwordOld" class="form-control" placeholder="Introduzca su contraseña actual" required>
                </div>
                <div class="mb-3">
                    <label for="passwordNew" class="form-label">Contraseña Nueva</label>
                    <input type="password" name="passwordNew" class="form-control" placeholder="Introduzca su nueva contraseña" required>
                </div>
                <div class="d-grid gap-2 mb-3">
                    <input type="submit" class="btn btn-primary" name="Modificar" value="Modificar">
                </div>
            </form>
        </div>
    </div>

        <?php require_once('../utils/scripts.php'); ?>
    </body>
</html>