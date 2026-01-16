<?php
require_once __DIR__ . '/../Modele/DAO/MatchBasketballDAO.php';
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
require_once __DIR__ . '/../Modele/DAO/ParticiperDAO.php';

class GestionFenetrePrincipale {

    public function afficherFenetrePrincipale() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header("Location: /index.php");
            exit;
        }

        $matchDAO = new MatchBasketballDAO();
        $joueurDAO = new JoueurDAO();
        
        $allMatches = $matchDAO->getAllMatches();
        $totalMatchs = count($allMatches);  
        $victoires = $matchDAO->getNbMatch("Victoire");    
        $defaites = $matchDAO->getNbMatch("Défaite");     
        $totalJoueurs = count($joueurDAO->getAll()); 

        $matchsAvenir = $matchDAO->getMatchsAvenir();       
        $recentResults = $allMatches;        
        $topPlayers = $matchDAO->getTopScorers(); 

        require "Vue/FenetrePrincipale.php";
    }
}
?>