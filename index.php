<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="SVC Team">
    <meta name="description" content="Web destinada a la compra de vehículos de marcas emergentes.">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Bienvenido a su compraventa de confianza!" />
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

    <main id="maincontainer" class="main-container">
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
                <img src="/svc/public/grenadier-1.jpg" class="d-block w-100 carousel-image" alt="Modelo 1">
            </div>
            <div class="carousel-item">
                <img src="/svc/public/polestar2.webp" class="d-block w-100 carousel-image" alt="Modelo 2">
            </div>
            <div class="carousel-item">
                <img src="/svc/public/lux a-3.jpg" class="d-block w-100 carousel-image" alt="Modelo 3">
            </div>
            <div class="carousel-item">
                <img src="/svc/public/jaecoo3.png" class="d-block w-100 carousel-image" alt="Modelo 4">
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
        
        <section class="features-section">
            <div class="container">
                <h2 class="custom-title">
                <span class="text-red">P</span>or <span class="text-red">q</span>ué <span class="text-red">e</span>legirnos
                </h2>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="feature-box">
                            <h3>Vehículo Ideal</h3>
                            <p>Selecciona entre distintos paquetes de extras y colores para personalizar tu vehículo a tu gusto.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="feature-box">
                            <h3>Proceso de Compra Fácil</h3>
                            <p>Compra online de manera rápida y segura, con la posibilidad de añadir varios vehículos al carrito.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="feature-box">
                            <h3>Asesoramiento Personalizado</h3>
                            <p>Contamos con un equipo especializado para ayudarte en cada paso del proceso de compra.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="news-section py-5 text-center">
            <h2 class="text-white mb-3" style="font-family: 'titulos';">
                <span class="text-red">N</span>oticias <span class="text-red">I</span>nteresantes
            </h2>
            <p class="text-white mb-4" style="font-family: 'secundaria';">
                ¡Nuevo récord en Nürburgring! El Xiaomi SU7 logra un tiempo de 6'46"874
            </p>
            <p class="text-white mb-4" style="font-family: 'secundaria';">
                Así ha sido la vuelta que le ha quitado el trono a Tesla
            </p>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <video muted autoplay loop controls class="w-100 rounded shadow">
                            <source src="/svc/public/video.mp4" type="video/mp4">
                            Tu navegador no soporta la reproducción de este video.
                        </video>
                    </div>
                </div>
            </div>
        </section>

        <section class="appointment-section py-5 text-center bg-light">
            <h2 class="text-dark mb-4"><span class="text-red">R</span>eserva <span class="text-red">T</span>u <span class="text-red">C</span>ita</h2>
            <p>¡Facilita la compra de tu coche! Reserva automáticamente una cita cuando elijas tu coche ideal.</p>
            <a href="/svc/web/shop.php"><button class="btn btn-primary btn-lg">Ver Modelos Disponibles</button></a>
        </section>
    </main>
    <div id="formzone"></div>
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content custom-modal-content">
            <div class="modal-header custom-modal-header">
                <h1 class="modal-title fs-5" id="messageModalTitle">Título del Modal</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom-modal-body">
                Este es el cuerpo del modal, donde puedes colocar cualquier contenido que desees.
            </div>
            <div class="modal-footer custom-modal-footer">
                <button type="button" class="button red" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


    <?php require_once('./views/footer.php'); ?>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script type="module" src="./resources/js/index.js"></script>
</body>

</html>