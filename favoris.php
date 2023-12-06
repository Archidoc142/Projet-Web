<?php
    require_once 'class/PDOFactory.php';
    require_once 'class/TeleviseurManager.php';
    include_once 'inc/header.php';

    $bdd = PDOFactory::getMySQLConnection();

    //$bddResults = $bdd->query("SELECT marque.nom, televiseur.nom, modele, prix FROM televiseur JOIN marque ON marque.id = televiseur.id_marque;");
    //$data = $bddResults->fetchAll();

    $tvMgr = new TeleviseurManager($bdd);
    $tvs = $tvMgr->getTeleviseurs();
    
?>

<main>
<div id="favoris">
    <?php
        
    ?>
    <!--div class="favori">
        <div class="favori-row">
            <img src="https://i5.walmartimages.ca/images/Enlarge/439/687/6000206439687.jpg" alt="">
            <div class="favori-details">
                <div class="modele">
                    <h1>Marque nom</h1>
                    <h2>modèle</h2>
                </div>
                <div class="prix">
                    <p>prix$</p>
                </div>
            </div>
        </div>
        <div class="favori-buttons">
            <a href="">Consulter</a>
            <a href="">Supprimer</a>
        </div>
    </div>
    <div class="favori">
        <div class="favori-row">
            <img src="https://i5.walmartimages.ca/images/Enlarge/439/687/6000206439687.jpg" alt="">
            <div class="favori-details">
                <div class="modele">
                    <h1>Marque nom</h1>
                    <h2>modèle</h2>
                </div>
                <div class="prix">
                    <p>prix$</p>
                </div>
            </div>
        </div>
        <div class="favori-buttons">
            <a href="">Consulter</a>
            <a href="">Supprimer</a>
        </div>
    </div>

    <div class="favori">
        <div class="favori-row">
            <img src="https://i5.walmartimages.ca/images/Enlarge/439/687/6000206439687.jpg" alt="">
            <div class="favori-details">
                <div class="modele">
                    <h1>Marque nom</h1>
                    <h2>modèle</h2>
                </div>
                <div class="prix">
                    <p>prix$</p>
                </div>
            </div>
        </div>
        <div class="favori-buttons">
            <a href="">Consulter</a>
            <a href="">Supprimer</a>
        </div>
    </div>

    <div class="favori">
        <div class="favori-row">
            <img src="https://i5.walmartimages.ca/images/Enlarge/439/687/6000206439687.jpg" alt="">
            <div class="favori-details">
                <div class="modele">
                    <h1>Marque nom</h1>
                    <h2>modèle</h2>
                </div>
                <div class="prix">
                    <p>prix$</p>
                </div>
            </div>
        </div>
        <div class="favori-buttons">
            <a href="">Consulter</a>
            <a href="">Supprimer</a>
        </div>
    </div>

    <div class="favori">
        <div class="favori-row">
            <img src="https://i5.walmartimages.ca/images/Enlarge/439/687/6000206439687.jpg" alt="">
            <div class="favori-details">
                <div class="modele">
                    <h1>Marque nom</h1>
                    <h2>modèle</h2>
                </div>
                <div class="prix">
                    <p>prix$</p>
                </div>
            </div>
        </div>
        <div class="favori-buttons">
            <a href="">Consulter</a>
            <a href="">Supprimer</a>
        </div>
    </div-->

</div>
</main>

<?php include_once 'inc/footer.php'; ?>