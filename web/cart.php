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
        <title>SVC - Carrito de Compra</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php 
        require_once('../dao/OrderDAO.php');
        require_once('../dao/OrderDetailsDAO.php');
        require_once('../dao/CarDAO.php');
        require_once('../dao/ColorDAO.php');
        require_once('../dao/ExtraDAO.php');
        require_once('../utils/alert.php');

        // Nombre de nuestra base de datos
        $base = "svc";

        // Creamos los daos necesarios
        $daoOrder = new DaoOrder($base);
        $daoOrderDetails = new DaoOrderDetails($base);
        $daoCar = new DaoCar($base);
        $daoExtra = new DaoExtra($base);
        $daoColor = new DaoColor($base);
        $alert = new AlertGenerator();

        if(!isset($_SESSION)) session_start(); // Si no se ha iniciado sesion la iniciamos

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client'])) {
            header("Location: /svc/");
        }

        // Decrementamos la cantidad de vehiculos
        if(isset($_POST['Decrement'])) {
            $carData =  explode(',', $_POST['Decrement'] ) ?? null;

            if ($carData != null) {
                $carid = $carData[0];
                $oderid = $carData[1];
                $extra = $carData[2];
                $color = $carData[3];
  
                $orderExists = $daoOrderDetails->existsOderDetails($oderid, $carid, $extra, $color);
                $quantity = $orderExists['quantity'] - 1;
                $daoOrderDetails->add($quantity, $oderid, $carid, $extra, $color);
  
                echo $alert->successAlert("Se ha quitado un coche del carrito.");
              }
        }

        // Incrementamos la cantidad de vehiculos
        if(isset($_POST['Increment'])) {
            $carData =  explode(',', $_POST['Increment'] ) ?? null;

            if ($carData != null) {
              $carid = $carData[0];
              $oderid = $carData[1];
              $extra = $carData[2];
              $color = $carData[3];

              $orderExists = $daoOrderDetails->existsOderDetails($oderid, $carid, $extra, $color);
              $quantity = $orderExists['quantity'] + 1;
              $daoOrderDetails->add($quantity, $oderid, $carid, $extra, $color);

              echo $alert->successAlert("Se ha añadido un nuevo coche al carrito.");
            }
        }

        // Borramos el vehiculo del carrito
        if(isset($_POST['Delete'])) {
            $carData =  explode(',', $_POST['Delete'] ) ?? null;

            if ($carData != null) {
              $carid = $carData[0];
              $oderid = $carData[1];

              $daoOrderDetails->delete($oderid, $carid);

              echo $alert->successAlert("Coche eliminado del carrito.");
            }
        }

        require_once('../views//header.php'); // Header de la pagina
    ?>
    <body class='bg-color'>
        <form name='fcart' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
            <div class='container mt-5'>
                <div class='row'>
                    <?php 
                    // Comprobamos si existe un pedido del cliente
                    $orderId = $daoOrder->existOrderClient($_SESSION['client']['name']);

                    if ($orderId != null) {
                        $daoOrderDetails->list($orderId['id']);
                        $orders = $daoOrderDetails->orders;

                        if (count($orders) == 0) {
                            echo '<p class="text-center">Su carrito esta vacio!</p>';
                        } else {
                            // Array con el precio total de los coches de nuestro carrito
                            $orderTotalPrices = array();
                            $orderPrice = 0; // Precio total del pedido

                            foreach ($orders as $key => $value) {
                                $carData = array($value->__get('id_car'),$value->__get('id_order'),$value->__get('extra'),$value->__get('color'));
                                // Obtenemos el modelo del coche
                                $car = $daoCar->getCarName($value->__get('id_car'));
                                // Obtenemos el nombre del color
                                $color = $daoColor->getColor($value->__get('color'));
                                // Obtenemos el nombre del extra
                                $extra = $daoExtra->getExtra($value->__get('extra'));

                                // Calculamos el precio total de la compra del coche
                                $extraPrice = $extra['price'];
                                $colorPrice = $color['price'];
                                $carPrice = $car['base_price'];
                                // Precio total
                                $totalPrice = ($carPrice * $value->__get('quantity')) + $extraPrice + $colorPrice;
                                $orderTotalPrice[] = $totalPrice; // Servira para calcular el precio total del pedido

                                echo '<div class="col-md-4 mb-4 d-flex align-items-stretch">';
                                echo '<div class="card shadow-sm border-0">';
                                    echo '<div class="product-image">';
                                        echo "<img class='card-img-top' src='data:image/jpeg;base64," . base64_encode($car['image']) . "' alt='Car image' style='width: 100%; height: 250px; object-fit: cover;'>";
                                    echo '</div>';
    
                                    echo '<div class="product-content p-3 bg-dark text-white">';
                                        echo '<h5 class="product-title mb-1 fw-bold">' . $car['model_name'] . '</h5>';
    
                                        echo '<div class="d-flex flex-column mb-3">';
                                            echo "<p class='card-text'>Color: " . $color['name'] . " | Extra: " . $extra['name'] . " <br><strong class='text-primary'>Precio Total: ".$totalPrice."€</strong></p>";
                                        echo "</div>";
    
                                        echo "<div class='input-group input-group-sm'>";
                                            echo "<button class='btn btn-outline-secondary' type='submit' name='Decrement' value='".implode(",", $carData)."'>-</button>";
                                            echo "<input type='text' disabled class='form-control' name='Quantity' value='" . $value->__get('quantity') . "'>";
                                            echo "<button class='btn btn-outline-secondary' type='submit' name='Increment' value='".implode(",", $carData)."'>+</button>";
                                        echo "</div>";
    
                                        echo "<button class='btn btn-danger mt-3' type='submit' name='Delete' value='".implode(",", $carData)."'>Quitar del Carrito</button>";
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';            
                            }

                            foreach ($orderTotalPrice as $key => $value) {$orderPrice += $value;}

                            echo "<input class='m-auto btn btn-secondary' type='submit' name='Buy' value='Realizar Compra (".$orderPrice."€)'>";
                        }
                    } else {
                        echo '<p class="text-center">Su carrito esta vacio!</p>';
                    }
                    
                    ?>
                </div>
            </div>
        </form>
    <?php
        require_once('../views/footer.php');
        require_once('../utils/scripts.php');
    ?>
    </body>
</html>