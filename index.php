<?php
include_once 'inc/header.php';
$tvs = $televiseurManager->getTopTwoTeleviseurs();
?>

<main>
    <h1 class="center titleIndex">Bienvenue sur Bureau en maigre</h1>
    <p class="ssIndex center">Nous vous aiderons à trouver la télévision la plus adaptée à vos besoins et votre budget<br>Nous avons une gamme de produits venant de plusieurs marques différentes</p>

    <div class="part2-Index center">
        <h2>Téléviseur du moment</h2>
        <?php foreach ($tvs as $row) { 
            echo "<div>";
            echo "<a href='article?modele=" . rawurlencode($row->get_modele()) . "' draggable='false'><img src='img/tv/" . $row->get_modele() . ".png' alt='img_tv' draggable='false'></a>";
            echo "<div><h3>" . $row->get_nom() . "</h3>";
            echo "<article class='mob-hidden'>
                    <p><span class='bold'>Modèle</span> : " . $row->get_modele() . "</p>
                    <p><span class='bold'>Marque</span> : " . $row->get_marque() . "</p>
                    <p><span class='bold'>Type écran</span> : " . $row->get_type_ecran() . "</p>
                    <p><span class='bold'>Résolution</span> : " . $row->get_resolution() . "</p>
                    <p><span class='bold'>Taille</span> : " . $row->get_taille() . "\"</p>
                  </article>";
            echo "<p>Prix : " . $row->get_prix() . "$</p></div>";
            echo "</div>"; } ?>

            <a href="search" class="button">Rechercher par évaluation</a>
    </div>
<?php include_once 'inc/footer.php';?>