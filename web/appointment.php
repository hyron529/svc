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
        require_once('../dao/MessageDao.php');
        require_once('../entities/Message.php');
        require_once('../dao/ClientDAO.php');

        // Si no eres uusario no puedes acceder
        if(!isset($_SESSION['client'])) {
            header("Location: /svc/");
        }

        // Nombre de nuestra base de datos
        $base = "svc";

        // Creamos nuestros daos
        $daoAppointment = new DaoAppointment($base);
        $daoMessage = new DaoMessage($base);
        $daoClient = new DaoClient($base);
        $alert = new AlertGenerator();

        if (isset($_SESSION['client']) && $_SESSION['client']['role'] == 'client') {
            // Obtenemos el codigo del usuario actual
            $userNow = $daoClient->getClientCode($_SESSION['client']['name']);
            $code = $userNow['id'];
            $daoAppointment->list($code, ""); // mostramos las citas para el cliente
        } elseif ($_SESSION['client']['role'] == 'brand') {
            // obtenemos las citas que tiene una marca
            $daoAppointment->list("", $_SESSION['client']['name']);
        }


        if(isset($_POST['Delete'])) {
            $appointmentId = $_POST['Delete'];
            $daoMessage->deleteMessageAppointment($appointmentId);
            $daoAppointment->delete($appointmentId);
            echo $alert->successAlert("Cita eliminada correctamente.");
        }

        function FechaEpoch($fecha)   //Convierte una fecha en formato dd/mm/yyyy a segundos epoch
        {
            $camposFecha = explode("-", $fecha);

            // La convertimos a epoch para guardarla de esta forma
            $fechaEpoch = mktime(0, 0, 0, $camposFecha[1], $camposFecha[0], $camposFecha[2]);

            return $fechaEpoch;
        }


        if(isset($_POST['Crear'])) {
            $userNow = $daoClient->getClientCode($_POST['email']);

            if ($userNow != null) {
                $code = $userNow['id'];
                $appointment = new Appointment();
                $appointment->__set("title", $_POST['title']);
                $appointment->__set("description", $_POST['description']);
                $appointment->__set("date" , FechaEpoch($_POST['date']));
                $appointment->__set("idClient", $code);
                $appointment->__set("emailBrand", $_SESSION['client']['name']);
                $appointment->__set("type", "Prueba");
    
                $daoAppointment->insert($appointment);
                echo $alert->successAlert("La cita ha sido creada correctamente.");
            } else {
                echo $alert->dangerAlert("El correo introducido para asignarle la cita al usuario no es valido.");
            }
        }

        if(isset($_POST['Enviar'])) {
            $chatid = $_POST['Enviar'];
            $message = $_POST['message_' . $chatid] ?? null;

            $msgSend = new Message();
            $msgSend->__set("id_appointment", $chatid);
            $msgSend->__set("message", $message);
            $msgSend->__set("sender", $_SESSION['client']['name']);
            $msgSend->__set("role", $_SESSION['client']['role']);

            $daoMessage->insertMessage($msgSend);
            echo $alert->successAlert("Mensaje enviado correctamente.");
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
                        if(isset($_SESSION['client']) && $_SESSION['client']['role'] == 'brand') {
                            echo ' <div class="container d-flex justify-content-center mb-4"> ';
                            echo '
                            <button type="button" class="btn btn-danger btn-sm w-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Crear Cita
                            </button>
                            ';
                            echo '</div>';
                        }
                        if (count($daoAppointment->appointments)  != 0) {
                            echo "<h2 class='text-center'>CITAS</h2>";
                            foreach($daoAppointment->appointments as $appointment) {
                                echo '<div class="col-md-4 mb-4 d-flex align-items-stretch">';
                                echo '<div class="card shadow-sm border-0">';
                                    echo "<div class='product-content p-3"; 
                                        if ($appointment->__get('type') == 'Compra') {
                                            echo " bg-dark ";
                                        } else {
                                            echo " bg-secondary ";
                                        }
                                    echo " text-white'>";
                                        echo '<h5 class="product-title mb-1 fw-bold">' . $appointment->__get('title'). '</h5>';

                                        echo '<div class="d-flex flex-column mb-3">';
                                            echo "<p class='card-text'>".$appointment->__get('description')."</strong></p>";
                                            echo "<p class='card-text'> Fecha de la citación: ".MostrarFecha($appointment->__get('date'))."</p>";
                                        echo "</div>";

                                        echo "<button class='btn btn-danger mt-3' type='submit' name='Delete' value='".$appointment->__get('id')."'>Eliminar Cita</button>";
                                        echo "<button class='btn btn-success mt-3 ms-3' type='submit' name='Chat'>Chat</button><br>";

                                        if(isset($_POST['Chat'])) {
                                            $daoMessage->list($appointment->__get('id'));
                                            echo "<p class='mt-3'>Mensajes del chat:</p>";
                                            echo "<div class='mt-3 overflow-y-scroll' style='max-height: 300px; height:300px;'>";
                                                if (count($daoMessage->messages) !=0) {
                                                    foreach ($daoMessage->messages as $msg) {
                                                        echo '<div class="shadow-lg border-0 text-white mb-3 p-2">';
                                                            echo '<div class="card shadow-sm border-0">';
                                                                if ($msg->__get("role") == "brand") {
                                                                    echo "<div class='card-header bg-danger text-white'>Enviado por: " . $msg->__get("sender") . "</div>";
                                                                } else {
                                                                    echo "<div class='card-header bg-primary text-white'>Enviado por: " . $msg->__get("sender") . "</div>";
                                                                }
                                                                
                                                                echo "<div class='card-body bg-dark'>";
                                                                    echo "<p>" . $msg->__get("message") . "</p>";
                                                                echo '</div>';
                                                            echo '</div>';
                                                        echo '</div>';
                                                    }
                                                } else {
                                                    echo "<p>No hay mensajes en esta conversación.</p>";
                                                }
                                               
                                            echo "</div>";
                                            echo '<div class="mt-2 mb-3">';
                                            echo "<textarea placeholder='Escribe un mensaje...' class='form-control' name='message_" . $appointment->__get('id') . "'></textarea>";
                                            echo '</div>';
                                            echo "<button type='submit' value='".$appointment->__get('id')."' name='Enviar'>Enviar</button>";
                                        }
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
                                <label for="title" class="form-label">Introduce el titulo de la cita</label>
                                <input type="text" name="title" class="form-control" placeholder="Titulo de la cita." required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Introduce la descripcion de la cita</label>
                                <input type="text" name="description" class="form-control" placeholder="Descripcion de la cita." required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Introduce la fecha de la cita</label>
                                <input type="date" name="date" class="form-control" placeholder="Introduce la fecha de la cita." required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Introduce el correo del cliente</label>
                                <input type="email" name="email" class="form-control" placeholder="Introduce el correo del cliente." required>
                            </div>
                            <div class="d-grid gap-2 mb-3" class="form-label">
                                <input type="submit" class="btn btn-primary" name="Crear" value="Crear">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            require_once('../views/footer.php');
            require_once('../utils/scripts.php');
        ?>
        <script type="module" src="../resources/js/index.js"></script>
    </body>
</html>