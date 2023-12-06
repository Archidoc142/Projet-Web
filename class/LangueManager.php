<?php
class LangueManager {
  const SELECT_LANGUES = "SELECT * FROM langue";

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
}
?>