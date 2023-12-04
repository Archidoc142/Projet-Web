<?php
class Evaluation {
  // Propriétés

  private $_id_utilisateur;
  private $_modele_televiseur;
  private $_note;
  private $_commentaire;
  private $_titre;

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
   * Get the value of _id_utilisateur
   */ 
  public function get_id_utilisateur()
  {
    return $this->_id_utilisateur;
  }

  /**
   * Set the value of _id_utilisateur
   *
   * @return  self
   */ 
  public function set_id_utilisateur($_id_utilisateur)
  {
    $this->_id_utilisateur = $_id_utilisateur;

    return $this;
  }

  /**
   * Get the value of _modele_televiseur
   */ 
  public function get_modele_televiseur()
  {
    return $this->_modele_televiseur;
  }

  /**
   * Set the value of _modele_televiseur
   *
   * @return  self
   */ 
  public function set_modele_televiseur($_modele_televiseur)
  {
    $this->_modele_televiseur = $_modele_televiseur;

    return $this;
  }

  /**
   * Get the value of _note
   */ 
  public function get_note()
  {
    return $this->_note;
  }

  /**
   * Set the value of _note
   *
   * @return  self
   */ 
  public function set_note($_note)
  {
    $this->_note = $_note;

    return $this;
  }

  /**
   * Get the value of _commentaire
   */ 
  public function get_commentaire()
  {
    return $this->_commentaire;
  }

  /**
   * Set the value of _commentaire
   *
   * @return  self
   */ 
  public function set_commentaire($_commentaire)
  {
    $this->_commentaire = $_commentaire;

    return $this;
  }

  /**
   * Get the value of _titre
   */ 
  public function get_titre()
  {
    return $this->_titre;
  }

  /**
   * Set the value of _titre
   *
   * @return  self
   */ 
  public function set_titre($_titre)
  {
    $this->_titre = $_titre;

    return $this;
  }
}
?>