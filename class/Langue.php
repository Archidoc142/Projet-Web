<?php
class Langue {
  // Propriétés

  private $_id;
  private $_nom_complet;
  private $_acronyme;

  // Méthodes magiques

  public function __construct($params = array()) {
    foreach($params as $k => $v) {
       $methodName = "set_" . $k; 

       if(method_exists($this, $methodName)) {
          $this->$methodName($v);
       }
    }
 }

  // Méthodes

  /**
   * Get the value of _id
   */ 
  public function get_id()
  {
    return $this->_id;
  }

  /**
   * Set the value of _id
   *
   * @return  self
   */ 
  private function set_id($_id)
  {
    $this->_id = $_id;

    return $this;
  }

  /**
   * Get the value of _nom_complet
   */ 
  public function get_nom_complet()
  {
    return $this->_nom_complet;
  }

  /**
   * Set the value of _nom_complet
   *
   * @return  self
   */ 
  public function set_nom_complet($_nom_complet)
  {
    $this->_nom_complet = $_nom_complet;

    return $this;
  }

  /**
   * Get the value of _acronyme
   */ 
  public function get_acronyme()
  {
    return $this->_acronyme;
  }

  /**
   * Set the value of _acronyme
   *
   * @return  self
   */ 
  public function set_acronyme($_acronyme)
  {
    $this->_acronyme = $_acronyme;

    return $this;
  }
}
?>