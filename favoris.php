<?php
    include_once 'inc/header.php';
?>

<main>
<div class="page-title">
    <h1>Favoris</h1>

<?php if(!isset($_SESSION['idUser'])) {?>
    <p>Connectez-vous pour afficher vos favoris.</p>
</div>
<?php } else { 
    if(isset($_POST['delete']))
    {
        $favoriManager->modification($_SESSION['idUser'], $_POST['delete']);
    }?>
</div>
<div id="favoris">
    <?php
        $favoris = $userManager->getFavoris();
        if(empty($favoris))
            echo "<p>Aucun favori défini.</p>";
        else
        foreach($favoris as $tv)
        {
            ?>
                <div class="favori">
                    <div class="favori-row">
                        <img src="img/tv/<?php echo (file_exists("img/tv/" . $tv->get_modele() . ".png")) ? $tv->get_modele() : "generic"; ?>.png" alt="<?= $tv->get_nom();?>">
                        <div class="favori-details">
                            <div class="modele">
                                <h1><?php echo $tv->get_marque() . " " . $tv->get_nom() ?></h1>
                                <h3><?php echo $tv->get_modele()?></h3>
                            </div>
                            <div class="prix">
                                <h1><?php echo $tv->get_prix()?> $</h1>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="favoris.php">

                    <div class="favori-buttons">
                        <a href="article?modele=<?php echo $tv->get_modele()?>">Consulter</a>
                            <input type="hidden" name="delete" value="<?php echo $tv->get_modele()?>">
                            <button type="submit">
                               Supprimer
                            </button>
                    </div>
                    </form>

                </div>

            <?php
        }
    ?>

</div>
<?php } ?>

<?php include_once 'inc/footer.php'; ?>