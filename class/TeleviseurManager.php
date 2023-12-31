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

        CONST SELECT_TELEVISEUR_BY_EVALUATION = "SELECT * FROM evaluation
                          INNER JOIN televiseur ON modele = modele_televiseur
                          WHERE note >= :note AND commentaire LIKE :commentaire";

        CONST SELECT_EVALUATION_BY_MODELE = "SELECT note FROM evaluation WHERE modele_televiseur = :modele";

        const SELECT_TELEVISEURS_BY_PORT = "SELECT televiseur.* FROM televiseur INNER JOIN televiseur_port ON televiseur.modele = televiseur_port.modele_televiseur WHERE televiseur_port.id_port = :idPort";

        const SELECT_TELEVISEUR_MARQUE='SELECT televiseur.*, marque.nom FROM televiseur 
                                                INNER JOIN marque ON televiseur.id_marque = marque.id
                                                WHERE id_marque = :id_marque';

        const SELECT_TELEVISEURS_BY_MARQUE='SELECT televiseur.* FROM televiseur 
                                            INNER JOIN marque ON televiseur.id_marque = marque.id
                                            WHERE id_marque = :id_marque';

        const SELECT_TELEVISEUR_BY_CATEGORIE = 'SELECT televiseur.*, marque.nom FROM televiseur
        INNER JOIN marque ON televiseur.id_marque = marque.id
        WHERE .$categorie. = :valeur';

        const INSERT_TELEVISEUR = 'INSERT INTO televiseur VALUES (:modele, :nom, :marque, :prix, :frequence, :type_ecran, :hdr, :resolution, :taille, :os, :garantie, :lien)';
        const INSERT_TV_PORTS = 'INSERT INTO televiseur_port VALUES (:nb_port, :modele, :id_port)';

        const FILTER_TELEVISEUR ='SELECT televiseur.* FROM televiseur 
                                INNER JOIN marque ON televiseur.id_marque = marque.id
                                WHERE televiseur.nom LIKE :mots OR modele LIKE :mots OR marque.nom LIKE :mots';

        const SELECT_MARQUES = 'SELECT * FROM marque';
        const SELECT_MARQUES_NOMS = "SELECT nom FROM marque";

        const SELECT_CATEGORIE ='SHOW TABLES';

        const SELECT_PORTS_NOMS = "SELECT nom FROM port";
        const SELECT_PORTS_BY_MODEL = "SELECT p.nom, tp.nb_port FROM televiseur_port tp JOIN port p ON tp.id_port = p.id JOIN televiseur t ON tp.modele_televiseur = t.modele WHERE t.modele = :modele";
        const SELECT_ALL_PORTS = "SELECT * FROM port";

        const SELECT_TYPES_ECRAN = "SELECT * FROM type_ecran";
        const SELECT_RESOLUTIONS = "SELECT * FROM resolution";
        const SELECT_OS = "SELECT * FROM os";
        
        const TOP_TWO = "ORDER BY prix DESC LIMIT 2";

        private $_bdd;

        public function __construct(PDO $bdd)
        {
            $this->_bdd = $bdd;
        }

        public function getAllPorts() : array
        {
            return $this->_bdd->query(SELF::SELECT_ALL_PORTS)->fetchAll();
        }

        public function getAllMarques() : array
        {
            return $this->_bdd->query(SELF::SELECT_MARQUES)->fetchAll();
        }

        public function getResolutions() : array
        {
            return $this->_bdd->query(SELF::SELECT_RESOLUTIONS)->fetchAll();
        }

        public function getOSes() : array
        {
            return $this->_bdd->query(SELF::SELECT_OS)->fetchAll();
        }

        public function getTypesEcran() : array
        {
            return $this->_bdd->query(SELF::SELECT_TYPES_ECRAN)->fetchAll();
        }

        public function addTeleviseur(array $postData)
        {
            $ports = array();

            for($i = 1; $i <= 17; $i++)
            {
                if($postData[$i] != "0")
                {
                    array_push($ports, array($i, $postData[$i]));
                }
            }

            $query = $this->_bdd->prepare(self::INSERT_TELEVISEUR);

            $query->bindParam(':modele', $postData['modele']);
            $query->bindParam(':nom', $postData['nom']);
            $query->bindParam(':marque', $postData['marque']);
            $query->bindParam(':prix', $postData['prix']);
            $query->bindParam(':frequence', $postData['frequence']);
            $query->bindParam(':type_ecran', $postData['type_ecran']);
            $query->bindParam(':hdr', $postData['hdr'], PDO::PARAM_INT);
            $query->bindParam(':resolution', $postData['resolution']);
            $query->bindParam(':taille', $postData['taille'], PDO::PARAM_INT);
            $query->bindParam(':os', $postData['os']);
            $query->bindParam(':garantie', $postData['garantie']);
            $query->bindParam(':lien', $postData['lien']);

            assert($query->execute(), "L'insertion du téléviseur dans la base de données n'a pas fonctionné.");

            foreach($ports as $port)
            {
                $query = $this->_bdd->prepare(self::INSERT_TV_PORTS);
                $query->bindParam(':nb_port', $port[1]);
                $query->bindParam(':id_port', $port[0]);
                $query->bindParam(':modele', $postData['modele']);

                assert($query->execute(), "L'insertion des ports du téléviseur dans la base de données n'a pas fonctionné.");
            }
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

        public function searchTeleviseur($mots)
        {
            $televiseurs = array();

            $query = $this->_bdd->prepare(self::FILTER_TELEVISEUR);
            $mots = '%' . $mots . '%';
            $query->bindParam(':mots', $mots);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach($result as $tv)
            {
                $ports = $this->getPortsByModel($tv['modele']);
                array_push($televiseurs, new Televiseur($tv, $ports));
            }

            return $televiseurs;
        }

        public function getTvByEvaluation($note, $commentaire){
            $televiseurs = array();
            
            $query = $this->_bdd->prepare(self::SELECT_TELEVISEUR_BY_EVALUATION);
            $query->bindParam(':note', $note);
            $query->bindValue(':commentaire', '%'.$commentaire.'%');
            $query->execute();
            $result = $query->fetchAll();

            foreach($result as $tv)
            {
                $ports = $this->getPortsByModel($tv['modele']);
                array_push($televiseurs, new Televiseur($tv, $ports));
            }

            return $televiseurs;
        }

        public function getEvaluationByModele($modele){
            $query = $this->_bdd->prepare(self::SELECT_EVALUATION_BY_MODELE);
            $query->bindParam(':modele', $modele);
            $query->execute();
            $result = $query->fetch();
            return $result;
        }

        public function getTelevisionsCategorie($categorie){
            $query= "SELECT * FROM $categorie";
            $query = $this->_bdd->prepare($query);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
            return $result;
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
            $result = $this->_bdd->query(SELF::SELECT_MARQUES_NOMS)->fetchAll();
            
            foreach($result as $marque)
            {
                array_push($marques, $marque['nom']);
            }
            return $marques;
        }

        public function getMarque(){
            $query = $this->_bdd->prepare(self::SELECT_MARQUES);
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
        
        public function getPorts() : array
        {
            $ports = array();
            $result = $this->_bdd->query(SELF::SELECT_PORTS_NOMS)->fetchAll();
            
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
    
        public function getTeleviseurObjectByModele(string $modele) 
        {
          $query = $this->_bdd->prepare(self::SELECT_TV_BY_MODEL);
      
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
          $televiseurs = array();

          $query = $this->_bdd->prepare(self::SELECT_TELEVISEURS_BY_PORT);
      
          $query->execute(array(':idPort' => $idPort));
      
          $result = $query->fetchAll();
      
          foreach($result as $tv)
          {
              $ports = $this->getPortsByModel($tv['modele']);
              array_push($televiseurs, new Televiseur($tv, $ports));
          }

          return $televiseurs;
        }

        public function getTeleviseursByMarque(int $idMarque) 
        {
          $televiseursArray = array();

          $query = $this->_bdd->prepare(self::SELECT_TELEVISEURS_BY_MARQUE);
      
          $query->execute(array(':id_marque' => $idMarque));
      
          $bddResult = $query->fetchAll();
      
          foreach ($bddResult as $row) {
            array_push($televiseursArray, new Televiseur($row, 0));
          }
      
          return $televiseursArray;
        }
    
        public function getTelevisionsMarque($id_marque)
        {
            $query = $this->_bdd->prepare(self::SELECT_TELEVISEUR_MARQUE);
            $query->bindParam(':id_marque', $id_marque);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
?>