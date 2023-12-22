<?php
  include_once("inc/header.php");
?>

<main id="profile">

<?php
  if (isset($messageTraitement) && !empty($messageTraitement)) {
    ?>
    
    <p class="message"><?= $messageTraitement;?></p>
    
    <?php
  }

  if (isset($_REQUEST['idUser'])) {
    $userObj = $userManager->getUserById($_REQUEST['idUser']);

    $isConnectedUser = (isset($_SESSION['idUser']) && $_SESSION['idUser'] == $userObj->get_id());

    if (isset($userObj)) {
    ?>

    <form action="profile?idUser=<?= $userObj->get_id(); ?>" method="POST" class="<?= (isset($_SESSION['idUser']) && $_SESSION['idUser'] == $userObj->get_id()) ? 'myProfile' : '' ;?>">
      <h2><?= $userObj->get_pseudonyme(); ?></h2>

      <div class="grid">
        <img src="<?= (!empty($userObj->get_photo())) ? $userObj->get_photo() : 'img/icon/user-170.svg'; ?>" alt="Photo de profil" />

        <?php 
          if ($isConnectedUser) {
        ?>
        <input type="hidden" name="modificationProfil" id="modificationProfil">
        <label class="hidden" for="photo" id="labelPhoto">URL de la photo de profil : </label>
        <input type="text" class="hidden" id="photo" name="photo" value="<?= $userObj->get_photo(); ?>">
        <?php 
          }
        ?>

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
          
          <a class="hidden" id="btnChangeMdp">Changer le mot de passe</a>
        </div>

        <?php  
        }
        else {
          $langue = $langueManager->getLangueById($userObj->get_id_langue());
        ?>
          <label for="id_langue">Langue :</label>
          <input type="text" name="id_langue" id="id_langue" value="<?= $langue->get_nom_complet(); ?>" readonly>
          


      </div>
          <?php 
        }
        ?>

      <button type="submit" class="button hidden" id="boutonEnregistrer">Enregistrer les modifications</button>
      
      <?php 
        if ($isConnectedUser) {
        ?>
        <a href="favoris" class="button">
          Mes favoris
        </a>
        <?php 
        }
      ?> 

 <!--     <a href="favoris?idUser=<?= $userObj->get_id(); ?>" class="button">
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
  -->
  
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
    if ($isConnectedUser) {
    ?>
        <form id="changeMdpBox" class="hidden" method="post" action="profile?idUser=<?= $userObj->get_id(); ?>">
          <div>
            <h3>Changement de mot de passe</h3>
            <div class="grid">
              <label for="ancienMdp">Ancien mot de passe :</label>
              <input id="ancienMdp" name="ancienMdp" type="password">
  
              <label for="nouveauMdp">Nouveau mot de passe :</label>
              <input id="nouveauMdp" name="nouveauMdp" type="password">
  
              <label for="confirmMdp">Confirmer le nouveau mot de passe :</label>
              <input id="confirmMdp" name="confirmMdp" type="password">
  
              <button class="button" id="changeMdpConfirm" type="submit">Confirmer</button>
              <button class="button" id="changeMdpAnnuler" type="reset">Annuler</button>
          </div>
          </div>
        </form>
      <?php
    }
    ?>

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

<?php
  include_once("inc/footer.php");
?>