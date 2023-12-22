<?php
  include_once("inc/header.php");
?>

<main id="port">
  <h1>Les ports</h1>
  <h3>Voici les ports disponibles sur nos téléviseurs :</h3>

  <div class="grid">
    <?php
      $ports = $portManager->getPorts();

      foreach ($ports as $portObj) {
        ?>
        <div class="portDiv">
          <input type="hidden" value="<?= $portObj->get_id(); ?>">
          <p><?= $portObj->get_nom(); ?></p>
        </div>
        
        <?php
      }
    ?>
  </div>

  <div id="portModelesPopup" class="hidden">
    <div id="listeModeleDiv">
      <h3></h3>
      <ul></ul>
      <p class="button">Fermer</p>
    </div>
  </div>
<?php
  include_once("inc/footer.php");
?>