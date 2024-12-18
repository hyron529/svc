<!DOCTYPE html>
<html lang="es">

<head>
  <!--  Etiquetas de configuración y metaetiquetas-->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="SVC Team">
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://svc.cloud" />
  <meta property="og:image" content="../public/miniatura.png" />
  <meta property="og:site_name" content="SVC" />
  </meta>
  <link rel="shortcut icon" href="../public/favicon.ico" type="image/x-icon" />
  <title>SVC - Tienda</title>
  <link rel="stylesheet" href="../resources/css/main.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<?php

  // importamos las clases necesarias para el correcto funcionamiento
  require_once('../dao/CarDAO.php');
  require_once('../dao/OrderDAO.php');
  require_once('../entities/Order.php');
  require_once('../dao/OrderDetailsDAO.php');
  require_once('../dao/ColorDAO.php');
  require_once('../dao/ExtraDAO.php');
  require_once('../entities/OrderDetails.php');
  require_once('../utils/alert.php');
  require_once('../dao/DateDetailsDAO.php');
  require_once('../entities/Appointment.php');
  require_once('../dao/AppointmentDAO.php');
  require_once('../dao/ClientDAO.php');

  if(!isset($_SESSION)) session_start();

  if(isset($_SESSION['client']) && $_SESSION['client']['role'] == 'brand') {
    header("Location: /svc/");
  }

  // Declaramos el nombre de nuestra base de datos
  $base = 'svc';

  // Declaramos los daos necesarios para hacer la tienda
  $cardao = new DaoCar($base);
  $orderdao = new DaoOrder($base);
  $orderDetailsdao = new DaoOrderDetails($base);
  $colorDao = new DaoColor($base);
  $extraDao = new DaoExtra($base);
  $alert = new AlertGenerator();
  $daodetails = new DaoDateDetails($base);
  $daoAppointment = new DaoAppointment($base);
  $daoClient = new DaoClient($base);

  $code = '';
  if(isset($_SESSION['client']) && $_SESSION['client']['role'] == 'client') {
    // Obtenemos el codigo del usuario actual
    $userNow = $daoClient->getClientCode($_SESSION['client']['name']);
    $code = $userNow['id'];
  }

  if (isset($_POST['Test'])) {
    if (!isset($_SESSION['client'])) {
      echo $alert->dangerAlert("¡Debes estar logeado para comprar un vehiculo!");
    } else {
      $carid = $_POST['Test'];
      $car = $cardao->getCar($carid);
      $brandEmail  = $car['emailBrand'];
      $date = $daodetails->getdate($car['emailBrand']);
      
      $appointment = new Appointment();
      $appointment->__set("title", "Prueba de vehiculo!");
      $appointment->__set("description", "Información acerca del vehiculo a probar: " . $car['model_name'] );
      $appointment->__set("date" , $date['time']);
      $appointment->__set("idClient", $code);
      $appointment->__set("emailBrand", $brandEmail);
      $appointment->__set("type", "Prueba");

      $daoAppointment->insert($appointment);
      $daodetails->occuped($date['time'], $date['id']);

      echo $alert->successAlert("La cita para probar el vehiculo ha sido creada.");
    }
  }

  if (isset($_POST['buycar'])) {
    // Recogemos los parametros del coche seleccionado por el usuario
    $selectedCarId = $_POST['buycar'] ?? null;
    $selectedColor = $_POST['Color_' . $selectedCarId] ?? null;
    $selectedExtra = $_POST['Extras_' . $selectedCarId] ?? null;

    // Comprobamos si el usuario no esta registrado 
    if (!isset($_SESSION['client'])) {
      echo $alert->dangerAlert("¡Debes estar logeado para comprar un vehiculo!");
    } else  if ($selectedColor != null || $selectedExtra != null){ 
      if (isset($_SESSION['client'])) {
        $emailClient = $_SESSION['client']['name'];

        // Obtenemos el id del pedido sino ha sido realizado, si ha sido realizado creamos uno nuevo y consultamos el id de nuevo
        $orderid = $orderdao->existOrderClient($code);
    
        if ($orderid == null) {
          $order = new Order();
          $order->__set('order_date', time());
          $order->__set('idClient', $code);
          $order->__set('sent', false);
    
          $orderdao->insert($order);
          $orderid = $orderdao->existOrderClient($code);
        }
    
        // Si existe el pedido para el mismo cliente y el mismo coche le sumamos uno a la cantidad del vehiculo
        $orderExists = $orderDetailsdao->existsOderDetails($orderid['id'], $selectedCarId, $selectedExtra, $selectedColor);
    
        if ($orderExists == null) {
          // Agregamos al carrito el coche seleccionado con sus respectivos detalles
          $orderDetails = new OrderDetails();
          $orderDetails->__set('quantity', 1);
          $orderDetails->__set('extra', $selectedExtra);
          $orderDetails->__set('color', $selectedColor);
          $orderDetails->__set('id_order', $orderid['id']);
          $orderDetails->__set('id_car', $selectedCarId);
    
          $orderDetailsdao->insert($orderDetails);
        } else {
          $quantity = $orderExists['quantity'] + 1;
          $orderDetailsdao->add($quantity, $orderid['id'], $selectedCarId, $selectedExtra, $selectedColor);
        }
        
        echo $alert->successAlert("EL vehiculo ha sido añadido correctamente al carrito.");
      } 
    } else {
      echo $alert->dangerAlert("Debe seleccionar un extra y un color.");
    }
  }

  require_once('../views/header.php'); // Mostramos el header de la pagina
