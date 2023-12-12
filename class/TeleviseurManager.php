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
        
        const SELECT_TELEVISEUR_OBJECT_BY_MODELE = "SELECT * FROM televiseur WHERE modele = :modele";

        const SELECT_TELEVISEURS_BY_PORT = "SELECT televiseur.* FROM televiseur INNER JOIN televiseur_port ON televiseur.modele = televiseur_port.modele_televiseur WHERE televiseur_port.id_port = :idPort";

        const SELECT_MARQUES = "SELECT nom FROM marque";

        const SELECT_PORTS = "SELECT nom FROM port";
        const SELECT_PORTS_BY_MODEL = "SELECT p.nom, tp.nb_port FROM televiseur_port tp JOIN port p ON tp.id_port = p.id JOIN televiseur t ON tp.modele_televiseur = t.modele WHERE t.modele = :modele";

        const SELECT_MARQUE='SELECT * FROM marque';
        const SELECT_TELEVISEUR_MARQUE='SELECT televiseur.*, marque.nom FROM televiseur 
                                        INNER JOIN marque ON televiseur.id_marque = marque.id
                                        WHERE id_marque = :id_marque';

        const SELECT_TELEVISEUR='SELECT televiseur.*, marque.nom as nomTeleviseur  FROM televiseur 
                          INNER JOIN marque ON televiseur.id_marque = marque.id
                          INNER JOIN type_ecran ON televiseur.id_type_ecran = type_ecran.id
                          INNER JOIN resolution ON televiseur.id_resolution = resolution.id
                          INNER JOIN os ON televiseur.id_os = os.id LIMIT 10';

        const SELECT_CATEGORIE ='SHOW TABLES';

        const FILTER_TELEVISEUR ='SELECT televiseur.*, marque.nom FROM televiseur 
                                  INNER JOIN marque ON televiseur.id_marque = marque.id
                                  WHERE televiseur.nom LIKE :mots OR modele LIKE :mots OR marque.nom LIKE :mots';
                                  
        const SELECT_TELEVISEUR_BY_CATEGORIE = 'SELECT televiseur.*, marque.nom FROM televiseur
                                                INNER JOIN marque ON televiseur.id_marque = marque.id
                                                WHERE .$categorie. = :valeur';
                 
    
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

        // public function getTeleviseurByModele($_modele)
        // {
        //     $query = $this->_bdd->prepare(SELF::SELECT_TV_BY_MODEL);
        //     $query->bindParam(':modele', $_modele);
        //     $query->execute();

        //     $result = $query->fetch();

        //     $ports = $this->getPortsByModel($_modele);

        //     $tv = new Televiseur($result, $ports);

        //     return $tv;

        // }

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

        public function getMarque(){
            $query = $this->_bdd->prepare(self::SELECT_MARQUE);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }

        public function getCategorie(){
            $query = $this->_bdd->prepare(self::SELECT_CATEGORIE);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_COLUMN);
            $excludedTables = array('utilisateur', 'evaluation', 'favoris', 'langue', 'televiseur_port');
            $categories = array_diff($result, $excludedTables);
            return $categories;
        }

        public function getTeleviseur(){
            $query = $this->_bdd->prepare(self::SELECT_TELEVISEUR);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }
          
        
        public function searchTeleviseur($mots)
        {
            
            $query = $this->_bdd->prepare(self::FILTER_TELEVISEUR);
            $mots = '%' . $mots . '%';
            $query->bindParam(':mots', $mots);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        }

        public function getTelevisionsCategorie($categorie){
            $query= "SELECT * FROM $categorie";
            $query = $this->_bdd->prepare($query);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
            return $result;
        }

        public function getTelevisionsByCategorie($categorie, $valeur){
        $query = $this->_bdd->prepare(self::SELECT_TELEVISEUR_BY_CATEGORIE);
        $query->bindParam(':valeur', $valeur);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        }

        public function getTelevisionsMarque($id_marque){
            $query = $this->_bdd->prepare(self::SELECT_TELEVISEUR_MARQUE);
            $query->bindParam(':id_marque', $id_marque);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
            }

        public function getTeleviseurObjectByModele(string $modele) 
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