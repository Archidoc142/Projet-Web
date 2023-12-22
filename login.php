<?php
require_once 'class/PDOFactory.php';
$bdd = PDOFactory::getMySQLConnection();
$bddResults = $bdd->query("SELECT * FROM televiseur;");
include_once 'inc/header.php';
$um = new UserManager($bdd);
?>
<main>
    <div id="login">

    <div class="message-login">
    <?php 
if (isset($_SESSION['idUser']) && isset($_SESSION['pseudo'])) {
    header("Location: index");
    exit();
    /*?><h2>Bienvenue <?php echo $_SESSION['pseudo']; ?></h2>
    </div>
    <?php*/
    }
    else
    {
?>
</div>
        <h3>Connectez-vous</h3>
        <p>Accedez à votre compte à tout moment.</p>
        <p><?= isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?></p>
        <form action="login" method="post">
            <label for="courriel">Entrer votre courriel</label>
            <input type="email" name="courriel" id="courriel" class="login-input">

            <label for="mdp">Entrez votre mot de passe</label>
            <input type="password" name="mdp" id="mdp" class="login-input">

            <input type="hidden" name="action" value="connexion"> 
            
            <button>Connexion</button>
        </form>
        
    </div>
<?php
    }
    include_once 'inc/footer.php';
?>