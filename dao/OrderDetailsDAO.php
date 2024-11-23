<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/OrderDetails.php';

class DaoOrderDetails extends DB
{
  //Array para almacenar marcas
  public $orderDetails = array();

  //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
  public function __construct($base)
  {
    $this->dbname = $base;
  }

  public function insert($order)
  {
    $consulta = "INSERT INTO order_details VALUES (:quantity, :extra, :color, :idorder, :idcar)";

    $param = array(
      ":quantity" => $order->__get('quantity'),
      ":extra" => $order->__get('extra'),
      ":color" => $order->__get('color'),
      ":idorder" => $order->__get('id_order'),
      ":idcar" => $order->__get('id_car')
    );

    $this->ConsultaSimple($consulta, $param);
  }


  public function existsOderDetails($idorder, $idcar, $extra, $color) {
    $consulta = 'SELECT quantity FROM order_details WHERE id_order=:idorder and id_car=:idcar and extra=:extra and color=:color';

    $param = array(
        ":idorder" => $idorder,
        ":idcar" => $idcar,
        ":extra" => $extra,
        ":color" => $color,
    );

    $this->ConsultaDatos($consulta, $param);    

    return $this->filas[0] ?? null;
  }

  public function add($quantity, $idorder, $idcar,  $extra, $color) {
    $consulta = "UPDATE order_details SET quantity=:quantity WHERE id_order=:idorder and id_car=:idcar and extra=:extra and color=:color";

    $param = array(
        ":quantity" => $quantity,
        ":idorder" => $idorder,
        ":idcar" => $idcar,
        ":extra" => $extra,
        ":color" => $color,
    );

    $this->ConsultaSimple($consulta, $param);
  }
}

