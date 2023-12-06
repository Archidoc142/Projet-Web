<?php
class UserManager {
  const SELECT_USER_BY_ID = "SELECT utilisateur.*, langue.nom_complet AS langue FROM utilisateur INNER JOIN langue ON utilisateur.id_langue = langue.id WHERE utilisateur.id = :idUser";
  const UPDATE_USER_INFOS = "UPDATE utilisateur SET pseudonyme = :pseudonyme, courriel = :courriel, nom = :nom, prenom = :prenom, id_langue = :id_langue, photo = :photo";

  const SELECT_LANGUE='SELECT * FROM langue';
  const SELECT_LAST_USER ='SELECT * FROM utilisateur';
  const SELECT_USER_ID='SELECT * FROM utilisateur WHERE courriel = :courriel AND mdp = :mdp';
  const SELECT_MARQUE='SELECT * FROM marque';
  const SELECT_TELEVISEUR='SELECT televiseur.*, marque.nom as nomTeleviseur  FROM televiseur 
                          INNER JOIN marque ON televiseur.id_marque = marque.id
                          INNER JOIN type_ecran ON televiseur.id_type_ecran = type_ecran.id
                          INNER JOIN resolution ON televiseur.id_resolution = resolution.id
                          INNER JOIN os ON televiseur.id_os = os.id LIMIT 2';
  private $_bdd;

  public function __construct(PDO $bdd) { $this->_bdd = $bdd; }

  public function getLangue(){
    $query = $this->_bdd->prepare(self::SELECT_LANGUE);
    $query->execute();
    $result = $query->fetchAll();
    return $result;
}

public function getMarque(){
  $query = $this->_bdd->prepare(self::SELECT_MARQUE);
  $query->execute();
  $result = $query->fetchAll();
  return $result;
}

public function getTeleviseur(){
  $query = $this->_bdd->prepare(self::SELECT_TELEVISEUR);
  $query->execute();
  $result = $query->fetchAll();
  return $result;
}


public function addUser(User $user) 
{
        
        $sql = 'INSERT INTO utilisateur (pseudonyme, mdp, courriel, nom, prenom, id_langue) VALUES (:pseudonyme, :mdp, :courriel, :nom, :prenom, :id_langue)';
        $query = $this->_bdd->prepare($sql);
        $params = array(':pseudonyme'=>$user->get_pseudonyme(), 
                        ':mdp'=>$user->get_mdp(),
                        ':courriel'=>$user->get_courriel(), 
                        ':nom'=>$user->get_nom(), ':prenom'=>$user->get_prenom(), 
                        ':id_langue'=>$user->get_langue());
  
        $result = $query->execute($params);
        
        return $result;
}

public function userExists($courriel, $mdp)
{
        $query = $this->_bdd->prepare(self::SELECT_USER_ID);
        $query->bindParam(':courriel', $courriel);
        $query->bindParam(':mdp', $mdp);
        $query->execute();
        $user = $query->fetch();

        if($user){
            return $user;
        }
        else{
            return false;
        }
        
}

public function getLastUser(){
  $query = $this->_bdd->prepare(self::SELECT_LAST_USER);
  $query->execute();
  $result = $query->fetch();
  return $result;
}

  public function getUserById(int $idUser) {
    $query = $this->_bdd->prepare(self::SELECT_USER_BY_ID);

    $query->execute(array(':idUser' => $idUser));

    $bddResult = $query->fetch();

    if ($bddResult) {
      return new User($bddResult);
    }
    else {
      return null;
    }
  }

  public function updateProfile(User $newUser) {
    $methodesGet = preg_grep('/^get_/', get_class_methods($newUser));
    $paramArray = array();

    foreach ($methodesGet as $nomMethode) {
      $paramArray[':' . substr($nomMethode, 4)] = $newUser->$nomMethode();
    }
  }
}
?>