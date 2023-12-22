<?php
    include_once 'inc/header.php';
    $marques = $televiseurManager->getMarques();
    
?>

<main id="main-marques">
    <div class="page-title">
        <h1>Nos marques</h1>
    </div>
    <div id="marques">
        <?php foreach($marques as $index=>$marque) { ?>
            <a href="television?cat=<?php echo($index + 1) ?>" class="marque">
                <img src="img/marque/<?php echo($marque) ?>.png" alt="<?php echo($marque) ?>">
            </a>
                
        <?php } ?>
    </div>

<?php include_once 'inc/footer.php'; ?>