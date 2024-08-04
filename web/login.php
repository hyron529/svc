<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ofrece a tus clientes la conveniencia de reservar directamente a través de tu propia aplicación y digitaliza por completo la gestión de tu negocio con SVC.">
    <meta name="keywords" content="SVC, gestión de gimnasios, reserva de clientes, digitalización, aplicación de gimnasios">
    <meta name="author" content="SVC Team">
    <meta property="og:url" content="https://SVC.cloud"/>
    <meta property="og:image" content="../public/miniatura.png"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="SVC"/>
    <meta property="og:title" content="Bienvenido a SVC el mejor software para la gestión de tu gimnasio."></meta>
    <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon" />
    <title>SVC - Inicio de Sesión</title>
    <link rel="stylesheet" href="../resources/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-color">
    <?php
    // Llamamos a los ficheros necesarios para la creacion de nuestro login
    require_once '../dao/UsuarioDAO.php';
    require_once '../dao/LoginDAO.php';

    session_start();

    // Si el usuario ya esta registrado no podra acceder al login
    if (isset($_SESSION['usuario']['username'])) {
        header("Location: /SVC/web/profile.php");
    }

    // Definimos el nombre de nuestra base de datos
    $base = "SVC";

    // Nos declaramos los daos necesarios para el login
    $daoUsuario = new DaoUsuario($base);
    $daoLogin = new DaoLogin($base);

    function usuarioBloqueado($usuario)
    {
        // Ponemos nuestros daos como globales para poder usarlos dentro del metodo
        global $daoLogin;

        // Definimos las variables necesarias
        $intervalo = 300;
        $filas = $daoLogin->obtenerIntentos($usuario);

        // Comprobamos si el usario tiene las denegaciones necesarias y si esta dentro del intervalo
        if ($daoLogin->denegaciones($filas)) {
            if ($daoLogin->intervaloTiempo($filas, $intervalo)) {
                $bloqueado = time() + $intervalo;
            }
        }

        // Si el usuario esta bloqueado devolvemos el tiempo que estara bloqueado y sino -1
        return $bloqueado ?? -1;
    }

    if (isset($_POST['Login'])) {
        // Recogemos el valor del usuario 
        $usuario = $_POST['Usuario'];
        $clave = $_POST['Contrasenia'];

        // Comprobmaos si el usuario esta bloqueado
        $bloqueado = usuarioBloqueado($usuario);

        if (empty($usuario) || empty($clave)) {
            echo "<div class='alert alert-warning' role='alert'>Usuario o Clave <strong>incorrectos</strong></div>";
        } else {
            // Creamos los salt para la contrasena y la recogemos
            $saltInicio = '#$%@';
            $saltFin = '%!&?';

            // Recogemos la contrasena y le aplicamos el respectivo cifrado
            $claveCifrada = sha1($saltInicio . $clave . $saltFin);

            if ($bloqueado == -1) {
                $fila = $daoUsuario->login($usuario, $claveCifrada);

                if ($fila) {
                    // Creamos el intento de login como correcto
                    $daoLogin->registroLogin($usuario, $claveCifrada, 'C');
                    // Guardamos en la session el usuario y el role
                    $_SESSION['usuario'] = array(
                        'username' => $usuario,
                        'role' => $fila['role']
                    );
                    // Rederigimos a la pagina
                    header("Location: /SVC/web/profile.php");
                } else {
                    // Creamos el intento de login como correcto
                    $daoLogin->registroLogin($usuario, $claveCifrada, 'D');
                    // Mostramos el mensaje al usuario que se ha equivocado
                    echo "<div class='alert alert-warning' role='alert'>Usuario o Clave <strong>incorrectos</strong></div>";
                }
            } else {
                // Convertimos la hora de bloqueo
                $campos = getdate($bloqueado);

                // Construimos la hora y el dia de bloqueo
                $hora = $campos['hours'] . ":" . $campos['minutes'] . ":" . $campos['seconds'];
                $dia = $campos['mday'] . "/" . $campos['mon'] . "/" . $campos['year'];

                echo "<div class='alert alert-danger' role='alert'>";
                echo "El usuario <strong>$usuario</strong> ha sido bloqueado hasta las <strong>$hora</strong> del dia <strong>$dia</strong>";
                echo "</div>";
            }
        }
    }
    ?>

    <div class="container bg-color rounded-2 p-5 my-4">
        <div class="d-flex justify-content-end mb-3">
            <a href="/SVC/index.php" class="btn-black">Volver atrás</a>
        </div>
        <h1 class="font-title text-main-color text-center">Bienvenido a SVC !</h1>
        <p class='text text-center'>
            Nota informativa: La contraseña del usuario debe ser <strong class="text-main-color">entrega por su monitor</strong> recuerde <strong class="text-main-color">no compartir</strong> información privada.
        </p>
        <form name='fLogin' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
            <div class="mb-3">
                <label for="Usuario" class="form-label font-title text fs-6">Usuario</label>
                <input type="email"  placeholder="Introduzca su correo electronico." class="input-style" id="Usuario" name="Usuario">
            </div>
            <div class="mb-3">
                <label for="Contrasenia" class="form-label font-title text fs-6">Contraseña</label>
                <input type="password" placeholder="Introduzca su contraseña." class="input-style" id="Contrasenia" name="Contrasenia">
            </div>
            <input class="btn-black" type="submit" value="Iniciar sesión" name="Login">
        </form>
    </div>
    <!-- Llamamos a nuestros scripts que tenemos en las views que obtendremos de php -->
    <?php require_once('../views/scripts.php'); ?>
</body>
</html>
