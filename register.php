<?php
include_once 'inc/header.php';
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


    if ($userManager->addUser($user)) {
        
        echo '<h3>Félicitation votre compte à été enregistré avec succès.</h3>';
        echo '<p>Vous serez rédiriger sur votre profil dans un instant, sinon <a href="index.php">cliquez
        sur ce lien</a> pour acceder à la page accueil</p>';

    } else {

        echo '<p>Erreur lors de l\'inscription.</p><a href="register">Réessayez</a></div></div>';
    }

    //$userManager = new UserManager($bdd);
    //$lastuser= $userManager->getLastUser();
}else{
?>
</div>

<h3>Creez un compte</h3>
<p>Creer un compte pour acceder à toutes les fonctionnalités du site.</p>
        <form id="registration-form" action="register" method="post">
            <label for="pseudonyme">Nom d'utilisateur</label>
            <input type="text" name="pseudonyme" id="pseudonyme" class="register-input">

            <label for="email1">Email</label>
            <input type="email" name="courriel" id="email1" class="register-input" required>

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" class="register-input" required>

            <label for="prenom">Prenom</label>
            <input type="text" name="prenom" id="prenom" class="register-input">

            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" class="register-input">

            <label for="langue">Langue</label>
            <select name="id_langue" id="langue" class="register-input">
            <?php
                   $langues = $userManager->getLangue(); 
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




<?php include_once('inc/footer.php')?>