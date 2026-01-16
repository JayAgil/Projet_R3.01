<?php
session_start();

require "Controlleur/GestionFenetreLogin.php";
require "Controlleur/GestionFenetrePrincipale.php";
require "Modele/DAO/JoueurDAO.php";

$erreur = '';

// Handle login
if (!empty($_POST['username']) && !empty($_POST['mdp'])) {
    $nom = $_POST['username'];
    $mdp = $_POST['mdp'];

    $controller = new GestionFenetreLogin($nom, $mdp);

    if ($controller->executer()) {
        $_SESSION['user'] = $nom;
        header("Location: Vue/FenetrePrincipale.php");
        exit;
    } else {
        $erreur = "Utilisateur inexistant ou mot de passe incorrect";
    }
}

// Handle Feuille de Match
if (!empty($_POST['DateDeMatch']) && !empty($_POST['HeureDeMatch'])) {
    require "Controlleur/GestionFeuilleMatch.php";

    $controller = new GestionFeuilleMatch($_POST['DateDeMatch'], $_POST['HeureDeMatch']);
    $data = $controller->executer();
    $players = $data['players'] ?? [];
    exit;
}

// Default: show login page
include "Vue/FenetreLogin.php";
?>
