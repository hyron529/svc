<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/Message.php';

class DaoMessage extends DB
{
  //Array para almacenar clientes
  public $messages = array();

  //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
  public function __construct($base)
  {
    $this->dbname = $base;
  }

  /*  
      Método para insertar un mensaje en la BBDD
      Realizamos la consulta que nos va a permitir insertar nuevos mensajes
      Asignamos los valores del mensajes a los parámetros definidos en la consulta
      Finalmente, llamamos a consultaSimple para ejecutar la consulta y realizar la inserción 
  */
  public function insertMessage($msg)
  {
    $consulta = "INSERT INTO message VALUES (null, :message, :idappointment, :sender, :role)";

    $param = array(
      ":message" => $msg->__get('message'),
      ":idappointment" => $msg->__get('id_appointment'),
      ":sender" => $msg->__get('sender'),
      ":role" => $msg->__get('role')
    );

    $this->ConsultaSimple($consulta, $param);
  }

  public function list($idappointment) {
    $consulta = "SELECT message, sender, role FROM message WHERE id_appointment=:idappointment";

    $param = array(
      ":idappointment" => $idappointment
    );

    $this->messages = array();

    $this->ConsultaDatos($consulta, $param);

    foreach($this->filas as $fila) {
      $message = new Message();
      $message->__set("message", $fila['message']);
      $message->__set("sender", $fila['sender']);
      $message->__set("role", $fila['role']);

      $this->messages[] = $message;
    }
  }

  public function deleteMessageAppointment($id) {
    $consulta = "DELETE FROM message WHERE id_appointment=:id";

        $param = array(
            ":id" => $id
        );

        $this->ConsultaSimple($consulta, $param);
  }

}
?>