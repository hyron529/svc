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

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-card p-5">
            <h2 class="text-center mb-4">
                <span class="text-red">I</span>NICIAR <span class="text-red">S</span>ESIÓN
            </h2>
            <form>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="username" placeholder="Introduce tu usuario">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" placeholder="Introduce tu contraseña">
                </div>
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
                <div class="text-center">
                    <a href="#" class="text-secondary">¿Olvidaste tu contraseña?</a><br>
                    <a href="registerUser.php" class="text-secondary">Crear cuenta nueva</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>