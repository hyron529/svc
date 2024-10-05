<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="SVC Team">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://svc.cloud" />
    <meta property="og:image" content="./public/miniatura.png" />
    <meta property="og:site_name" content="SVC" />
    </meta>
    <link rel="shortcut icon" href="./public/favicon.ico" type="image/x-icon" />
    <title>SVC - Inicio</title>
    <link rel="stylesheet" href="./resources/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-color">
    <?php require_once('./views/header.php'); ?>

    <main class="main-container">
        <section class="intro-section text-center">
            <h1 class="main-heading">
                <span class="text-red">C</span>ONOCE <span class="text-red">A</span>L <span class="text-red">I</span>NSTANTE <span class="text-red">L</span>OS <span class="text-red">Ú</span>LTIMOS <span class="text-red">M</span>ODELOS <span class="text-red">A</span>L <span class="text-red">M</span>EJOR <span class="text-red">P</span>RECIO
            </h1>
            <p class="lead mt-3">Facilidad, eficiencia y la mejor experiencia de compra para tu próximo coche</p>
        </section>

        <section class="model-gallery py-5 text-center">
    <h2 class="text-white mb-4"><span class="text-red">N</span>uestros <span class="text-red">M</span>odelos</h2>
    <div id="modelCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/SVC/public/jaecoo1.jpg" class="d-block w-100 carousel-image" alt="Modelo 1">
            </div>
            <div class="carousel-item">
                <img src="/SVC/public/jaecoo2.webp" class="d-block w-100 carousel-image" alt="Modelo 2">
            </div>
            <div class="carousel-item">
                <img src="/SVC/public/jaecoo3.png" class="d-block w-100 carousel-image" alt="Modelo 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#modelCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#modelCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</section>
        <section class="packages-section py-5 text-center">
            <h2 class="text-white mb-4"><span class="text-red">P</span>aquetes <span class="text-red">E</span>xclusivos</h2>
            <p>Ofrecemos un sistema de selección de extras sencillo y rápido de usar, aplicado a todos los modelos por igual</p>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="card p-3 mb-4">
                        <h3 class="text-red">Básico</h3>
                        <p>Contiene los extras básicos para tu coche</p>
                            <p>Más sencillez, pero un precio más asequible</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 mb-4">
                        <h3 class="text-red">Avanzado</h3>
                        <p>Mejora tu experiencia con más funciones</p>
                        <p>Navegación GPS incluida</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 mb-4">
                        <h3 class="text-red">Premium</h3>
                        <p>Para una experiencia de lujo</p>
                        <p>Paquete con todos los extras</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="appointment-section py-5 text-center bg-light">
            <h2 class="text-dark mb-4"><span class="text-red">R</span>eserva <span class="text-red">T</span>u <span class="text-red">C</span>ita</h2>
            <p>¡Facilita la compra de tu coche! Reserva automáticamente una cita cuando elijas tu coche ideal.</p>
            <button class="btn btn-primary btn-lg">Ver Modelos Disponibles</button>
        </section>
    </main>

    <?php require_once('./views/footer.php'); ?>
    
    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-qMVi+iwfxJwOtdJPRil5uA0x0S8XRCJQHDbhQV6nXJbzbYH39iJr3GoW0ksrG2N" crossorigin="anonymous"></script>

</body>

</html>
