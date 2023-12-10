<?php
class EvaluationManager {
  const SELECT_USER_EVALUATIONS = "SELECT * FROM evaluation WHERE id_utilisateur = :idUser";
  const SELECT_MODELE_EVALUATIONS = "SELECT * FROM evaluation WHERE modele_televiseur = :modele";

  private $_bdd;

  public function __construct(PDO $bdd) { $this->_bdd = $bdd; }

  public function getUserEvaluations(int $idUser) : array {
    $evaluationsArray = array();

    $query = $this->_bdd->prepare(self::SELECT_USER_EVALUATIONS);

    $query->execute(array(':idUser' => $idUser));

    $bddResult = $query->fetchAll();

    foreach ($bddResult as $row) {
      array_push($evaluationsArray, new Evaluation($row));
    }

    return $evaluationsArray;
  }

  public function getModeleEvaluations(string $modele) : array {
    $evaluationsArray = array();

    $query = $this->_bdd->prepare(self::SELECT_MODELE_EVALUATIONS);

    $query->execute(array(':modele' => $modele));

    $bddResult = $query->fetchAll();

    foreach ($bddResult as $row) {
      array_push($evaluationsArray, new Evaluation($row));
    }

    return $evaluationsArray;
  }
}
?>