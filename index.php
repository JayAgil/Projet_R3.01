<?php
session_start();

require "Controlleur/GestionFenetreLogin.php";
require "Controlleur/GestionFenetrePrincipale.php";
require "Controlleur/GestionFenetreJoueur.php";
require "Controlleur/GestionFeuilleMatch.php";
require_once "Modele/DAO/JoueurDAO.php";

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
$action = $_GET['action'] ?? 'dashboard'; 
switch ($action) {

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
        } else {
            die("Match non spécifié");
        }

    case 'ajouterResultat':
        if (!empty($_GET['date']) && !empty($_GET['heure'])) {
            require "Vue/FenetreAjouterResultat.php";
            exit;
        } else {
            die("Match non spécifié");
        }

    default:
        // Unknown action → redirect to dashboard
        header("Location: index.php?action=dashboard");
        exit;
}

// Handle Feuille de Match
if (!empty($_POST['DateDeMatch']) && !empty($_POST['HeureDeMatch'])) {
    require "Controlleur/GestionFeuilleMatch.php";

    $controller = new GestionFeuilleMatch($_POST['DateDeMatch'], $_POST['HeureDeMatch']);
    $data = $controller->executer();
    $players = $data['players'] ?? [];

    include "Vue/FeuilleDeMatch.php";
    exit;
}



// Default: show login page
include "Vue/FenetreLogin.php";
?>
