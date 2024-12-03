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
        <title>SVC - Gestionar Extras</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php 
        require_once('../dao/UserDAO.php');
        require_once('../utils/alert.php');
        require_once('../entities/Extra.php');
        require_once('../dao/ExtraDAO.php');
        require_once('../utils/alert.php');

        // Sesion
        if(!isset($_SESSION)) session_start(); // Si no se ha iniciado sesion la iniciamos

        $base='svc';
        $daoextra = new DaoExtra($base);
        $alert = new AlertGenerator();

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client']) || $_SESSION['client']['role'] == 'client') {
            header("Location: /svc/");
        }

        if(isset($_POST['Crear'])) {
            $extraname = $_POST['extraname'];
            $priceextra = $_POST['priceextra'];

            $extra = new Extra();
            $extra->__set("name", $extraname);
            $extra->__set("price", $priceextra);
            $extra->__set("emailBrand", $_SESSION['client']['name']);
            $daoextra->extraInsert($extra);
            echo $alert->successAlert("El extra ha sido creado correctamente.");
        }

        if(isset($_POST['Delete'])) {
            $idextra = $_POST['Delete'];
            $daoextra->deleteextra($idextra);
            echo $alert->successAlert("El extra ha sido eliminado correctamente.");
        }

        require_once('../views/header.php'); // Header de la pagina
    ?>
    <body class='bg-color'>
        <div class='container mt-5'>
            <div class='row'>
                <h2 class="text-center mb-4">
                    <span class="text-red">GES</span>TIONAR <span class="text-red">E</span>XTRAS
                </h2>
                <div class="container d-flex justify-content-center mb-4"> 
                    <button type="button" class="btn btn-danger btn-sm w-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Crear Extra
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Gestionar Extras</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form name="fextrabrand" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                                    <div class="mb-3">
                                        <label for="extraname" class="form-label">Introduce el nombre del extra</label>
                                        <input type="text" name="extraname" class="form-control" placeholder="Nombre del extra." required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="priceextra" class="form-label">Introduce el precio del Extra</label>
                                        <input type="number" name="priceextra" class="form-control" placeholder="Precio del extra." required>
                                    </div>
                                    <div class="d-grid gap-2 mb-3" class="form-label">
                                        <input type="submit" class="btn btn-primary" name="Crear" value="Crear">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <form name="fextrabrand" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                    <?php 
                        $daoextra->getExtras($_SESSION['client']['name']);
                    
                        if(count($daoextra->extras) != 0) {
                            echo '<div class="row">';  // Asegúrate de tener un contenedor con la clase "row"
                            foreach($daoextra->extras as $value) {
                                echo '<div class="col-md-4 mb-4 d-flex align-items-stretch">';
                                echo '<div class="card shadow-sm border-0 h-100 w-100">';  
                                    echo "<div class='product-content p-3 bg-dark text-white'>";
                                        echo '<h5 class="product-title mb-1 fw-bold">' . $value->__get('name'). '</h5>';
                    
                                        echo '<div class="d-flex flex-column mb-3">';
                                            echo "<p class='card-text'>Precio del extra:".$value->__get('price')."</strong></p>";
                                        echo "</div>";
                    
                                        echo "<button class='btn btn-danger mt-3' type='submit' name='Delete' value='".$value->__get('id')."'>Eliminar Cita</button>";
                                    echo '</div>';
                                echo '</div>';
                                echo '</div>';       
                            }
                            echo '</div>';  // Cierra el contenedor de la fila
                        } else {
                            echo "<p class='text-center'>No hay extras disponibles cree uno nuevo.</p>";
                        }
                    ?>
                </form>

            </div>
        </div>
        <?php 
        require_once('../views/footer.php');
        require_once('../utils/scripts.php'); ?>
        <script type="module" src="../resources/js/index.js"></script>
    </body>
</html>