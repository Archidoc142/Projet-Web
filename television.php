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
include_once 'class/TeleviseurManager.php';
$tm = new TeleviseurManager($bdd);
?>

<main>

        <div class="search">
            <div>
                <h5>Recherchez un téléviseur</h5>
            </div>

            <div>
                <form action="television" method="post">
                    <input type="text" name="mots" placeholder="Entez votre mot clé">
                    <button>Rechercher</button>
                </form>
            </div>



        </div>

        <div class="marque">
            <?php 
            $marques = $tm->getMarque();
            foreach($marques as $marque){ ?>
                <a href="television?cat=<?= $marque['id']; ?>"><h6><?php echo $marque['nom'] ?></h6></a>
            <?php } ?>
        
        </div>
        <?php if(isset($_POST['mots'])){ ?>
            <div class="recherche">
                <h4>Résultat de la recherche : <?= $_POST['mots'];  ?></h4>
            </div>
        <?php } ?>
       


        <div class="container-television">
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
                    <?php
                        $categories = $tm->getCategorie();
                        foreach ($categories as $categorie) {
                    ?>
                    <a href="television?option=<?= $categorie; ?>"><?php echo $categorie; ?></a>
                    <?php
                    }
                    ?>
                    </div>
                </div>
            </div>

            </aside>

            <div class="desktop">
                <h6>Caractéritiques</h6>
                <ul>
                <?php
                $categories = $tm->getCategorie();
                foreach ($categories as $categorie) {
                ?>
                    <li><a href="television?option=<?= $categorie; ?>"><?php echo $categorie; ?></a></li>
                <?php
                }
                ?>
                </ul>
            </div>
           
            
            <section>

            <?php

            if(isset($_POST['mots'])){

                $mots = $_POST['mots'];
                $resultats = $tm->searchTeleviseur($mots); ?>

                <?php
                foreach($resultats as $resultat){ ?>
                <div>
                    <img src="img/tv/<?= $resultat['modele'];?>.png" alt="<?= $resultat['nom'];?>">
                    <div>
                        <h3><?= $resultat['nom'];?></h3>
                        <p>Modèle  : <?=$resultat['modele'];?></p>
                        <p>Prix    : <?=$resultat['prix'];?> $</p>
                        <a href="article?modele=<?=$resultat['modele']; ?>">+ de détails</a>
                    </div>
                </div>   
            <?php }
            }else if(isset($_GET['cat'])){
                $categories = $tm->getTelevisionsMarque($_GET['cat']);
                foreach($categories as $categorie){?>
                <div>
                    <img src="img/tv/<?= $categorie['modele'];?>.png" alt="<?= $categorie['nom'];?>">
                    <div>
                        <h3><?= $categorie['nom'];?></h3>
                        <p>Modèle  : <?=$categorie['modele'];?></p>
                        <p>Prix    : <?=$categorie['prix'];?> $</p>
                        <a href="article?modele=<?=$categorie['modele']; ?>">+ de détails</a>
                    </div>
                </div>

            <?php }

            
            }
            else if(isset($_GET['filter']) && isset($_GET['value'])){
                $categorie = $_GET['filter'];
                $valeur = $_GET['value'];
                $categories = $tm->getTelevisionsByCategorie($categorie, $valeur);
                foreach($categories as $categorie){ ?>
                     <h3><?= $categorie['nom'];?></h3>
                    <p>Modèle  : <?=$categorie['modele'];?></p>
                    <p>Prix    : <?=$categorie['prix'];?> $</p>
                    <a href="article?modele=<?=$categorie['modele']; ?>">+ de détails</a>
            <?php }

            }
            else if(isset($_GET['option'])){
                $options = $tm->getTelevisionsCategorie($_GET['option']);
                foreach($options as $option){ ?>

                    <p><?= $option['nom'];?></p>


            <?php    }
            }
            else{

                $televiseurs = $tm->getTeleviseur();
                foreach($televiseurs as $televiseur){?>
                <div><div>
                <img src="img/tv/<?= $televiseur['modele'];?>.png" alt="<?= $televiseur['nom'];?>">
    
                <div>
                    <h3><?= $televiseur['nomTeleviseur'];?></h3></p>
                    <p>Modèle  : <?=$televiseur['modele'];?></p>
                    <p>Prix    : <?=$televiseur['prix'];?> $</p>
                    <a href="article?modele=<?=$televiseur['modele']; ?>">+ de détails</a>
                </div>
                
                </div>
    
    
                <?php  }
            
            } 
            
            ?>
                
            
            
           

            </section>
 
        </div >
        
        <div class="voirplus">
            <a href="television">Voir plus</a>
        </div>
        

<?php include_once 'inc/footer.php';?>