?>

<body class="bg-color">
  <form name='fshop' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
    <div class='container mt-5'>
      <div class='row'>
        <?php
          echo "<div class='d-flex justify-content-center'>";
          echo "<h2><span class='text-red'>B</span>ienvenido <span class='text-red'>a</span> <span class='text-red'>l</span>a <span class='text-red'>T</span>ienda</h2>";
          echo "</div>";          
          echo '<div class="container d-flex justify-content-center mb-4">';
          echo '<div class="input-group w-75">';
          echo '<input class="form-control py-2" type="text" name="search" placeholder="Introduzca el modelo que desee buscar" aria-label="Buscar">';
          echo '<button class="btn btn-danger py-2 ms-2" type="submit" name="searchsubmit"><i class="bi bi-search"></i> Buscar</button>';
          echo '</div>';
          echo '</div>';


          
          if(isset($_POST['searchsubmit']) && $_POST['search'] != '') {
            $cardao->getCars($_POST['search']);
          } else {
            $cardao->getCars("");
          }

          if(count($cardao->cars) != 0) {
            foreach ($cardao->cars as $key => $value) {
              echo '<div class="col-md-4 mb-4 d-flex align-items-stretch">';
              echo '<div class="card shadow-sm border-0">';
  
              echo '<div class="product-image">';
                echo "<img class='card-img-top' src='data:image/jpeg;base64," . $value->__get('image') . "' alt='Car image' style='width: 100%; height: 250px; object-fit: cover;'>";
              echo '</div>';
  
              echo '<div class="product-content p-3 bg-dark text-white">';
  
                echo '<h5 class="product-title mb-1 fw-bold">' . $value->__get('model_name') . '</h5>';
  
                // Desplegable de características del vehículo
                echo '<div class="d-flex flex-column mb-3">';
                  echo '<ul class="list-unstyled">';
                    echo '<li>Tipo: ' . $value->__get('car_type') . '</li>';
                    echo '<li>Precio base: ' . $value->__get('base_price') . ' $</li>';
                    echo '<li>Combustible: ' . $value->__get('fuel_type') . '</li>';
                    echo '<li>Transmisión: ' . $value->__get('transmission') . '</li>';
                    echo '<li>Potencia: ' . $value->__get('power') . ' CV</li>';
                  echo '</ul>';
                echo '</div>';
  
                echo "<label for='Extras'>Seleccione extras </label>";
                echo '<div class="d-flex mb-3">';
                $extraDao->getExtras($value->__get('emailBrand'));
                echo "<select name='Extras_" . $value->__get('id') . "'>";
                echo "<option value=''></option>";
                foreach ($extraDao->extras as $c) {
                  echo "<option value='".$c->__get('id')."'>".$c->__get('name')."</option>";
                } 
                echo "</select>";
                echo '</div>';
  
                echo "<label for='Color'>Seleccione un color </label>";
                echo "<div class='mt-2'>";
                $colorDao->getColors($value->__get('emailBrand'));
                  echo "<select name='Color_" . $value->__get('id') . "'>";
                    echo "<option value=''></option>";
                    foreach ($colorDao->colors as $c) {
                      echo "<option value='".$c->__get('id')."'>".$c->__get('name')."</option>";
                    } 
                  echo "</select>";
                echo "</div>";
  
                echo '<div class="d-flex justify-content-between align-items-center mt-3">';
                  echo '<div>';
                    echo "<button type='submit' class='btn btn-primary me-2'  name='buycar' value='".$value->__get('id')."'";
                    if ($value->__get('stock') == 0) {
                      echo " disabled";
                    }
                    echo ">Agregar al carrito</button>";
                    echo "<button type='submit' class='btn btn-secondary me-2'  name='Test' value='".$value->__get('id')."'>¡Probar!</button>";
                  echo '</div>';
                echo '</div>';
  
                echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          } else {
            echo "<p>No hay vehículos disponibles.</p>";
          }
        ?>
      </div>
    </div>
  </form>
  <?php
    require_once('../views/footer.php');
    require_once('../utils/scripts.php');
  ?>
  <script type="module" src="../resources/js/index.js"></script>
</body>

</html>