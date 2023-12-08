<?php
require_once 'class/PDOFactory.php';
$bdd = PDOFactory::getMySQLConnection();
$modele = isset($_GET['modele']) ? $_GET['modele'] : '';
$stmt = $bdd->prepare("SELECT t.*, m.nom AS marque, r.nom AS resolution, e.nom AS type_ecran, o.nom AS os FROM televiseur t
                       JOIN marque m ON m.id = t.id_marque
                       JOIN resolution r ON r.id = t.id_resolution
                       JOIN type_ecran e ON e.id = t.id_type_ecran
                       JOIN os o ON o.id = t.id_os
                       WHERE modele = :modele");
$THEmodele = htmlspecialchars($modele, ENT_QUOTES, 'UTF-8');
$stmt->bindParam(':modele', $THEmodele, PDO::PARAM_STR);
$stmt->execute();
$bddResults = $stmt->fetch(PDO::FETCH_ASSOC);   
include_once 'inc/header.php';
?>

<main>
    <h1 class="center titleArticle"><?php echo $bddResults['nom']?></h1>
    <div class="containerArticle">
        <img src='img/tv/<?php echo $bddResults['modele'] ?>.png' alt='img_tv' draggable='false'>
        <div>
            <h2>Information générale :</h1>
            <div class="grid3C">
                <div><p><span class='bold'>Modèle</span> : <?php echo $bddResults['modele'] ?></p><p><span class='bold'>Marque</span> : <?php echo $bddResults['marque'] ?></p><p><span class='bold'>OS</span> : <?php echo $bddResults['os'] ?></p></div>
                <div><p><span class='bold'>Type écran</span> : <?php echo $bddResults['type_ecran'] ?></p><p><span class='bold'>Résolution</span> : <?php echo $bddResults['resolution'] ?></p><p><span class='bold'>Fréquence</span> : <?php echo $bddResults['frequence'] ?> Hz</p></div>
                <div><p><span class='bold'>HDR</span> :<?php echo ($bddResults['hdr'] == 1) ? "Oui" : "Non"; ?></p><span class='bold'><p><span class='bold'>Taille</span> : <?php echo $bddResults['taille'] ?>"</p><p><span class='bold'>Prix</span> : <?php echo $bddResults['prix'] ?> $</p></div>
            </div>
        </div>
    </div>
    <a href="evaluations?modele=<?= $bddResults['modele'];?>" class="button">Évaluations</a>

<?php include_once 'inc/footer.php';?>