<?php
    include_once 'inc/header.php';
    require_once 'class/TeleviseurManager.php';

    $tvMgr = new TeleviseurManager($bdd);
    
    $marques = $tvMgr->getMarques();
    
?>

<main>
    <div class="page-title">
        <h1>Nos marques</h1>
    </div>
    <div id="marques">
        <?php foreach($marques as $marque) { ?>
            <a href="" class="marque">
                <img src="img/marque/<?php echo($marque) ?>.png" alt="<?php echo($marque) ?>">
            </a>
                
        <?php } ?>
    </div>
</main>

<?php include_once 'inc/footer.php'; ?>