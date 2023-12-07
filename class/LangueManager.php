<?php
class LangueManager {
  const SELECT_LANGUES = "SELECT * FROM langue";
  const SELECT_LANGUE_BY_ID = "SELECT * FROM langue WHERE id = :idLangue";

  private $_bdd;

  public function __construct(PDO $bdd) { $this->_bdd = $bdd; }

  public function getLangues() : array {
    $langueArray = array();

    $query = $this->_bdd->prepare(self::SELECT_LANGUES);

    $query->execute();

    $bddResult = $query->fetchAll();

    foreach ($bddResult as $row) {
      array_push($langueArray, new Langue($row));
    }

    return $langueArray;
  }

  public function getLangueById(int $idLangue) {
    $query = $this->_bdd->prepare(self::SELECT_LANGUE_BY_ID);

    $query->execute(array(':idLangue' => $idLangue));

    $bddResult = $query->fetch();

    if ($bddResult) {
      return new Langue($bddResult);
    }
    else {
      return null;
    }
  }
}
?>