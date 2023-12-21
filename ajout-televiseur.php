<?php
  include_once("inc/header.php");
?>

<main>
    <div class="page-title">
        <h1>Ajoutez un téléviseur!</h1>
    </div>
  
    <form action="ajout-televiseur" method="post">
        <label for="marque">Marque</label>
        <select name="marque" id="marque">
        <?php
            $ports = $televiseurManager->getAllMarques();
            foreach($ports as $port) {?>
                <option value="<?= $port[0]?>"><?= $port[1]?></option>

        <?php }
        ?>
        </select>

        <label for="resolution">Résolution</label>
        <select name="resolution" id="resolution">
        <?php
            $resolutions = $televiseurManager->getResolutions();
            foreach($resolutions as $resolution) {?>
                <option value="<?= $resolution[0]?>"><?= $resolution[1]?></option>

        <?php }
        ?>
        </select>

        <label for="type_ecran">Type écran</label>
        <select name="type_ecran" id="type_ecran">
        <?php
            $typesEcran = $televiseurManager->getTypesEcran();
            foreach($typesEcran as $type) {?>
                <option value="<?= $type[0]?>"><?= $type[1]?></option>

        <?php }
        ?>
        </select>

        <label for="os">Type écran</label>
        <select name="os" id="type_ecran">
        <?php
            $systemes = $televiseurManager->getOSes();
            foreach($systemes as $os) {?>
                <option value="<?= $os[0]?>"><?= $os[1]?></option>

        <?php }
        ?>
        </select>

    </form>
</main>

<?php
  include_once("inc/footer.php");
?>