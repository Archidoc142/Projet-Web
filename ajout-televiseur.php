<?php
  include_once("inc/header.php");
?>

<main>
    <div class="page-title">
        <h1>Ajoutez un téléviseur!</h1>
        <?php
            if(isset($_POST['action']) && $_POST['action'] == "ajout")
            {
                $tv = $televiseurManager->getTeleviseurObjectByModele($_POST['modele']);
                if(empty($tv))
                {
                    $televiseurManager->addTeleviseur($_POST);
                    echo "<h2>Téléviseur ajouté</h2>";    
                }
                else
                {
                    echo "<h2>Erreur : le numéro de modèle fourni existe déjà.</h2>";    
                }
            }
        ?>
    </div>
  
    <form action="ajout-televiseur" method="post" id="ajout">

        <div class="inputs">
            <div class="input">
                <label for="marque">Marque</label>
                <select name="marque" id="marque">
                <?php
                    $ports = $televiseurManager->getAllMarques();
                    foreach($ports as $port) {?>
                        <option value="<?= $port[0]?>"><?= $port[1]?></option>

                <?php }
                ?>
                </select>
            </div>

            <div class="input">
                <label for="nom">Nom public</label>
                <input type="text" name="nom" id="nom" required>
            </div>

            <div class="input">
                <label for="modele">Modèle</label>
                <input type="text" name="modele" id="modele" required>
            </div>

            <div class="input">
            <label for="lien">Site du fabricant</label>
            <input type="url" name="lien" id="lien" required>
            </div>

            <div class="input">
                <label for="prix">Prix</label>
                <input type="number" name="prix" id="prix" min="1" step="0.01" required>
            </div>

            <div class="input">
            <label for="garantie">Durée garantie (mois)</label>
            <input type="number" name="garantie" id="garantie" min="0" max="480" required>
            </div>

            <div class="input">
            <label for="taille">Taille</label>
            <input type="number" name="taille" id="taille" min="20" max="146" required>
            </div>

            <div class="input">
                <label for="hdr">HDR</label>
                <select name="hdr" id="hdr">
                    <option value="0" selected="selected">Non</option>
                    <option value="1">Oui</option>
                </select>
            </div>

            <div class="input">
                <label for="resolution">Résolution</label>
                <select name="resolution" id="resolution">
                <?php
                    $resolutions = $televiseurManager->getResolutions();
                    foreach($resolutions as $resolution) {?>
                        <option value="<?= $resolution[0]?>"><?= $resolution[1]?></option>

                <?php }
                ?>
                </select>
            </div>

            <div class="input">
                <label for="frequence">Fréquence</label>
                <input type="number" name="frequence" id="frequence" min="60" max="480" value="60" required>
            </div>

            <div class="input">
                <label for="type_ecran">Type écran</label>
                <select name="type_ecran" id="type_ecran">
                <?php
                    $typesEcran = $televiseurManager->getTypesEcran();
                    foreach($typesEcran as $type) {?>
                        <option value="<?= $type[0]?>"><?= $type[1]?></option>

                <?php }
                ?>
                </select>
            </div>

            <div class="input">
                <label for="os">Type écran</label>
                <select name="os" id="os">
                <?php
                    $systemes = $televiseurManager->getOSes();
                    foreach($systemes as $os) {?>
                        <option value="<?= $os[0]?>"><?= $os[1]?></option>

                <?php }
                ?>
                </select>
            </div>
        </div>

        <h3>Ports</h3>
        <div class="ports">
            <?php
                $ports = $televiseurManager->getAllPorts();
                foreach($ports as $port) {?>
                    <div class="port">
                        <label for="<?= $port[0]?>"><?= $port[1]?></label>
                        <input type="number" name="<?= $port[0]?>" id="<?= $port[0]?>" min="0" max="15" value="0" required>
                    </div>
            <?php }
            ?>
        </div>

        <input type="hidden" name="action" value="ajout">
        <button type="submit">Soumettre</button>

    </form>

<?php
  include_once("inc/footer.php");
?>