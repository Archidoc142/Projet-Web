<?php
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    
    include_once('autoloader.php');

    $bdd = PDOFactory::getMySQLConnection();
    $userManager = new UserManager($bdd);
    $langueManager = new LangueManager($bdd);
    $evaluationManager = new EvaluationManager($bdd);
    $televiseurManager = new TeleviseurManager($bdd);
    $portManager = new PortManager($bdd);

    if (isset($_POST['modificationProfil'])){
      $userModification = new User($_POST);
      $messageTraitement = $userManager->updateProfile($userModification);
    }
    else if (isset($_POST['nouveauMdp'])) {
      $messageTraitement = $userManager->updatePassword();
    }

    if (isset($_REQUEST['action'])) {
      if ($_POST['action'] == "connexion") {
        $courriel = $_POST['courriel'];
        $mdp = $_POST['mdp'];
        $user = $userManager->userExists($courriel, $mdp);
    
        if ($user) {
            $_SESSION['error'] = "Succes";
            $_SESSION['idUser'] = $user['id'];
            $_SESSION['pseudo'] = $user['pseudonyme'];
        } else {
            $_SESSION['error'] = "Les informations d'authentification sont incorrectes.";
            header("Location: login.php");
            exit();
        }
    
      }
      else if ($_REQUEST['action'] == 'deconnexion') {
        session_unset();
        session_destroy();
      }
    }
?>