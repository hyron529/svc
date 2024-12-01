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
        <title>SVC - Ver Citas</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php
        session_start();

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client'])) {
            header("Location: /svc/");
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
                        <input type="text" name="password" class="form-control" placeholder="Introduzca su contraseña.">
                    </div>
                    <div class="d-grid gap-2 mb-3">
                        <input type="submit" class="btn btn-primary" value="Modificar" name="Login">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>