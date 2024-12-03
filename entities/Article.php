<?php

class Article
{

  private $id;
  private $title;
  private $paragrahp1;
  private $paragrahp2;
  private $paragrahp3;

  public function __get($name)
  {
    return $this->$name;
  }

  public function __set($name, $value)
  {
    return $this->$name = $value;
  }
}

?>