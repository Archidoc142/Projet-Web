<?php
include_once 'inc/header.php';

if (isset($_REQUEST['action'])) {
    $tvs = $televiseurManager->getTvByEvaluation($_REQUEST['note'], $_REQUEST['mot']);
}
?>
<main>

    <h1 class="center searchTitle">Rechercher des télévisions selon leurs évaluations</h1>

    <form action="" method="post" class="searchEv">
        <label for="mot">Entrez un mot clé : </label>
        <input type="text" name="mot"><br>

        <label for="note">Min : </label>
        <select name="note">
			<option value="0">0</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select><br>

        <input type="hidden" name="action" value="rechercher">
        <button type="submit" class="button">Recherche</button>
    </form>

    <?php if (isset($_REQUEST['action'])) { ?>
        <div class="searchTvs">
            <?php foreach ($tvs as $row) { ?>
                <div class="containerSearchTV">
                    <a href="article?modele=<?php echo rawurlencode($row->get_modele()) ?>">
                        <div class="center">
                            <img src="img/tv/<?php echo $row->get_modele() ?>.png" alt="tv">
                        </div>
                        <div>
                            <h3><?php echo $row->get_nom() ?></h3>
                            <h4>Note : <?php echo $televiseurManager->getEvaluationByModele($row->get_modele())[0]; ?> / 5</h4>
                        </div>
                    </a>
                </div>
            <?php  } ?>
        </div>
    <?php } ?>
<?php include_once 'inc/footer.php';?>