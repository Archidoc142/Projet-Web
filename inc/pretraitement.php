<?php
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
    
    include_once('autoloader.php');

    $bdd = PDOFactory::getMySQLConnection();
?>