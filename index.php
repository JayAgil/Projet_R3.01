<?php

require "Controlleur/GestionFenetrePrincipale.php";
require "Controlleur/GestionFenetreLogin.php";

if (!empty($_POST['username']) && !empty($_POST['mdp'])){
    $nom = $_POST['username'];
    $mdp = $_POST['mdp'];
    $controller = new GestionFenetreLogin($nom,$mdp);
    if ($controller->executer()){
        header("Location: FenetrePrincipale.php");
        exit;
    } else {
        $erreur = "Utilisateur inexistant ou mot de passe incorrect";
    }
}
include "vue/FenetreLogin.php";


?>