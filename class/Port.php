<?php
class Port {
  // Propriétés

  private $_id;
  private $_nom;

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
   * Get the value of _nom
   */ 
  public function get_nom()
  {
    return $this->_nom;
  }

  /**
   * Set the value of _nom
   *
   * @return  self
   */ 
  public function set_nom($_nom)
  {
    $this->_nom = $_nom;

    return $this;
  }
}
?>