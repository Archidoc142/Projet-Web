<?php
class UserManager {
  const SELECT_USER_BY_ID = "SELECT utilisateur.*, langue.nom_complet AS langue FROM utilisateur INNER JOIN langue ON utilisateur.id_langue = langue.id WHERE utilisateur.id = :idUser";
  const UPDATE_USER_INFOS = "UPDATE utilisateur SET pseudonyme = :pseudonyme, courriel = :courriel, nom = :nom, prenom = :prenom, id_langue = :id_langue, photo = :photo";

  const SELECT_LANGUE='SELECT * FROM langue';
  const SELECT_LAST_USER ='SELECT * FROM utilisateur';
  const SELECT_USER_ID='SELECT * FROM utilisateur WHERE courriel = :courriel';
  
  private $_bdd;

  public function __construct(PDO $bdd) { $this->_bdd = $bdd; }

  public function getLangue(){
    $query = $this->_bdd->prepare(self::SELECT_LANGUE);
    $query->execute();
    $result = $query->fetchAll();
    return $result;
}




public function addUser(User $user) 
{
        $hashedPassword = password_hash($user->get_mdp(), PASSWORD_DEFAULT);
        $sql = 'INSERT INTO utilisateur (pseudonyme, mdp, courriel, nom, prenom, id_langue) VALUES (:pseudonyme, :mdp, :courriel, :nom, :prenom, :id_langue)';
        $query = $this->_bdd->prepare($sql);
        $params = array(':pseudonyme'=>$user->get_pseudonyme(), 
                        ':mdp'=>$hashedPassword,
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
        $query->execute();
        $user = $query->fetch();

        if($user && password_verify($mdp, $user['mdp'])){
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