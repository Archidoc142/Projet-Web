<?php
  include_once("inc/header.php");
?>

<main id="evaluations">
  <div class="grid">
    <?php
      if (isset($_REQUEST['idUser'])) {
        $userObj = $userManager->getUserById($_REQUEST['idUser']);

        if (isset($userObj)) {
          if (isset($_SESSION['idUser']) && $_SESSION['idUser'] == $userObj->get_id()) {
            ?>
            <h1>Vos évaluations</h1>
            <?php
          }
          else {
            ?>
            <h1>Évaluations par <?= $userObj->get_pseudonyme(); ?></h1>
            <?php
          }

          $evaluationArray = $evaluationManager->getUserEvaluations($userObj->get_id());

          if (count($evaluationArray) > 0) {
            foreach ($evaluationArray as $evaluationObj) {
            ?>
            
            <div class="evaluation">
              <h2><?= $evaluationObj->get_titre(); ?> - <a href="article?modele=<?= $evaluationObj->get_modele_televiseur(); ?>"><?= $evaluationObj->get_modele_televiseur(); ?></a></h2>
              <h3>Note : <?= $evaluationObj->get_note(); ?> / 5</h3>
              <p><?= $evaluationObj->get_commentaire(); ?></p>
            </div>
      
            <?php
            }
          }
          else {
          ?>
      
          <p>Aucune évaluation associée à cet utilisateur...</p>
              
          <?php
          }
        }
        else {
        ?>

        <p>Erreur! Utilisateur introuvable...</p>
            
        <?php         
        }
      }
      else if (isset($_REQUEST['modele'])) {
        $televiseurObj = $televiseurManager->getTeleviseurByModele($_REQUEST['modele']);
      
        if (isset($televiseurObj)) {
          ?>
          <h1>Évaluations de <?= $televiseurObj->get_nom(); ?></h1>
          <?php

          $evaluationArray = $evaluationManager->getModeleEvaluations($televiseurObj->get_modele());

          if (count($evaluationArray) > 0) {
            foreach ($evaluationArray as $evaluationObj) {
              $userObj = $userManager->getUserById($evaluationObj->get_id_utilisateur());
            ?>
            
            <div class="evaluation">
              <h2><?= $evaluationObj->get_titre(); ?></h2>
              <p>Évalué par : <a href="profile?idUser=<?= $evaluationObj->get_id_utilisateur(); ?>"><?= $userObj->get_pseudonyme(); ?></a></p>
              <h3>Note : <?= $evaluationObj->get_note(); ?> / 5</h3>
              <p><?= $evaluationObj->get_commentaire(); ?></p>
            </div>
      
            <?php
            }
          }
          else {
          ?>
      
          <p>Aucune évaluation associée à ce téléviseur...</p>
              
          <?php
          }
        }
        else {
        ?>

        <p>Erreur! Téléviseur introuvable...</p>
            
        <?php         
        }
      }
      else {
      ?>

      <p>Erreur! Aucun utilisateur sélectionné...</p>
          
      <?php    
      }
    ?>
  </div>


</main>

<?php
  include_once("inc/footer.php");
?>