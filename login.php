<?php
require_once 'class/PDOFactory.php';
$bdd = PDOFactory::getMySQLConnection();
$bddResults = $bdd->query("SELECT * FROM televiseur;");
include_once 'inc/header.php';
$um = new UserManager($bdd);
?>

    <div id="login">

    <div class="message-login">
    <?php 
    $_SESSION['error']="";

    if(isset($_REQUEST['action'])&& $_REQUEST['action']=="connexion"){
        
        $courriel = $_POST['courriel'];
        $mdp = $_POST['mdp'];
        $user = $um->userExists($courriel, $mdp);
 
        if($user){
        $_SESSION['error'] ="Succes";
        $_SESSION['idUser'] = $user['id'];

        ?><h2>Bienvenue <?php echo $_SESSION['pseudo']; ?></h2><?php
        }
        else{
            $_SESSION['error'] = "Les informations d'authentification sont incorrectes.";
            header("Location: login.php");
            exit();
        }
    
    ?>
    </div>
<?php
    }else
    {
       ;
?>
        <h3>Connectez-vous</h3>
        <p>Accedez à votre compte à tout moment.</p>
        <p><?php echo $_SESSION['error']; ?></p>
        <form action="login.php" method="post">
            <label for="usernam">Entrer votre courriel</label>
            <input type="email" name="courriel" class="login-input">

            <label for="usernam">Entrez votre mot de passe</label>
            <input type="text" name="mdp" class="login-input">

            <input type="hidden" name="action" value="connexion"> 
            <button>Connexion</button>
        </form>
        
    </div>
<?php
    }
?>
</body>
</html>