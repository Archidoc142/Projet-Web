<?php
class UserManager {
  const SELECT_USER_BY_ID = "SELECT utilisateur.* FROM utilisateur WHERE utilisateur.id = :idUser";
  const UPDATE_USER_INFOS = "UPDATE utilisateur SET pseudonyme = :pseudonyme, courriel = :courriel, nom = :nom, prenom = :prenom, id_langue = :id_langue, photo = :photo";

  private $_bdd;

  public function __construct(PDO $bdd) { $this->_bdd = $bdd; }

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