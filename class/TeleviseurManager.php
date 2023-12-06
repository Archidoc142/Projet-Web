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

        const SELECT_PORTS_BY_MODEL = "SELECT p.nom, tp.nb_port FROM televiseur_port tp JOIN port p ON tp.id_port = p.id JOIN televiseur t ON tp.modele_televiseur = t.modele WHERE t.modele = :modele";
    
        private $_bdd;

        public function __construct(PDO $bdd)
        {
            $this->_bdd = $bdd;
        }

        public function getTeleviseurs()
        {
            $televiseurs = array();
            
            $result = $this->_bdd->query(SELF::SELECT_TVS)->fetchAll();
            
            foreach($result as $tv)
            {

                $ports = array();

                $query = $this->_bdd->prepare(SELF::SELECT_PORTS_BY_MODEL);
                $query->bindParam(':modele', $tv['modele']);
                $query->execute();

                $resultPorts = $query->fetchAll();
                
                foreach($resultPorts as $port)
                {
                    array_push($ports, $port['nb_port'] . "x " . $port['nom']);
                }
                
                array_push($televiseurs, new Televiseur($tv, $ports));
            }

            print_r($televiseurs);

        }
    
    }
?>