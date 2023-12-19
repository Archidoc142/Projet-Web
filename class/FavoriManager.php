<?php
class FavoriManager {
  const SELECT_FAVORI_BY_MODELE = "SELECT * FROM favoris WHERE modele_televiseur = :modele_televiseur";
  const SELECT_FAVORI_BY_USER_AND_MODELE = "SELECT * FROM favoris WHERE id_utilisateur = :idUser AND modele_televiseur = :modele_televiseur";

  private $_bdd;

  public function __construct(PDO $bdd) { $this->_bdd = $bdd; }

  public function getFavoriByModele(string $modele_televiseur) : array {
    $favoriArray = array();

    $query = $this->_bdd->prepare(self::SELECT_FAVORI_BY_MODELE);

    $query->execute(array(':modele_televiseur' => $modele_televiseur));

    $bddResult = $query->fetchAll();

    foreach ($bddResult as $row) {
      array_push($favoriArray, new Favori($row));
    }

    return $favoriArray;
  }

  public function modification(int $idUser, string $modele_televiseur) {
    if (!$this->verifyExist($idUser, $modele_televiseur)) {
        $this->addFavori($idUser, $modele_televiseur);
    } else {
        $this->deleteFavori($idUser, $modele_televiseur);
    }
  }

  public function deleteFavori(int $idUser, string $modele_televiseur) {
    $sql = 'DELETE FROM favoris WHERE id_utilisateur = :idUser AND modele_televiseur = :modele_televiseur';
    $query = $this->_bdd->prepare($sql);
    $params = array(':idUser'=> $idUser, ':modele_televiseur'=> $modele_televiseur);
    $query->execute($params);
  }

  public function addFavori(int $idUser, string $modele_televiseur) {
    $sql = 'INSERT INTO favoris (modele_televiseur, id_utilisateur) VALUES (:modele_televiseur, :idUser)';
    $query = $this->_bdd->prepare($sql);
    $params = array(':modele_televiseur'=> $modele_televiseur, ':idUser'=> $idUser);
    $query->execute($params);
  }

  public function verifyExist(int $idUser, string $modele_televiseur) {
    $query = $this->_bdd->prepare(self::SELECT_FAVORI_BY_USER_AND_MODELE);
    $query->execute([':idUser' => $idUser, ':modele_televiseur' => $modele_televiseur]);
    $result = $query->fetch();
    return $result;
  }
}
?>