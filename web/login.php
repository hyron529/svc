<!DOCTYPE html>
<html lang="es">

<head>
    <!--  Etiquetas de configuración y metaetiquetas-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="SVC Team">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://svc.cloud" />
    <meta property="og:image" content="../public/miniatura.png" />
    <meta property="og:site_name" content="SVC" />
    </meta>
    <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon" />
    <title>SVC - Login</title>
    <link rel="stylesheet" href="../resources/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-color">

    <?php
        //LLamamos a los daos necesarios para gestionar clientes y sus registros y logueos
        require_once '../dao/UserDAO.php';
        require_once '../dao/RegisterLoginDAO.php';

        //Iniciamos una nueva sesión
        session_start();

        //Comprobamos que el cliente está autenticado en la sesión, y si lo está,
        //lo redirigimos a la página principal
        if(isset($_SESSION['client']['name'])) {
            header("Location: /svc/");
        }

        //BBDD de nuestro sistema
        $base = "svc";

        //Creamos las instancias de nuestros daos
        $daouser = new DaoUser($base);
        $daoregister = new DAORegisterLogin($base);

        //Comprobamos si el login se ha enviado
        if(isset($_POST['Login'])) {

            //Recogemos los datos del cliente
            $user =  $_POST['username'];
            $password =  $_POST['password'];

            //Declaramos los salt para encriptar la contraseña
            $saltInit = "!@$#";
            $saltEnd = "$%&@";

            //Utilizamos sha1 para la encriptación
            $clientpassword = sha1($saltInit . $password . $saltEnd);

            //Obtenemos el número de intentos fallidos y comprobamos si está bloqueado
            $rows = $daoregister->getAttemps($user);
            $isBlockUser =  $daoregister->blockuser($rows);

            /*  
                Comprobamos si los campos de usuario y clave están vacíos
                En caso de que haya campos incompletos, lanzamos al advertencia al cliente
                Además comprobamos si el cliente está bloqueado y en caso contrario se intenta autenticar con el dao de clientes
                Guardamos la info del cliente si ha realizado el login, registramos el intento exitoso y lo redirigimos al index, pero
                en caso contrario, mostramos al cliente el error y guardamos el intento fallido
            */
            if (empty($user) || empty($password)) {
                echo "<div class='alert alert-warning' role='alert'> !Usuario o contraseña no válidos! </div>";
            } else {
                if($isBlockUser) { 
                    echo "<div class='alert alert-danger' role='alert'> !Usuario bloqueado!. Contacte con soporte técnico </div>";
                } else {
                    $row = $daouser->login($user, $clientpassword);

                    if($row) {
                        $_SESSION['client'] = array (
                            'name' => $user,
                            'role' => $row['role']
                        );
                        $daoregister->loginAttempt($user, $clientpassword, 'A');
                        header("Location: /svc/");
                    } else {
                        $daoregister->loginAttempt($user, $clientpassword, 'F');
                        echo "<div class='alert alert-warning' role='alert'> !Usuario o contraseña no válidos! </div>";
                    }
                }
            }
           
        }

    ?>
    <!-- Contenedores para mostrar los campos del formulario de login -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-card p-5">
            <h2 class="text-center mb-4">
                <span class="text-red">I</span>NICIAR <span class="text-red">S</span>ESIÓN
            </h2>
            <form name="flogin" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="username"  name="username" placeholder="Introduce tu usuario">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña">
                </div>
                <div class="d-grid gap-2 mb-3">
                    <input type="submit" class="btn btn-primary" value="Iniciar Sesión" name="Login">
                </div>
            </form>
        </div>
    </div>

</body>
</html>