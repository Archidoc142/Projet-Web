<?php 
    require_once("pretraitement.php"); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">   <link rel="stylesheet" href="css/style.css">
   <script defer src="js/script.js"></script>
   <title>Bureau en maigre</title>
</head>
<body>
    <nav>
        <div class="nav-header">
            <div class="nav-header-left">
                <button id="nav-menu-btn">
                    <svg id="nav-menu-img" viewBox="0 0 100 80" width="32" height="32">
                        <rect width="100" height="20"></rect>
                        <rect y="30" width="100" height="20"></rect>
                        <rect y="60" width="100" height="20"></rect>
                      </svg>
                </button>
            </div>
            <div class="nav-header-right">
                <?php 
                  if (isset($_SESSION['idUser'])) {
                    $photoUser = $userManager->getUserPhoto($_SESSION['idUser']);
                    $photoValide = (isset($photoUser) && !empty($photoUser));
                ?>
                    <a href="favoris" id="nav-fav-btn">
                        <svg id="nav-fav-img" viewBox='0 0 576 512' width="32" height="32"><path d='M381.2 150.3l143.7 21.2c11.9 1.7 21.9 10.1 25.7 21.6 3.8 11.6.7 24.2-7.9 32.8L438.5 328.1l24.6 146.6c2 12-2.9 24.2-12.9 31.3-9.9 7.1-23 8-33.7 2.3l-128.4-68.5-128.3 68.5c-10.8 5.7-23.9 4.8-33.8-2.3-9.9-7.1-14.9-19.3-12.8-31.3l24.6-146.6L33.58 225.9c-8.61-8.6-11.67-21.2-7.89-32.8 3.77-11.5 13.74-19.9 25.73-21.6L195 150.3l64.4-132.33C264.7 6.954 275.9-.04 288.1-.04c12.3 0 23.5 6.994 28.8 18.01l64.3 132.33z'/></svg>                    
                    </a>
                    <a href="profile?idUser=<?= $_SESSION['idUser']; ?>" id="nav-profile-btn">
                        <img class="nav-user-img <?= !$photoValide ? 'noirBlanc' : '' ; ?>" src="<?= $photoValide ? $photoUser : 'img/icon/user-170.svg' ;?>" alt="User" width="32" height="32">
                    </a>
                        <a href="login?action=deconnexion">Se déconnecter</a>
                    <?php 
                  }
                  else {
                    ?>
                    <a href="register">S'inscrire</a>
                    <a href="login">Se connecter</a>
                    <?php
                  }
                  ?>
            </div>
        </div>
        <div class="nav-buttons none">
            <ul>
                <li><a href="index">Accueil</a></li>
                <li><a href="marque">Marques</a></li>
                <li><a href="television">Téléviseurs</a></li>
                <?php if (isset($_SESSION['idUser'])) {?>
                    <li><a href="ajout-televiseur">Ajouter un téléviseur</a></li>
                <?php } ?>
                <li><a href="port">Ports</a></li>
            </ul>
        </div>
    </nav>