<?php
    require_once('./class/Televiseur.php');

    class TeleviseurManager
    {
        const SELECT_TVS = "SELECT t.modele, t.nom, m.nom AS marque, t.prix, t.frequence, e.nom AS type_ecran, t.hdr, r.nom AS resolution, t.taille, os.nom as os, t.garantie, t.lien FROM televiseur t
                            JOIN marque m ON m.id = t.id_marque
                            JOIN resolution r ON r.id = t.id_resolution
                            JOIN type_ecran e ON e.id = t.id_type_ecran
                            JOIN os ON os.id = t.id_os";

        const SELECT_TV_BY_MODEL = "SELECT t.modele, t.nom, m.nom AS marque, t.prix, t.frequence, e.nom AS type_ecran, t.hdr, r.nom AS resolution, t.taille, os.nom as os, t.garantie, t.lien FROM televiseur t
                                    JOIN marque m ON m.id = t.id_marque
                                    JOIN resolution r ON r.id = t.id_resolution
                                    JOIN type_ecran e ON e.id = t.id_type_ecran
                                    JOIN os ON os.id = t.id_os
                                    WHERE t.modele = :modele";
        
        CONST SELECT_TELEVISEUR_OBJECT_BY_MODELE = "SELECT * FROM televiseur WHERE modele = :modele";

        const SELECT_TELEVISEURS_BY_PORT = "SELECT televiseur.* FROM televiseur INNER JOIN televiseur_port ON televiseur.modele = televiseur_port.modele_televiseur WHERE televiseur_port.id_port = :idPort";

        const SELECT_MARQUES = "SELECT nom FROM marque";

        const SELECT_PORTS = "SELECT nom FROM port";
        const SELECT_PORTS_BY_MODEL = "SELECT p.nom, tp.nb_port FROM televiseur_port tp JOIN port p ON tp.id_port = p.id JOIN televiseur t ON tp.modele_televiseur = t.modele WHERE t.modele = :modele";
    
        const TOP_TWO = "ORDER BY prix DESC LIMIT 2";

        private $_bdd;

        public function __construct(PDO $bdd)
        {
            $this->_bdd = $bdd;
        }

        public function getTeleviseurs() : array
        {
            $televiseurs = array();
            
            $result = $this->_bdd->query(SELF::SELECT_TVS)->fetchAll();
            
            foreach($result as $tv)
            {
                $ports = $this->getPortsByModel($tv['modele']);
                array_push($televiseurs, new Televiseur($tv, $ports));
            }

            return $televiseurs;

        }

        public function getTeleviseurByModele($_modele)
        {
            $query = $this->_bdd->prepare(SELF::SELECT_TV_BY_MODEL);
            $query->bindParam(':modele', $_modele);
            $query->execute();

            $result = $query->fetch();

            $ports = $this->getPortsByModel($_modele);

            $tv = new Televiseur($result, $ports);

            return $tv;

        }

        public function getPortsByModel($_modele) : array
        {
            $ports = array();

            $query = $this->_bdd->prepare(SELF::SELECT_PORTS_BY_MODEL);
            $query->bindParam(':modele', $_modele);
            $query->execute();

            $resultPorts = $query->fetchAll();
            
            foreach($resultPorts as $port)
            {
                array_push($ports, $port['nb_port'] . "x " . $port['nom']);
            }

            return $ports;
        }

        public function getMarques() : array
        {
            $marques = array();
            $result = $this->_bdd->query(SELF::SELECT_MARQUES)->fetchAll();
            
            foreach($result as $marque)
            {
                array_push($marques, $marque['nom']);
            }
            return $marques;
        }
        
        public function getPorts() : array
        {
            $ports = array();
            $result = $this->_bdd->query(SELF::SELECT_PORTS)->fetchAll();
            
            foreach($result as $port)
            {
                array_push($ports, $port['nom']);
            }
            return $ports;
        }

        public function getTopTwoTeleviseurs() : array
        {
            $televiseurs = array();
            
            $result = $this->_bdd->query(SELF::SELECT_TVS . " " . SELF::TOP_TWO)->fetchAll();
            
            foreach($result as $tv)
            {
                $ports = $this->getPortsByModel($tv['modele']);
                array_push($televiseurs, new Televiseur($tv, $ports));
            }

            return $televiseurs;
        }
    
        public function getTeleviseurByModele(string $modele) 
        {
          $query = $this->_bdd->prepare(self::SELECT_TELEVISEUR_OBJECT_BY_MODELE);
      
          $query->execute(array(':modele' => $modele));
      
          $bddResult = $query->fetch();
      
          if ($bddResult) 
          {
            return new Televiseur($bddResult, 0);
          }
          else 
          {
            return null;
          }
        }

        public function getTeleviseursByPort(int $idPort) 
        {
          $televiseursArray = array();

          $query = $this->_bdd->prepare(self::SELECT_TELEVISEURS_BY_PORT);
      
          $query->execute(array(':idPort' => $idPort));
      
          $bddResult = $query->fetchAll();
      
          foreach ($bddResult as $row) {
            array_push($televiseursArray, new Televiseur($row, 0));
          }
      
          return $televiseursArray;
        }
    }
?>