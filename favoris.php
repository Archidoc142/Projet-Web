<?php
    include_once 'inc/header.php';
    require_once 'class/UserManager.php';

    $userMgr = new UserManager($bdd);
    $favoris = $userMgr->getFavoris();

    //print_r($favoris);
    
?>

<main>
<div class="page-title">
    <h1>Favoris</h1>
</div>
<div id="favoris">
    <?php
        foreach($favoris as $tv)
        {
            ?>
                <div class="favori">
                    <div class="favori-row">
                        <img src="img/tv/<?php echo $tv->get_modele()?>.png" alt="<?php echo $tv->get_modele()?>">
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
                    <div class="favori-buttons">
                        <a href="">Consulter</a>
                        <a href="">Supprimer</a>
                    </div>
                </div>

            <?php
        }
    ?>

</div>
</main>

<?php include_once 'inc/footer.php'; ?>