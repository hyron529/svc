<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/Brand.php';

class DaoBrand extends DB {
    //Array para almacenar marcas
    public $brands = array();

    //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
    public function __construct($base) {
        $this->dbname = $base;
    }

    /*  
        Método para insertar un cliente en la BBDD
        Realizamos la consulta que nos va a permitor insertar nuevos clientes
        Asignamos los valores del cliente a los parámetros definidos en la consulta
        Finalmente, llamamos a consultaSimple para ejecutar la consulta y realizar la inserción 
    */
    public function insertBrand($brand) {
        $consulta = "INSERT INTO brand VALUES (:name, :foundation_date, :country, :headquarter, :email, :website)";

        $param = array(
            ":name" => $brand->__get('name'),
            ":foundation_date" => $brand->__get('foundation_date'),
            ":country" => $brand->__get('country'),
            ":headquarter" => $brand->__get('headquarter'),
            ":email" => $brand->__get('email'),
            ":website" => $brand->__get('website')
        );

        $this->ConsultaSimple($consulta, $param);
    }
}
?>

