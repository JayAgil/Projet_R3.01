<?php
session_start();

require "Controlleur/GestionFenetreLogin.php";
require "Controlleur/GestionFenetrePrincipale.php";
require "Controlleur/GestionFenetreJoueur.php";
require "Controlleur/GestionFeuilleMatch.php";


if (isset($_GET['action'])) {

    if (!isset($_SESSION['user'])) {
        header("Location: index.php");
        exit;
    }

    switch ($_GET['action']) {

        case 'dashboard':
            $controller = new GestionFenetrePrincipale();
            $controller->afficherFenetrePrincipale();
            exit;

        case 'joueurs':
            $controller = new GestionFenetreJoueur();
            $controller->afficherFenetreJoueur();
            exit;

        case 'feuille':
            if (!empty($_GET['date']) && !empty($_GET['heure'])) {
                $controller = new GestionFeuilleMatch($_GET['date'], $_GET['heure']);
                $data = $controller->executer();
                $players = $data['players'] ?? [];
                require "Vue/FeuilleDeMatch.php";
                exit;
            }
            break;
         case 'ajouterResultat':
            if (!empty($_GET['date']) && !empty($_GET['heure'])) {
                require "Vue/FenetreAjouterResultat.php";
                exit;
            } else {
                die("Match non spécifié");
            }
            break;
    }
}

$erreur = '';

if (!empty($_POST['username']) && !empty($_POST['mdp'])) {
    $nom = $_POST['username'];
    $mdp = $_POST['mdp'];

    $controller = new GestionFenetreLogin($nom, $mdp);

    if ($controller->executer()) {
        $_SESSION['user'] = $nom;
        header("Location: index.php?action=dashboard");
        exit;
    } else {
        $erreur = "Utilisateur inexistant ou mot de passe incorrect";
    }
}

require "Vue/FenetreLogin.php";
