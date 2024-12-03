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
        <title>SVC - Gestionar Colores</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php 
        require_once('../dao/UserDAO.php');
        require_once('../utils/alert.php');
        require_once('../entities/Color.php');
        require_once('../dao/ColorDAO.php');
        require_once('../utils/alert.php');

        // Sesion
        if(!isset($_SESSION)) session_start(); // Si no se ha iniciado sesion la iniciamos

        $base='svc';
        $daocolor = new DaoColor($base);
        $alert = new AlertGenerator();

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client']) || $_SESSION['client']['role'] == 'client') {
            header("Location: /svc/");
        }

        if(isset($_POST['Crear'])) {
            $colorname = $_POST['colorname'];
            $pricecolor = $_POST['pricecolor'];

            $color = new Color();
            $color->__set("name", $colorname);
            $color->__set("price", $pricecolor);
            $color->__set("emailBrand", $_SESSION['client']['name']);
            $daocolor->colorInsert($color);
            echo $alert->successAlert("El color ha sido creado correctamente.");
        }

        if(isset($_POST['Delete'])) {
            $idcolor = $_POST['Delete'];
            $daocolor->deletecolor($idcolor);
            echo $alert->successAlert("El color ha sido eliminado correctamente.");
        }

        require_once('../views/header.php'); // Header de la pagina
    ?>
    <body class='bg-color'>
        <div class='container mt-5'>
            <div class='row'>
                <h2 class="text-center mb-4">
                    <span class="text-red">GES</span>TIONAR <span class="text-red">C</span>OLORES
                </h2>
                <div class="container d-flex justify-content-center mb-4"> 
                    <button type="button" class="btn btn-danger btn-sm w-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Crear Color
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Gestionar Colores</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form name="fextrabrand" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                                    <div class="mb-3">
                                        <label for="colorname" class="form-label">Introduce el nombre del color</label>
                                        <input type="text" name="colorname" class="form-control" placeholder="Nombre del color." required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pricecolor" class="form-label">Introduce el precio del color</label>
                                        <input type="number" name="pricecolor" class="form-control" placeholder="Precio del color." required>
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
                        $daocolor->getColors($_SESSION['client']['name']);
                    
                        if(count($daocolor->colors) != 0) {
                            echo '<div class="row">';  
                            foreach($daocolor->colors as $value) {
                                echo '<div class="col-md-4 mb-4 d-flex align-items-stretch">';
                                echo '<div class="card shadow-sm border-0 h-100 w-100">';  
                                    echo "<div class='product-content p-3 bg-dark text-white'>";
                                        echo '<h5 class="product-title mb-1 fw-bold">' . $value->__get('name'). '</h5>';
                    
                                        echo '<div class="d-flex flex-column mb-3">';
                                            echo "<p class='card-text'>Precio del extra:".$value->__get('price')."</strong></p>";
                                        echo "</div>";
                    
                                        echo "<button class='btn btn-danger mt-3' type='submit' name='Delete' value='".$value->__get('id')."'>Eliminar</button>";
                                    echo '</div>';
                                echo '</div>';
                                echo '</div>';       
                            }
                            echo '</div>'; 
                        } else {
                            echo "<p class='text-center'>No hay colores disponibles cree uno nuevo.</p>";
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