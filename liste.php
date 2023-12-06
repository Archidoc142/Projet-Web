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
include_once 'class/UserManager.php';
$um = new UserManager($bdd);
?>

<main>

        <div class="search">
            <div>
                <h3>Recherchez un téléviseur</h3>
            </div>

            <div>
                <form action="">
                    <input type="text" placeholder="Entez votre mot clé">
                </form>
            </div>

            <div>
                <a href="">Mon profil</a>
                <a href="">Déconnexion</a>
            </div>

        </div>

        <div class="marque">
            <?php 
            $marques = $um->getMarque();
            foreach($marques as $marque){ ?>
                <a href=""><?php echo $marque['nom'] ?></a>
            <?php } ?>
        
        </div>

        <div class="container">
            <aside>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Categorie
                    </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    <a href="">Modèle</a>
                        <a href="">Taille</a>
                        <a href="">Résolution</a>
                        <a href="">Fréquence</a>
                        <a href="">Type d'écran</a>
                        <a href="">HDR</a>
                        <a href="">Smart</a>
                        <a href="">Système d'exploitation</a>
                        <a href="">Port</a>
                        <a href="">Garantie</a>
                    </div>
                </div>
            </div>
            
                        

            </aside>

            <section>
            <?php
            $televiseurs = $um->getTeleviseur();
            foreach($televiseurs as $televiseur){?>
            <img src="img/tv/<?= $televiseur['modele'];?>.png" alt="<?= $televiseur['nom'];?>">

            <div>
                <h3><?= $televiseur['nomTeleviseur'];?></h3></p>
                <p>sdkjhkdjh</p>
            </div>

            <?php } ?>
               

                <div>

                </div>

            </section>
        </div>

       

<?php include_once 'inc/footer.php';?>