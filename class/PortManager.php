<?php
class PortManager {
  const SELECT_PORTS = "SELECT * FROM port";

  private $_bdd;

  public function __construct(PDO $bdd) { $this->_bdd = $bdd; }

  public function getPorts() {
    $portArray = array();

    $query = $this->_bdd->prepare(self::SELECT_PORTS);

    $query->execute();

    $bddResult = $query->fetchAll();

    foreach ($bddResult as $row) {
      array_push($portArray, new Port($row));
    }

    return $portArray;
  }
}
?>