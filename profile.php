<?php
  include_once("inc/header.php");
  $userManager = new UserManager($bdd);
  $langueManager = new LangueManager($bdd);
?>

<main id="profile">

<?php
  if (isset($_POST['modification'])){
    $userModification = new User($_POST);
    $userManager->updateProfile($userModification);
  }
  
  if (isset($_REQUEST['idUser'])) {
    $userObj = $userManager->getUserById($_REQUEST['idUser']);

    $isConnectedUser = (isset($_SESSION['idUser']) && $_SESSION['idUser'] == $userObj->get_id());

    if (isset($userObj)) {
    ?>

    <form action="profile?idUser=<?= $userObj->get_id(); ?>" method="POST" class="<?= (isset($_SESSION['idUser']) && $_SESSION['idUser'] == $userObj->get_id()) ? 'myProfile' : '' ;?>">
      <?php 
        if ($isConnectedUser) {
      ?>
      <input type="hidden" name="modification" id="modification">
      <input type="hidden" name="photo" value="<?= $userObj->get_photo(); ?>">
      <?php 
        }
      ?>

      <h2><?= $userObj->get_pseudonyme(); ?></h2>

      <div class="grid">
        <img src="<?= (!empty($userObj->get_photo())) ? $userObj->get_photo() : 'img/icon/user-170.svg'; ?>" alt="Photo de profil" />
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= $userObj->get_prenom(); ?>" readonly />
        
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= $userObj->get_nom(); ?>" readonly />
        
        <label for="courriel">Courriel :</label>
        <input type="text" id="courriel" name="courriel" value="<?= $userObj->get_courriel(); ?>" readonly />

        <?php
        if ($isConnectedUser) {
          ?>
          <label for="selectLangue">Langue :</label>

          <select id="selectLangue" disabled>
            <?php
            $langues = $langueManager->getLangues();
            foreach ($langues as $langueObj) {
              ?>
              <option value="<?= $langueObj->get_id();?>" <?= ($langueObj->get_id() == $userObj->get_id_langue()) ? 'selected' : ''; ?>><?= $langueObj->get_nom_complet();?></option>
              <?php
            }
            ?>
          </select>

          <input type="hidden" id="id_langue" name="id_langue" value="<?= $userObj->get_id_langue();?>">
          
          <a id="modifierProfil">Modifier le profil</a>
    
          <a>Changer le mot de passe</a>
          <?php  
        }
        else {
          $langue = $langueManager->getLangueById($userObj->get_id_langue());
          ?>
          <label for="id_langue">Langue :</label>
          <input type="text" name="id_langue" value="<?= $langue->get_nom_complet(); ?>" readonly>
          
          <?php 
        }
        ?>
      </div>

      <button type="submit" class="button hidden" id="boutonEnregistrer">Enregistrer les modifications</button>
      
      <a href="favoris?idUser=<?= $userObj->get_id(); ?>" class="button">
        <?php 
        if ($isConnectedUser) {
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
        if ($isConnectedUser) {
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
    </form>

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