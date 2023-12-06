<?php
class User {
  // Propriétés

  private $_id;
  private $_pseudonyme;
  private $_courriel;
  private $_prenom;
  private $_nom;
  private $_langue;
  private $_photo;

  // Méthodes magiques

  public function __construct($params = array()) {
    foreach($params as $k => $v) {
       $methodName = "set_" . $k; 

       if(method_exists($this, $methodName)) {
          $this->$methodName($v);
       }
    }
 }

 public function __serialize(): array {
      return [
        'id' => $this->_id,
        'pseudonyme' => $this->_pseudonyme
      ];
  }

  public function __unserialize(array $data): void {
    $this->_id = $data['id'];
    $this->_pseudonyme = $data['pseudonyme'];
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
   * Get the value of _pseudonyme
   */ 
  public function get_pseudonyme()
  {
    return $this->_pseudonyme;
  }

  /**
   * Set the value of _pseudonyme
   *
   * @return  self
   */ 
  public function set_pseudonyme($_pseudonyme)
  {
    $this->_pseudonyme = $_pseudonyme;

    return $this;
  }

  /**
   * Get the value of _courriel
   */ 
  public function get_courriel()
  {
    return $this->_courriel;
  }

  /**
   * Set the value of _courriel
   *
   * @return  self
   */ 
  public function set_courriel($_courriel)
  {
    $this->_courriel = $_courriel;

    return $this;
  }

    /**
   * Get the value of _prenom
   */ 
  public function get_prenom()
  {
    return $this->_prenom;
  }

  /**
   * Set the value of _prenom
   *
   * @return  self
   */ 
  public function set_prenom($_prenom)
  {
    $this->_prenom = $_prenom;

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

  /**
   * Get the value of _langue
   */ 
  public function get_langue()
  {
    return $this->_langue;
  }

  /**
   * Set the value of _langue
   *
   * @return  self
   */ 
  public function set_langue($_langue)
  {
    $this->_langue = $_langue;

    return $this;
  }

  /**
   * Get the value of _photo
   */ 
  public function get_photo()
  {
    return $this->_photo;
  }

  /**
   * Set the value of _photo
   *
   * @return  self
   */ 
  public function set_photo($_photo)
  {
    $this->_photo = $_photo;

    return $this;
  }
}
?>