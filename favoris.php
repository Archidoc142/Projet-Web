<?php
require_once 'class/PDOFactory.php';
$bdd = PDOFactory::getMySQLConnection();
$bddResults = $bdd->query("SELECT * FROM televiseur;");
include_once 'inc/header.php';
?>

<div id="favoris">
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
</div>

<?php include_once 'inc/footer.php'; ?>