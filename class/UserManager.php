<?php
require_once('./class/TeleviseurManager.php');

class UserManager {
  const SELECT_USER_BY_ID = "SELECT utilisateur.* FROM utilisateur WHERE utilisateur.id = :idUser";
  const SELECT_USER_PHOTO = "SELECT photo FROM utilisateur WHERE id = :idUser";
  const UPDATE_USER_INFOS = "UPDATE utilisateur SET courriel = :courriel, nom = :nom, prenom = :prenom, id_langue = :id_langue, photo = :photo WHERE id = :idUser";
  const UPDATE_USER_PASSWORD = "UPDATE utilisateur SET mdp = :nouveauMdp WHERE id = :idUser AND mdp = :ancienMdp";

  const SELECT_LANGUE='SELECT * FROM langue';
  const SELECT_LAST_USER ='SELECT * FROM utilisateur';
  const SELECT_USER_ID='SELECT * FROM utilisateur WHERE courriel = :courriel AND mdp = :mdp';

  const SELECT_FAVORIS = TeleviseurManager::SELECT_TVS . " JOIN favoris f ON f.modele_televiseur = t.modele";

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
        
        $sql = 'INSERT INTO utilisateur (pseudonyme, mdp, courriel, nom, prenom, id_langue) VALUES (:pseudonyme, :mdp, :courriel, :nom, :prenom, :id_langue)';
        $query = $this->_bdd->prepare($sql);
        $params = array(':pseudonyme'=>$user->get_pseudonyme(), 
                        ':mdp'=>$user->get_mdp(),
                        ':courriel'=>$user->get_courriel(), 
                        ':nom'=>$user->get_nom(), ':prenom'=>$user->get_prenom(), 
                        ':id_langue'=>$user->get_id_langue());
  
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

  public function getUserPhoto(int $idUser) {
    $query = $this->_bdd->prepare(self::SELECT_USER_PHOTO);

    $query->execute(array(':idUser' => $idUser));

    $bddResult = $query->fetch();

    if ($bddResult) {
      return $bddResult['photo'];
    }
    else {
      return null;
    }
  }

  public function updateProfile(User $newUser) : string {
    if (!isset($_SESSION['idUser']) || $_SESSION['idUser'] <> $_REQUEST['idUser'] || !is_numeric($newUser->get_id_langue())) {
      $messageTraitement = "Erreur parmi les données reçues! L'enregistrement n'a pas fonctionné!";
      return $messageTraitement;
    }

    $paramArray = array(
      ':courriel' => htmlspecialchars($newUser->get_courriel()),
      ':nom' => htmlspecialchars($newUser->get_nom()),
      ':prenom' => htmlspecialchars($newUser->get_prenom()),
      ':id_langue' => htmlspecialchars($newUser->get_id_langue()),
      ':photo' => htmlspecialchars($newUser->get_photo()),
      ':idUser' => $_SESSION['idUser']
    );

    $query = $this->_bdd->prepare(self::UPDATE_USER_INFOS);

    $query->execute($paramArray);
    
    if ($query->rowCount() > 0) {
      $messageTraitement = "L'enregistrement a bien fonctionné!";
    }
    else {
      $messageTraitement = "Erreur! L'enregistrement n'a pas fonctionné!";
    }

    return $messageTraitement;
  }

  public function updatePassword() : string{
    if (!isset($_SESSION['idUser']) || !isset($_POST['ancienMdp']) || !isset($_POST['nouveauMdp']) || !isset($_POST['confirmMdp']) || $_SESSION['idUser'] <> $_REQUEST['idUser']) {
      $messageTraitement = "Erreur parmi les données reçues! L'enregistrement n'a pas fonctionné!";
      return $messageTraitement;
    }

    if ($_POST['nouveauMdp'] <> $_POST['confirmMdp']) {
      $messageTraitement = "Erreur! La confirmation du nouveau mot de passe a échouée!";
      return $messageTraitement;
    }

    $paramArray = array(
      ':idUser' => $_SESSION['idUser'],
      ':ancienMdp' => $_POST['ancienMdp'],
      ':nouveauMdp' => $_POST['nouveauMdp']
    );

    $query = $this->_bdd->prepare(self::UPDATE_USER_PASSWORD);

    $query->execute($paramArray);
    
    if ($query->rowCount() > 0) {
      $messageTraitement = "Le changement de mot de passe a bien fonctionné!";
    }
    else {
      $messageTraitement = "Erreur! Le changement de mot de passe n'a pas fonctionné!";
    }

    return $messageTraitement;
  }

  public function getFavoris()
  {
    $favoris = array();
    // TODO: REMPLACER 3 PAR L'ID UTILISATEUR DE LA SESSION
    $result = $this->_bdd->query(SELF::SELECT_FAVORIS . " WHERE f.id_utilisateur = 3")->fetchAll();

    foreach($result as $tv)
    {
        // $ports = $this->getPortsByModel($tv['modele']);
        array_push($favoris, new Televiseur($tv, array()/*, $ports*/));
    }

    return $favoris;

  }
}
?>