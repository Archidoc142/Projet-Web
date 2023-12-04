<?php
  include_once("inc/header.php");
  $bdd = PDOFactory::getMySQLConnection();
  $userManager = new UserManager($bdd);
?>

<main id="profile">

<?php
  if (isset($_REQUEST['idUser'])) {
    $userObj = $userManager->getUserById($_REQUEST['idUser']);

    if (isset($userObj)) {
    ?>

    <form action="profile.php" method="POST">
      <h2><?= $userObj->get_pseudonyme(); ?></h2>

      <div class="grid">
        <img src="<?= $userObj->get_photo(); ?>" alt="Photo de profil" />
  
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= $userObj->get_prenom(); ?>" readonly />
        
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= $userObj->get_nom(); ?>" readonly />
        
        <label for="courriel">Courriel :</label>
        <input type="text" id="courriel" name="courriel" value="<?= $userObj->get_courriel(); ?>" readonly />
        
        <label for="langue">Langue :</label>
        <input type="text" id="langue" name="langue" value="<?= $userObj->get_langue(); ?>" readonly />

        <a>Modifier le profil</a>
    
        <a>Changer le mot de passe</a>
      </div>
    </form>


    <a href="favoris?idUser=<?= $userObj->get_id(); ?>" class="button">
      <?php 
      if (isset($_SESSION['idUser']) && $_SESSION['idUser'] == $userObj->get_id()) {
      ?>
        Mes favoris
      <?php 
      }
      else {
      ?>
        Favoris
      <?php 
      }
      ?>
    </a>

    <a href="evaluations?idUser=<?= $userObj->get_id(); ?>" class="button">
      <?php 
      if (isset($_SESSION['idUser']) && $_SESSION['idUser'] == $userObj->get_id()) {
      ?>
        Mes évaluations
      <?php 
      }
      else {
      ?>
        Évaluations
      <?php 
      }
      ?>
    </a>

    <?php  
    }
    else {
    ?>

    <p>Erreur! Utilisateur introuvable...</p>
        
    <?php         
    }
  }
  else {
  ?>

  <p>Erreur! Aucun utilisateur sélectionné...</p>
      
  <?php    
  }
?>

</main>

<?php
  include_once("inc/footer.php");
?>