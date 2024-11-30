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
        <title>SVC - Ver Citas</title>
        <link rel="stylesheet" href="../resources/css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <?php 
    
        require_once('../views/header.php');
        require_once('../dao/AppointmentDAO.php');
        require_once('../utils/alert.php');

        // Nombre de nuestra base de datos
        $base = "svc";

        // Creamos nuestros daos
        $daoAppointment = new DaoAppointment($base);
        $alert = new AlertGenerator();

        // Recogemos las variables necesarias
        $type = '';
        $options = array("Compra", "Prueba");
        if(isset($_POST['Type'])) {
            $type = $_POST['Type'];
        }

        // Obtenemos las citas segun el filtrado correspondiente
        $daoAppointment->list($_SESSION['client']['name'], $options[$type] ?? 'Compra');


        if(isset($_POST['Delete'])) {
            $daoAppointment->delete($_POST['Delete']);
            echo $alert->successAlert("Cita eliminada correctamente.");
        }

        function MostrarFecha($fechaSeg)
        {
            $rows = getdate($fechaSeg);

            $day = ($rows['mday'] < 10 ? '0' : '') . $rows['mday'];
            $month = ($rows['mon'] < 10 ? '0' : '') . $rows['mon'];
            
            $date = $day . "/" . $month . "/" .$rows['year'];

            return $date;
        }
    
    ?>
    <body class="bg-color">
        <form name='fapp' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                <div class='container mt-5'>
                    <div class='row'>
                        <?php 

                        if (count($daoAppointment->appointments)  != 0) {
                            echo "<div class='m-auto text-center'>";
                                echo "<h3>Seleccione el tipo de Cita que quiere consultar</h3>";
                                    echo "<select name='Type' onchange='document.fapp.submit()'>";
                                        foreach ($options as $k => $v) {
                                            echo "<option value='$k'";

                                            if($k == $type) {
                                                echo " selected ";
                                            }
                                            
                                            echo ">$v</option>";
                                        } 
                                    echo "</select>";
                            echo "</div>";
                        
                            foreach($daoAppointment->appointments as $appointment) {
                                echo '<div class="col-md-4 mb-4 d-flex align-items-stretch">';
                                echo '<div class="card shadow-sm border-0">';
                                    echo '<div class="product-content p-3 bg-dark text-white">';
                                        echo '<h5 class="product-title mb-1 fw-bold">' . $appointment->__get('title'). '</h5>';

                                        echo '<div class="d-flex flex-column mb-3">';
                                            echo "<p class='card-text'>".$appointment->__get('description')."</strong></p>";
                                            echo "<p class='card-text'> Fecha de la citación: ".MostrarFecha($appointment->__get('date'))."</p>";
                                        echo "</div>";

                                        echo "<button class='btn btn-danger mt-3' type='submit' name='Delete' value='".$appointment->__get('id')."'>Eliminar Cita</button>";
                                    echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo "<p class='text-center'>No tiene ninguna cita en su calendario</p>";
                        }
       
                        ?>
                    </div>
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