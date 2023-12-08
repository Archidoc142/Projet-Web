<?php
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    
    include_once('autoloader.php');

    $bdd = PDOFactory::getMySQLConnection();
    $userManager = new UserManager($bdd);
    $langueManager = new LangueManager($bdd);

    if (isset($_POST['modificationProfil'])){
      $userModification = new User($_POST);
      $messageTraitement = $userManager->updateProfile($userModification);
    }
    else if (isset($_POST['nouveauMdp'])) {
      $messageTraitement = $userManager->updatePassword();
    }
?>