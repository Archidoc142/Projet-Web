<?php
include_once 'inc/header.php';
$modele = isset($_GET['modele']) ? $_GET['modele'] : '';
$THEmodele = htmlspecialchars($modele, ENT_QUOTES, 'UTF-8');
if (isset($THEmodele)) {
    $tv = $televiseurManager->getTeleviseurObjectByModele($THEmodele);
    $ports = $televiseurManager->getPortsByModel($THEmodele);
    $favoris = $favoriManager->getFavoriByModele($THEmodele);

    if (isset($_REQUEST['modification'])) {
        $favoriManager->modification($_SESSION['idUser'], $THEmodele);
    }
}
?>

<main>
    <h1 class="center titleArticle"><?php echo $tv->get_nom()?></h1>
    <div class="containerArticle">
        <img src='img/tv/<?php echo $tv->get_modele() ?>.png' alt='img_tv' draggable='false'>
        <div>
            <h2>Information générale :</h1>
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
        <a href="" class="button">Évaluations</a>
        <?php if (isset($_SESSION['idUser'])) { ?>
            <form id="favoriteForm" method="post" action="">
                <input type="hidden" name="modification" value="<?= ($favoriManager->verifyExist($_SESSION['idUser'], $THEmodele)) ? "Retirer" : "Ajouter"; ?>">
                <button type="submit" id="addFavorite">
                    <?php echo ($favoriManager->verifyExist($_SESSION['idUser'], $THEmodele)) ? "Retirer des" : "Ajouter aux"; ?> favoris
                </button>
            </form>
        <?php } ?>
    </div>

<?php include_once 'inc/footer.php';?>