<?php
class Televiseur
{
    private $_modele;
    private $_nom;
    private $_marque;
    private $_prix;
    private $_frequence;
    private $_type_ecran;
    private $_hdr;
    private $_resolution;
    private $_taille;
    private $_os;
    private $_garantie;
    private $_lien;
    private $_ports;

    public function __construct($params = array(), $_ports) {
        foreach($params as $k => $v) {
           $methodName = "set_" . $k; 
    
           if(method_exists($this, $methodName)) {
              $this->$methodName($v);
           }
        }

        $this->_ports = $_ports;
     }

    /**
     * Get the value of _modele
     */ 
    public function get_modele()
    {
        return $this->_modele;
    }

    /**
     * Set the value of _modele
     *
     * @return  self
     */ 
    public function set_modele($_modele)
    {
        $this->_modele = $_modele;

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
     * Get the value of _marque
     */ 
    public function get_marque()
    {
        return $this->_marque;
    }

    /**
     * Set the value of _marque
     *
     * @return  self
     */ 
    public function set_marque($_marque)
    {
        $this->_marque = $_marque;

        return $this;
    }

    /**
     * Get the value of _prix
     */ 
    public function get_prix()
    {
        return $this->_prix;
    }

    /**
     * Set the value of _prix
     *
     * @return  self
     */ 
    public function set_prix($_prix)
    {
        $this->_prix = $_prix;

        return $this;
    }

    /**
     * Get the value of _frequence
     */ 
    public function get_frequence()
    {
        return $this->_frequence;
    }

    /**
     * Set the value of _frequence
     *
     * @return  self
     */ 
    public function set_frequence($_frequence)
    {
        $this->_frequence = $_frequence;

        return $this;
    }

    /**
     * Get the value of _type_ecran
     */ 
    public function get_type_ecran()
    {
        return $this->_type_ecran;
    }

    /**
     * Set the value of _type_ecran
     *
     * @return  self
     */ 
    public function set_type_ecran($_type_ecran)
    {
        $this->_type_ecran = $_type_ecran;

        return $this;
    }

    /**
     * Get the value of _hdr
     */ 
    public function get_hdr()
    {
        return $this->_hdr;
    }

    /**
     * Set the value of _hdr
     *
     * @return  self
     */ 
    public function set_hdr($_hdr)
    {
        $this->_hdr = $_hdr;

        return $this;
    }

    /**
     * Get the value of _resolution
     */ 
    public function get_resolution()
    {
        return $this->_resolution;
    }

    /**
     * Set the value of _resolution
     *
     * @return  self
     */ 
    public function set_resolution($_resolution)
    {
        $this->_resolution = $_resolution;

        return $this;
    }

    /**
     * Get the value of _taille
     */ 
    public function get_taille()
    {
        return $this->_taille;
    }

    /**
     * Set the value of _taille
     *
     * @return  self
     */ 
    public function set_taille($_taille)
    {
        $this->_taille = $_taille;

        return $this;
    }

    /**
     * Get the value of _os
     */ 
    public function get_os()
    {
        return $this->_os;
    }

    /**
     * Set the value of _os
     *
     * @return  self
     */ 
    public function set_os($_os)
    {
        $this->_os = $_os;

        return $this;
    }

    /**
     * Get the value of _garantie
     */ 
    public function get_garantie()
    {
        return $this->_garantie;
    }

    /**
     * Set the value of _garantie
     *
     * @return  self
     */ 
    public function set_garantie($_garantie)
    {
        $this->_garantie = $_garantie;

        return $this;
    }

    /**
     * Get the value of _lien
     */ 
    public function get_lien()
    {
        return $this->_lien;
    }

    /**
     * Set the value of _lien
     *
     * @return  self
     */ 
    public function set_lien($_lien)
    {
        $this->_lien = $_lien;

        return $this;
    }

    /**
     * Get the value of _ports
     */ 
    public function get_ports()
    {
        return $this->_ports;
    }

    /**
     * Set the value of _ports
     *
     * @return  self
     */ 
    public function set_ports($_ports)
    {
        $this->_ports = $_ports;

        return $this;
    }
}
?>