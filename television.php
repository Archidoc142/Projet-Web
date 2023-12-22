<?php
require_once 'class/PDOFactory.php';
include_once 'inc/header.php';
include_once 'class/UserManager.php';
include_once 'class/TeleviseurManager.php';

$parametres = "";

foreach(array('mots', 'cat', 'option', 'filter', 'value') as $parametre) {
  if (isset($_REQUEST[$parametre])) {
      $parametres = $parametres . $parametre . '=' . $_REQUEST[$parametre] . '&';
  }
}

if (!empty($parametres)) {
  $parametres = substr($parametres, 0, -1);
  setcookie("televisionParameters", $parametres, time() + 86400 * 30);
}
?>

<main id="mainTelevision">

        <div class="search">
            <div>
                <h5>Recherchez un téléviseur</h5>
            </div>
            <div>
                <form action="television" method="GET">
                    <input type="text" name="mots" placeholder="Entez votre mot clé">
                    <button>Rechercher</button>
                </form>
            </div>
        </div>

        <div class="marque">
            <a href="television?option=all"><h6>Toutes marques</h6></a>
            <?php 
                $marques = $televiseurManager->getMarque();
                foreach($marques as $marque){ ?>
                    <a href="television?cat=<?= $marque['id']; ?>"><h6><?php echo $marque['nom'] ?></h6></a>
            <?php } ?>
        
        </div>

        <?php if(isset($_GET['mots'])){ ?>
            <div class="recherche">
                <h4>Résultat de la recherche : <?= $_GET['mots'];  ?></h4>
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
                        $categories = $televiseurManager->getCategorie();
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

            if(isset($_GET['option']) && $_GET['option'] != "all"){
                $options = $televiseurManager->getTelevisionsCategorie($_GET['option']);
                foreach($options as $option){ ?>
                    <p><?= $option['nom'];?></p>
            <?php }
            }

            else 
            {
                if(isset($_GET['mots']))
                {
                    $mots = $_GET['mots'];
                    $televiseurs = $televiseurManager->searchTeleviseur($mots); 
                    if(empty($televiseurs))
                    {
                        echo "<h5>Aucun téléviseur ne correspond à votre recherche.</h5>";
                    }
                } 
                else if(isset($_GET['cat']))
                {
                    $televiseurs = $televiseurManager->getTeleviseursByMarque($_GET['cat']);
                }

                else if((isset($_GET['option'])&& $_GET['option']==="all") || !(isset($_GET['option']))){
                    $televiseurs = $televiseurManager->getTeleviseurs();
                }

                foreach($televiseurs as $televiseur){?>
                    <div class="televiseur">
                        <img src="img/tv/<?php echo (file_exists("img/tv/" . $televiseur->get_modele() . ".png")) ? $televiseur->get_modele() : "generic"; ?>.png" alt="<?= $resultat['nom'];?>">
                        <div class="tv-info">
                            <h2><?=$televiseur->get_nom();?></h2>
                            <p>Modèle  : <?=$televiseur->get_modele()?></p>
                            <h3><?=$televiseur->get_prix()?> $</h3>
                            <a href="article?modele=<?=$televiseur->get_modele()?>">+ de détails</a>
                        </div>
                    </div>

                <?php }
            }
            ?>
            </section>
        </div>
        
<?php include_once 'inc/footer.php';?>