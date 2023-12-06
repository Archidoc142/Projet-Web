<?php
require_once 'class/PDOFactory.php';
$bdd = PDOFactory::getMySQLConnection();
$modele = isset($_GET['modele']) ? $_GET['modele'] : '';
$stmt = $bdd->prepare("SELECT t.*, m.nom AS marque, r.nom AS resolution, e.nom AS type_ecran FROM televiseur t
                       JOIN marque m ON m.id = t.id_marque
                       JOIN resolution r ON r.id = t.id_resolution
                       JOIN type_ecran e ON e.id = t.id_type_ecran
                       WHERE modele = :modele");
$stmt->bindParam(':modele', $modele, PDO::PARAM_STR);
$stmt->execute();
$bddResults = $stmt->fetch(PDO::FETCH_ASSOC);   
include_once 'inc/header.php';
?>

<main>
    <h1 class="center titleArticle"><?php echo $bddResults['nom'];?></h1>

    <div class="containerTV-Article">
        
    </div>

<?php include_once 'inc/footer.php';?>