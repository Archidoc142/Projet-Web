<?php
require_once 'class/PDOFactory.php';
$bdd = PDOFactory::getMySQLConnection();

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
                    <li><a href="television?option=marque">Marque</a></li>
                    <li><a href="television?option=os">Système d'exploitation</a></li>
                    <li><a href="television?option=port">Type de port</a></li>
                    <li><a href="television?option=resolution">Résolution des écrans</a></li>
                    <li><a href="television?option=televiseur">Les télevisions</a></li>
                    <li><a href="television?option=type_ecran">Les types d'écran</a></li>
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

            else if((isset($_GET['option'])&& $_GET['option']==="all") || !(isset($_GET['option']))){
                $televiseurs = $tm->getTeleviseurs();
                foreach($televiseurs as $televiseur){?>
                <div class="televiseur"><!--div-->
                    <img src="img/tv/<?=$televiseur->get_modele()?>.png" alt="<?=$televiseur->get_modele()?>">
                    <div class="tv-info">
                        <h2><?=$televiseur->get_nom();?></h2>
                        <p>Modèle  : <?=$televiseur->get_modele()?></p>
                        <h3><?=$televiseur->get_prix()?> $</h3>
                        <a href="article?modele=<?=$televiseur->get_modele()?>">+ de détails</a>
                    </div>
                </div>

            <?php }
            }

            // code non utilisé?
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
            ?>
            </section>
 
        </div >
        
        <!--div class="voirplus">
            <a href="television?option=all">Voir plus</a>
        </div-->
        

<?php include_once 'inc/footer.php';?>
