<?php
class UserManager {
  const SELECT_USER_BY_ID = "SELECT utilisateur.* FROM utilisateur WHERE utilisateur.id = :idUser";
  const UPDATE_USER_INFOS = "UPDATE utilisateur SET pseudonyme = :pseudonyme, courriel = :courriel, nom = :nom, prenom = :prenom, id_langue = :id_langue, photo = :photo WHERE id = :idUser";

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
    if (!isset($_SESSION['idUser']) || $_SESSION['idUser'] <> $_REQUEST['idUser']) {
      return;
    }

    $paramArray = array(
      ':pseudonyme' => htmlspecialchars($newUser->get_pseudonyme()),
      ':courriel' => htmlspecialchars($newUser->get_courriel()),
      ':nom' => htmlspecialchars($newUser->get_nom()),
      ':prenom' => htmlspecialchars($newUser->get_prenom()),
      ':id_langue' => htmlspecialchars($newUser->get_id_langue()),
      ':photo' => htmlspecialchars($newUser->get_photo()),
      ':idUser' => $_SESSION['idUser']
    );

    $query = $this->_bdd->prepare(self::UPDATE_USER_INFOS);

    $result = $query->execute($paramArray);

  ?>
  <p class="message">
  <?php
    if ($result > 0) {
      ?>
      L'enregistrement a bien fonctionné!
      <?php
    }
    else {
      ?>
      Erreur! L'enregistrement n'a pas fonctionné!
      <?php
    }
  ?>
  </p>
  <?php
  }
}
?>