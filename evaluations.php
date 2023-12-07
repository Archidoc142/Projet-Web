<?php
  include_once("inc/header.php");
  $bdd = PDOFactory::getMySQLConnection();
  $evaluationManager = new EvaluationManager($bdd);
  $userManager = new UserManager($bdd);
?>

<main id="evaluations">
  <div class="grid">
    <?php
      if (isset($_REQUEST['idUser'])) {
        $userObj = $userManager->getUserById($_REQUEST['idUser']);

        if (isset($userObj)) {
          ?>
          <h1>Évaluations de <?= $userObj->get_pseudonyme(); ?></h1>
          <?php

          $evaluationArray = $evaluationManager->getUserEvaluations($_REQUEST['idUser']);

          if (count($evaluationArray) > 0) {
            foreach ($evaluationArray as $evaluationObj) {
            ?>
            
            <div class="evaluation">
              <h2><?= $evaluationObj->get_titre(); ?> - <a href="television?modele=<?= $evaluationObj->get_modele_televiseur(); ?>"><?= $evaluationObj->get_modele_televiseur(); ?></a></h2>
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