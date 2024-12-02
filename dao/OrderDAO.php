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
    $consulta = "INSERT INTO car_order VALUES (null, :orderdate, :idClient, :sent)";

    $param = array(
      ":orderdate" => $order->__get('order_date'),
      ":idClient" => $order->__get('idClient'),
      ":sent" => $order->__get('sent'),
    );

    $this->ConsultaSimple($consulta, $param);
  }

  public function existOrderClient($idClient ) {
    $consulta = 'SELECT id FROM car_order WHERE idClient=:idClient and sent=false'; 

    $param = array(":idClient" => $idClient );

    $this->ConsultaDatos($consulta, $param);

    return $this->filas[0] ?? null;
  }

  public function sendOrder($idClient) {
    $consulta = "UPDATE car_order SET sent=true where idClient=:idClient";

    $param = array(":idClient" => $idClient);

    $this->ConsultaSimple($consulta, $param);
  }
}

