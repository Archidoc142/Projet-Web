<?php
require_once 'class/PDOFactory.php';
$bdd = PDOFactory::getMySQLConnection();
$bddResults = $bdd->query("SELECT t.*, m.nom AS marque, r.nom AS resolution, e.nom AS type_ecran FROM televiseur t
                           JOIN marque m ON m.id = t.id_marque
                           JOIN resolution r ON r.id = t.id_resolution
                           JOIN type_ecran e ON e.id = t.id_type_ecran
                           ORDER BY prix DESC
                           LIMIT 2;");
$fetched = $bddResults->fetchAll(PDO::FETCH_ASSOC); 
include_once 'inc/header.php';
?>

<main>
    <h1 class="center titleIndex">Bienvenue sur Bureau en maigre</h1>
    <p class="ssIndex center">Nous vous aiderons à trouver la télévision la plus adaptée à vos besoins et votre budget<br>Nous avons une gamme de produits venant de plusieurs marques différentes</p>

    <div class="part2-Index center">
        <h2>Téléviseur du moment</h2>
        <?php foreach ($fetched as $row) { 
            echo "<div>";
            echo "<a href='article?modele=" . rawurlencode($row['modele']) . "' draggable='false'><img src='img/tv/" . $row['modele'] . ".png' alt='img_tv' draggable='false'></a>";
            echo "<div><h3>" . $row['nom'] . "</h3>";
            echo "<article class='mob-hidden'>
                    <p><span class='bold'>Modèle</span> : " . $row['modele'] . "</p>
                    <p><span class='bold'>Marque</span> : " . $row['marque'] . "</p>
                    <p><span class='bold'>Type écran</span> : " . $row['type_ecran'] . "</p>
                    <p><span class='bold'>Résolution</span> : " . $row['resolution'] . "</p>
                    <p><span class='bold'>Taille</span> : " . $row['taille'] . "\"</p>
                  </article>";
            echo "<p>Prix : " . $row['prix'] . "$</p></div>";
            echo "</div>"; } ?>
    </div>
<?php include_once 'inc/footer.php';?>