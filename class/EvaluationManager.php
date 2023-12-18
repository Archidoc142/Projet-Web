<?php
class EvaluationManager {
  const SELECT_USER_EVALUATIONS = "SELECT * FROM evaluation WHERE id_utilisateur = :idUser";
  const SELECT_MODELE_EVALUATIONS = "SELECT * FROM evaluation WHERE modele_televiseur = :modele";
  const INSERT_EVALUATION = "INSERT INTO evaluation (id_utilisateur, modele_televiseur, titre, commentaire, note) VALUES (:id_utilisateur, :modele_televiseur, :titre, :commentaire, :note)";
  const SELECT_USER_MODEL_EVAL = "SELECT id_utilisateur FROM evaluation WHERE id_utilisateur = :idUser AND modele_televiseur = :modele";

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

  public function insertEvaluation(Evaluation $eval) {
    if (!isset($_SESSION['idUser']) || !isset($_REQUEST['modele'])) {
      return;
    }

    $paramArray = array(
      ":id_utilisateur" => $_SESSION['idUser'], 
      ":modele_televiseur" => $_REQUEST['modele'], 
      ":titre" => $_REQUEST['titre'],
      ":commentaire" => $_REQUEST['commentaire'], 
      ":note" => $_REQUEST['note']
    );

    $query = $this->_bdd->prepare(self::INSERT_EVALUATION);

    $query->execute($paramArray);
  }

  public function aDejaEvalueCeModele() : bool {
    if (!isset($_SESSION['idUser'])) {
      return true;
    }

    $paramArray = array(
      ":idUser" => $_SESSION['idUser'], 
      ":modele" => $_REQUEST['modele']
    );

    $query = $this->_bdd->prepare(self::SELECT_USER_MODEL_EVAL);

    $query->execute($paramArray);

    return $query->rowCount() > 0;
  }
}
?>