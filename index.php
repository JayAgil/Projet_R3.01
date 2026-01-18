<?php
/**
 * Point d'entrée principal de l'application
 * Gère l'authentification et le routage de toutes les actions
 */

session_start();

require "Controlleur/GestionFenetreLogin.php";
require "Controlleur/GestionFenetrePrincipale.php";
require "Controlleur/GestionFeuilleMatch.php";
require "Controlleur/GestionFenetreJoueur.php";
require_once "Modele/DAO/JoueurDAO.php";

$erreur = '';

if (!empty($_POST['username']) && !empty($_POST['mdp'])) {
    $nom = $_POST['username'];
    $mdp = $_POST['mdp'];
    
    // Tentative de connexion
    $controller = new GestionFenetreLogin($nom, $mdp);
    if ($controller->executer()) {
        $_SESSION['user'] = $nom;
        header("Location: index.php?action=dashboard");
        exit;
    } else {
        $erreur = "Utilisateur inexistant ou mot de passe incorrect";
    }
}

// Vérification de la session utilisateur
if (!isset($_SESSION['user'])) {
    include "Vue/FenetreLogin.php";
    exit;
}

$action = $_GET['action'] ?? 'dashboard'; 

switch ($action) {
    // Affichage du tableau de bord principal
    case 'dashboard':
        $controller = new GestionFenetrePrincipale();
        $controller->afficherFenetrePrincipale();
        exit;
    
    // Gestion des joueurs (liste, ajout, modification, suppression)
    case 'joueurs':
    case 'add':
    case 'store':
    case 'edit':
    case 'update':
    case 'delete':
        $controller = new GestionFenetreJoueur();
        $controller->gererAction();
        exit;
    
    // Affichage et gestion de la feuille de match
    case 'feuille':
        if (!empty($_GET['MatchID'])) {
            $controller = new GestionFeuilleMatch($_GET['MatchID']);
            $controller->executer(); 
            
            exit; 
        } else {
            die("Erreur : ID du match (MatchID) non spécifié.");
        }
    
    // Ajout d'un résultat pour un match existant
    case 'ajouterResultat':
        if (!empty($_GET['date']) && !empty($_GET['heure'])) {
            require "Vue/FenetreAjouterResultat.php";
            exit;
        } else {
            die("Match non spécifié");
        }
    
    // Affichage du formulaire d'ajout de match
    case 'ajouterMatch':
        require "Vue/FenetreAjouterMatch.php";
        exit;
    
    // Enregistrement d'un nouveau match dans la base de données
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
    
    // Affichage des statistiques des joueurs
    case 'statistiques':
        $controller = new GestionFenetreJoueur();
        $controller->afficherStatistiquesJoueurs();
        exit;
    
    // Déconnexion - destruction de la session
    case 'logout':
        session_destroy();
        header("Location: index.php");
        exit;
    
    // Suppression d'un match
    case 'supprimerMatch':
        $gestion = new GestionFenetrePrincipale();
        $gestion->supprimerMatch();
        exit;
    
    // Action par défaut - redirection vers le dashboard
    default:
        header("Location: index.php?action=dashboard");
        exit;
}