<?php
require_once 'class/PDOFactory.php';
$bdd = PDOFactory::getMySQLConnection();
$bddResults = $bdd->query("SELECT * FROM televiseur;");
include_once 'inc/header.php';
?>

<main>
    <h1 class="center titleIndex">Bienvenue sur Bureau en maigre</h1>
    <p class="center">Nous vous aiderons à trouver la télévision la mieux adaptée à vos besoins et votre budget</p>


<?php include_once 'inc/footer.php';?>