<?php
//Incluimos las librerías que necesitamos para gestionar los daos del cliente
require_once '../bd/libreriaPDO.php';
require_once '../entities/Article.php';

class DaoArticle extends DB
{
  //Array para almacenar clientes
  public $articles = array();

  //Constructor donde recogemos el nombre de la bbdd pasándolo como parámetro
  public function __construct($base)
  {
    $this->dbname = $base;
  }

  public function insertArticle($article) {
    $consulta = "INSERT INTO articles VALUES (:paragrahp1, :paragrahp2, :paragrahp3, :title, null, :emailBrand)";

    $param = array(
        ":paragrahp1" => $article->__get('paragrahp1'),
        ":paragrahp2" => $article->__get('paragrahp2'),
        ":paragrahp3" => $article->__get('paragrahp3'),
        ":title" => $article->__get('title'),
        ":emailBrand" => $article->__get('emailBrand'),
    );

    $this->ConsultaSimple($consulta, $param);
  }

  public function getarticles($emailBrand) {
    $consulta = "SELECT * FROM articles WHERE emailBrand=:emailBrand";

    $param = array(":emailBrand" => $emailBrand);

    $this->articles = array();

    $this->ConsultaDatos($consulta, $param);

    foreach ($this->filas as $row) {
      $article = new Article();

      $article->__set("id", $row["id"]);
      $article->__set("paragrahp1", $row["paragrahp1"]);
      $article->__set("paragrahp2", $row["paragrahp2"]);
      $article->__set("paragrahp3", $row["paragrahp3"]);
      $article->__set("title", $row["title"]);
      $article->__set("emailBrand", $row["emailBrand"]);
      
      $this->articles[] = $article;
    }
  }

    
  public function delete($id) {
    $consulta = "DELETE FROM articles WHERE id=:id";

    $param = array(
        ":id" => $id
    );

    $this->ConsultaSimple($consulta, $param);
  }


  public function update($article) {
    $consulta = "UPDATE articles 
                 SET paragrahp1=:paragrahp1, 
                     paragrahp2=:paragrahp2, 
                     paragrahp3=:paragrahp3, 
                     title=:title 
                 WHERE id=:id";

    $param = array(
        ":paragrahp1" => $article->__get('paragrahp1'),
        ":paragrahp2" => $article->__get('paragrahp2'),
        ":paragrahp3" => $article->__get('paragrahp3'),
        ":title" => $article->__get('title'),
        ":id" => $article->__get('id'),
    );

    $this->ConsultaSimple($consulta, $param);
  }

}
?>

