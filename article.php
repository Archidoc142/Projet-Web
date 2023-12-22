<?php
include_once 'inc/header.php';
$modele = isset($_GET['modele']) ? $_GET['modele'] : '';
$modele = htmlspecialchars($modele, ENT_QUOTES, 'UTF-8');
if (isset($modele)) {
    $tv = $televiseurManager->getTeleviseurObjectByModele($modele);
    $ports = $televiseurManager->getPortsByModel($modele);
    $favoris = $favoriManager->getFavoriByModele($modele);

    if (isset($_REQUEST['modification'])) {
        $favoriManager->modification($_SESSION['idUser'], $modele);
    }
}

if (isset($_REQUEST['commentaire'])) {
  $evaluationManager->insertEvaluation(new Evaluation($_REQUEST));
}
?>

<main id="article">
    <h1 class="center titleArticle"><?php echo $tv->get_nom()?></h1>
    <div class="containerArticle">
    <img src="img/tv/<?php echo (file_exists("img/tv/" . $tv->get_modele() . ".png")) ? $tv->get_modele() : "generic"; ?>.png" alt="<?= $tv->get_nom();?>">
        <div>
            <h2>Informations générales :</h1>
            <div class="grid3C">
                <div><p><span class='bold'>Modèle</span> : <?php echo $tv->get_modele() ?></p><p><span class='bold'>Marque</span> : <?php echo $tv->get_marque() ?></p><p><span class='bold'>OS</span> : <?php echo $tv->get_os() ?></p></div>
                <div><p><span class='bold'>Type écran</span> : <?php echo $tv->get_type_ecran() ?></p><p><span class='bold'>Résolution</span> : <?php echo $tv->get_resolution() ?></p><p><span class='bold'>Fréquence</span> : <?php echo $tv->get_frequence()?> Hz</p></div>
                <div><p><span class='bold'>HDR</span> :<?php echo ($tv->get_hdr() == 1) ? "Oui" : "Non"; ?></p><span class='bold'><p><span class='bold'>Taille</span> : <?php echo $tv->get_taille() ?>"</p><p><span class='bold'>Prix</span> : <?php echo $tv->get_prix() ?> $</p></div>
            </div>
            <h2 class="ArticlePort">Ports : </h2>
            <div class="flex artPortDiv">
                <?php foreach ($ports as $row) { 
                       echo "<p>" . $row . "</p>";
                } ?>
            </div>
        </div>
    </div>
    <div class="flex artBtn">
        <?php if (isset($_SESSION['idUser'])) { ?>
            <form id="favoriteForm" method="post" action="">
                <input type="hidden" name="modification" value="<?= ($favoriManager->verifyExist($_SESSION['idUser'], $modele)) ? "Retirer" : "Ajouter"; ?>">
                <button type="submit" id="addFavorite" class="button">
                    <?php echo ($favoriManager->verifyExist($_SESSION['idUser'], $modele)) ? "Retirer des" : "Ajouter aux"; ?> favoris
                </button>
            </form>
        <?php } ?>
    </div>

    <div class="flex evalBtns">
      <a href="evaluations?modele=<?= $tv->get_modele();?>" class="button">Voir les évaluations</a>
      
      <?php
      if (isset($_SESSION['idUser']) && !$evaluationManager->aDejaEvalueCeModele()) {
        ?>
        <p class="button" id="boutonAjoutEval">Ajouter une évaluation</p>
        <?php
      }
      ?>
    </div>

    <div id="faireEvaluationPopup" class="hidden">
      <form action="article?modele=<?= $tv->get_modele(); ?>" method="POST">
        <h3>Évaluer <?= $tv->get_nom(); ?></h3>
        <label for="titre">Titre</label>
        <br>
        <input type="text" id="titre" name="titre" required>

        <br>

        <label for="note">Note</label>
        <br>
        <input type="number" id="note" name="note" min="0" max="5" step="0.5" required>
        <br>

        <label for="commentaire">Commentaire</label>
        <br>
        <textarea name="commentaire" id="commentaire" cols="30" rows="10" required></textarea>

        <button type="submit" class="button">Soumettre</button>

        <button type="reset" id="boutonAnnulerEval" class="button">Annuler</button>
      </form>
    </div>
<?php include_once 'inc/footer.php';?>