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
        <title>SVC - Gestionar Coches</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php 
        require_once('../dao/UserDAO.php');
        require_once('../utils/alert.php');
        require_once('../entities/Car.php');
        require_once('../dao/CarDAO.php');
        require_once('../utils/alert.php');

        // Sesion
        if(!isset($_SESSION)) session_start(); // Si no se ha iniciado sesion la iniciamos

        $base='svc';
        $daocar = new DaoCar($base);
        $alert = new AlertGenerator();

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client']) || $_SESSION['client']['role'] == 'client') {
            header("Location: /svc/");
        }

        function FechaEpoch($fecha)   //Convierte una fecha en formato dd/mm/yyyy a segundos epoch
        {
            $camposFecha = explode("-", $fecha);

            // La convertimos a epoch para guardarla de esta forma
            $fechaEpoch = mktime(0, 0, 0, $camposFecha[1], $camposFecha[0], $camposFecha[2]);

            return $fechaEpoch;
        }

        if(isset($_POST['Crear'])) {
            $fabrication_year = $_POST['fabrication_year'];
            $base_price = $_POST['base_price'];
            $fuel_type = $_POST['fuel_type'];
            $transmission = $_POST['transmission'];
            $base_color = $_POST['base_color'];
            $power = $_POST['power'];
            $autonomy = $_POST['autonomy'];
            $num_seats = $_POST['num_seats'];
            $car_type = $_POST['car_type'];
            $stock = $_POST['stock'];
            $modelname = $_POST['modelname'];
            $trunk_capacity = $_POST['trunk_capacity'];
            $logo = '';

            if (isset($_FILES['image']) && $_FILES['image']['tmp_name'] != "") {
                $temp = $_FILES['image']['tmp_name'];
                $contenido = file_get_contents($temp);
                $contenido = base64_encode($contenido);
                $logo = $contenido;
            }
        
            $car = new Car();
            $car->__set("model_name", $modelname);
            $car->__set("fabrication_year", FechaEpoch($fabrication_year));
            $car->__set("base_price", $base_price);
            $car->__set("fuel_type", $fuel_type);
            $car->__set("transmission", $transmission);
            $car->__set("base_color", $base_color);
            $car->__set("power", $power);
            $car->__set("trunk_capacity", $trunk_capacity);
            $car->__set("autonomy", $autonomy);
            $car->__set("num_seats", $num_seats);
            $car->__set("car_type", $car_type);
            $car->__set("image", $logo);
            $car->__set("stock", $stock);
            $car->__set("emailBrand", $_SESSION['client']['name']);

            $daocar->insertCar($car);
            echo $alert->successAlert("El coche ha sido creado correctamente.");
        }

        if(isset($_POST['Delete'])) {
            $id = $_POST['Delete'];
            $daocar->deleteCar($id);
            echo $alert->successAlert("El coche ha sido eliminado correctamente.");
        }

        require_once('../views/header.php'); // Header de la pagina
    ?>
    <body class='bg-color'>
        <div class='container mt-5'>
            <div class='row'>
                <h2 class="text-center mb-4">
                    <span class="text-red">G</span>ESTIONAR <span class="text-red">C</span>OCHES
                </h2>
                <div class="container d-flex justify-content-center mb-4"> 
                    <button type="button" class="btn btn-danger btn-sm w-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Crear Coche
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Gestionar Coches</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form name="fextrabrand" method="post" action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="modelname" class="form-label">Introduzca el modelo</label>
                                        <input type="text" name="modelname" class="form-control" placeholder="Nombre del modelo" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fabrication_year" class="form-label">Año de fabricación</label>
                                        <input type="date" name="fabrication_year" class="form-control" placeholder="Año de fabricación" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="base_price" class="form-label">Precio base</label>
                                        <input type="number" name="base_price" class="form-control" placeholder="Precio base" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="fuel_type" class="form-label">Tipo de combustible</label>
                                        <input type="text" name="fuel_type" class="form-control" placeholder="Tipo de combustible" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="trunk_capacity" class="form-label">Capacidad del depósito</label>
                                        <input type="number" name="trunk_capacity" class="form-control" placeholder="Capacidad del depósito" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="transmission" class="form-label">Transmisión</label>
                                        <input type="text" name="transmission" class="form-control" placeholder="Transmisión" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="base_color" class="form-label">Color base</label>
                                        <input type="text" name="base_color" class="form-control" placeholder="Color base" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="power" class="form-label">Potencia</label>
                                        <input type="number" name="power" class="form-control" placeholder="Potencia" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="autonomy" class="form-label">Autonomía</label>
                                        <input type="number" name="autonomy" class="form-control" placeholder="Autonomía" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="num_seats" class="form-label">Número de asientos</label>
                                        <input type="number" name="num_seats" class="form-control" placeholder="Número de asientos" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="car_type" class="form-label">Tipo de coche</label>
                                        <input type="text" name="car_type" class="form-control" placeholder="Tipo de coche" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input type="number" name="stock" class="form-control" placeholder="Stock" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Imagen</label>
                                        <input class='form-label' type='file' name='image' accept='image/jpg'>
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
                        $daocar->getCarsBrand($_SESSION['client']['name']);
                    
                        if(count($daocar->cars) != 0) {
                            echo '<div class="row">';  
                            foreach($daocar->cars as $value) {
                                echo '<div class="col-md-4 mb-4 d-flex align-items-stretch">';
                                echo '<div class="card shadow-sm border-0 h-100 w-100">';  
                                
                                    echo '<div class="product-image">';
                                        echo "<img class='card-img-top' src='data:image/jpeg;base64," . $value->__get('image') . "' alt='Car image' style='width: 100%; height: 250px; object-fit: cover;'>";
                                    echo '</div>';
                                    echo "<div class='product-content p-3 bg-dark text-white'>";
                                        echo '<h5 class="product-title mb-1 fw-bold">' . $value->__get('model_name'). '</h5>';
                    
                                        echo '<div class="d-flex flex-column mb-3">';
                                            echo '<ul class="list-unstyled">';
                                            echo '<li>Tipo: ' . $value->__get('car_type') . '</li>';
                                            echo '<li>Precio base: ' . $value->__get('base_price') . ' $</li>';
                                            echo '<li>Combustible: ' . $value->__get('fuel_type') . '</li>';
                                            echo '<li>Transmisión: ' . $value->__get('transmission') . '</li>';
                                            echo '<li>Potencia: ' . $value->__get('power') . ' CV</li>';
                                            echo '</ul>';
                                        echo "</div>";
                    
                                        echo "<button class='btn btn-danger mt-3' type='submit' name='Delete' value='".$value->__get('id')."'>Eliminar</button>";
                                    echo '</div>';
                                echo '</div>';
                                echo '</div>';       
                            }
                            echo '</div>'; 
                        } else {
                            echo "<p class='text-center'>No hay vehículos disponibles. Puede crear uno nuevo.</p>";
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