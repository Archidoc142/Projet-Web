<?php include_once('inc/pretraitement.php');

$json_obj = json_decode(file_get_contents('php://input'));

if (isset($json_obj->{'idPort'})) {

  $televiseurs = $televiseurManager->getTeleviseursByPort($json_obj->{'idPort'});

  $modeleArray = array();

  foreach ($televiseurs as $televiseurObj) {
    array_push($modeleArray, $televiseurObj->get_modele() . ";" . $televiseurObj->get_nom());
  }

  echo json_encode($modeleArray);
}

?>