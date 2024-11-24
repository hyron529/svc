<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/Appointment.php';

class DaoAppointment extends DB {
    //Array para almacenar marcas
    public $appointments = array();

    //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
    public function __construct($base) {
        $this->dbname = $base;
    }

    
    public function insert($appointment) {
        $consulta = "INSERT INTO appointment VALUES (null, :title, :description, :date, :emailClient, :emailBrand, :type)";

        $param = array(
            ":title" => $appointment->__get('title'),
            ":description" => $appointment->__get('description'),
            ":date" => $appointment->__get('date'),
            ":emailClient" => $appointment->__get('emailClient'),
            ":emailBrand" => $appointment->__get('emailBrand'),
            ":type" => $appointment->__get('type'),
        );

        $this->ConsultaSimple($consulta, $param);
    }
}
?>
