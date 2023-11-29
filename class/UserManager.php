<?php
class UserManager {
  const SELECT_USER_BY_ID = "SELECT *, langue.nom_complet AS langue FROM utilisateur INNER JOIN langue ON utilisateur.id_langue = langue.id WHERE utilisateur.id = :idUser";

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
}
?>