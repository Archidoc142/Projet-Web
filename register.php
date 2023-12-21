<?php
require_once 'class/PDOFactory.php';
$bdd = PDOFactory::getMySQLConnection();
$bddResults = $bdd->query("SELECT * FROM televiseur;");
include_once 'inc/header.php';
include_once 'class/UserManager.php';
$um = new UserManager($bdd);
?>
<main>
<div id="register">

    <div class="message-register">
    
    <?php


if(isset($_REQUEST['action']) && $_REQUEST['action']=="inscription"){

    /*$pseudonyme = $_POST['pseudonyme'];
    $email = $_POST['courriel'];
    $password =$_POST['password'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $langue = $_POST['langue'];*/

    $user = new User($_REQUEST);


    if ($um->addUser($user)) {
        
        echo '<h3>Félicitation votre compte à été enregistré avec succès.</h3>';
        echo '<p>Vous serez rédiriger sur votre profil dans un instant, sinon <a href="index.php">cliquez
        sur ce lien</a> pour acceder à la page accueil</p>';

    } else {

        echo '<p>Erreur lors de l\'inscription.</p>';
    }

    //$um = new UserManager($bdd);
    //$lastuser= $um->getLastUser();
}else{
?>
</div>

<h3>Creez un compte</h3>
<p>Creer un compte pour acceder à toutes les fonctionnalités du site.</p>
        <form id="registration-form" action="register.php" method="post">
            <label for="usernam">Nom d'utilisateur</label>
            <input type="text" name="pseudonyme" class="register-input">

            <label for="usernam">Email</label>
            <input type="email" name="courriel" id="email1" class="register-input" required>

            <label for="usernam">Mot de passe</label>
            <input type="text" name="mdp" id="mdp" class="register-input" required>

            <label for="usernam">Prenom</label>
            <input type="text" name="prenom" class="register-input">

            <label for="usernam">Nom</label>
            <input type="text" name="nom" class="register-input">

            <label for="usernam">Langue</label>
            <select name="id_langue" id="langue" class="register-input">
            <?php
                   $langues = $um->getLangue(); 
                   foreach($langues as $langue){ ?>
            <option value="<?= $langue['id']; ?>"><?= $langue['nom_complet']; ?></option>  
            <?php 
                   }
            ?>
            </select>

            <input type="hidden" name="action" value="inscription">
            <button>Creer votre compte</button>
        </form>
    </div>

<?php
}  
?>
</main>



<?php include_once('inc/footer.php')?>