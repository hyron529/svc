<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/Order.php';

class DaoOrder extends DB
{
  //Array para almacenar marcas
  public $orders = array();

  //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
  public function __construct($base)
  {
    $this->dbname = $base;
  }

  public function insert($order)
  {
    $consulta = "INSERT INTO car_order VALUES (null, :orderdate, :emailclient, :sent)";

    $param = array(
      ":orderdate" => $order->__get('order_date'),
      ":emailclient" => $order->__get('emailClient'),
      ":sent" => $order->__get('sent'),
    );

    $this->ConsultaSimple($consulta, $param);
  }

  public function existOrderClient($clien_email) {
    $consulta = 'SELECT id FROM car_order WHERE emailClient=:clientemail and sent=false'; 

    $param = array(":clientemail" => $clien_email);

    $this->ConsultaDatos($consulta, $param);

    return $this->filas[0] ?? null;
  }

  public function sendOrder($clien_email) {
    $consulta = "UPDATE car_order SET sent=true where emailClient=:clientemail";

    $param = array(":clientemail" => $clien_email);

    $this->ConsultaSimple($consulta, $param);
  }
}

