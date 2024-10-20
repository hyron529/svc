<header class="header-container container-fluid px-3">
    <div class="brand d-flex flex-wrap justify-content-center justify-content-lg-start align-items-center">
        <img src="/SVC/public/logo.png" alt="Logo de la Empresa" class="img-fluid">
        <div class="brand-text">
            <h1 class="h4 mb-1 text-center text-lg-start">
                <span class="text-red">S</span>MART <span class="text-red">V</span>ALUE <span class="text-red">C</span>ARS
            </h1>
            <h2 class="h6 text-muted text-center text-lg-start">Pequeñas marcas con las mejores prestaciones calidad - precio</h2>
        </div>
    </div>
    <div class="d-flex flex-column flex-lg-row align-items-center mt-3 mt-lg-0">
        <div class="language-switch d-flex justify-content-center">
            <img src="/SVC/public/español.png" alt="Cambiar a Español" title="Español" class="mx-2">
            <img src="/SVC/public/uk.webp" alt="Cambiar a Inglés" title="Inglés" class="mx-2">
        </div>
        <div class="d-flex justify-content-center justify-content-lg-start">
            <button id="registerclient" class="btn btn-outline-success mt-2 mt-lg-0">Registrarse</button>

            <?php
                session_start();
                if(!isset($_SESSION['client'])) {
                    echo "<a href='/svc/web/login.php' class='btn btn-success ms-3 mt-2 mt-lg-0'>Iniciar Sesión</a>";
                } else {
                    echo " <div class='dropdown ms-3 mt-2 mt-lg-0'>
                                <button id='loginMenu' class='btn btn-success text-black dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    ". $_SESSION['client']['name'] ."
                                </button>
                                <ul class='dropdown-menu'>
                                    <li><a href='/svc/seeders/logout.php' class='dropdown-item'>Cerrar sesion</a></li>
                                </ul>
                            </div>";
                }
            ?>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-lg custom-nav">
    <div class="container-fluid px-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><span class="text-red">I</span>NICIO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><span class="text-red">C</span>ONOCENOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><span class="text-red">M</span>ARCAS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><span class="text-red">T</span>IENDA</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
