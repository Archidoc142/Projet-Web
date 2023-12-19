<?php
class Favori {
  private $_id_utilisateur;
  private $_modele_televiseur;

  public function __construct($params = array()) {
    foreach($params as $k => $v) {
       $methodName = "set_" . $k; 

       if(method_exists($this, $methodName)) {
          $this->$methodName($v);
       }
    }
 }

  public function get_id_utilisateur()
  {
    return $this->_id_utilisateur;
  }

  public function set_id_utilisateur($_id_utilisateur)
  {
    $this->_id_utilisateur = $_id_utilisateur;

    return $this;
  }

  public function get_modele_televiseur()
  {
    return $this->_modele_televiseur;
  }

  public function set_modele_televiseur($_modele_televiseur)
  {
    $this->_modele_televiseur = $_modele_televiseur;

    return $this;
  }
}
?>