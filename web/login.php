<!DOCTYPE html>
<html lang="es">

<head>
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
        require_once '../dao/ClientDAO.php';
        require_once '../dao/RegisterLoginDAO.php';

        session_start();

        if(isset($_SESSION['client']['name'])) {
            header("Location: /svc/");
        }

        $base = "svc";

        $daoclient = new DaoClient($base);
        $daoregister = new DAORegisterLogin($base);

        if(isset($_POST['Login'])) {

            // Client data
            $user =  $_POST['username'];
            $password =  $_POST['password'];

            // Password
            $saltInit = "!@$#";
            $saltEnd = "$%&@";

            $clientpassword = sha1($saltInit . $password . $saltEnd);

            // Block user 
            $rows = $daoregister->getAttemps($user);
            $isBlockUser =  $daoregister->blockuser($rows);

            if (empty($user) || empty($password)) {
                echo "<div class='alert alert-warning' role='alert'> !Usuario o contraseña no válidos! </div>";
            } else {
                if($isBlockUser) { 
                    echo "<div class='alert alert-danger' role='alert'> !Usuario bloqueado contacte con soporte técnico! </div>";
                } else {
                    $row = $daoclient->login($user, $clientpassword);

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