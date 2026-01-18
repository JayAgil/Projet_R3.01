<?php
session_start();
require "Controlleur/GestionFenetreLogin.php";
require "Controlleur/GestionFenetrePrincipale.php";
require "Controlleur/GestionFeuilleMatch.php";
require "Controlleur/GestionFenetreJoueur.php";
require_once "Modele/DAO/JoueurDAO.php";

$erreur = '';

// Handle login form submission
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

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    // User not logged in, show login page
    include "Vue/FenetreLogin.php";
    exit;
}

// User is logged in, handle actions
$action = $_GET['action'] ?? 'dashboard'; 

switch ($action) {
    case 'dashboard':
        $controller = new GestionFenetrePrincipale();
        $controller->afficherFenetrePrincipale();
        exit;
    case 'joueurs':
    case 'add':
    case 'store':
    case 'edit':
    case 'update':
    case 'delete':
        $controller = new GestionFenetreJoueur();
        $controller->gererAction();
        exit;
    case 'feuille':
    // Use MatchID as the primary identifier now
    if (!empty($_GET['MatchID'])) {
        $controller = new GestionFeuilleMatch($_GET['MatchID']);
        
        // This method handles the saving logic, data fetching, 
        // AND it includes the View itself. 
        $controller->executer(); 
        
        exit; // Important to stop double rendering
    } else {
        die("Erreur : ID du match (MatchID) non spécifié.");
    }
    case 'ajouterResultat':
        if (!empty($_GET['date']) && !empty($_GET['heure'])) {
            require "Vue/FenetreAjouterResultat.php";
            exit;
        } else {
            die("Match non spécifié");
        }
    case 'ajouterMatch':
        require "Vue/FenetreAjouterMatch.php";
        exit;
    case 'saveMatch':
        if (!empty($_POST['date']) && !empty($_POST['heure'])) {
            require_once "Modele/DAO/MatchBasketballDAO.php";
            $dao = new MatchBasketballDAO();
            $dao->insertMatch(
                $_POST['date'],
                $_POST['heure'],
                $_POST['equipe'],
                $_POST['lieu'],
                $_POST['resultat'] ?? 'N/A',
                $_POST['pointsAdv'] ?? 0,
                $_POST['statut']
            );
            header("Location: index.php?action=dashboard");
            exit;
        } else {
            die("Données du match manquantes !");
        }
    case 'statistiques':
        $controller = new GestionFenetreJoueur();
        $controller->afficherStatistiquesJoueurs();
        exit;

    case 'logout':
        session_destroy();
        header("Location: index.php");
        exit;

    case 'supprimerMatch':
        $gestion = new GestionFenetrePrincipale();
        $gestion->supprimerMatch();
        exit;

    default:
        header("Location: index.php?action=dashboard");
        exit;
}
?>