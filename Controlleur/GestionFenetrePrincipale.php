<?php

/**
 * Contrôleur de gestion de la fenêtre principale (Dashboard)
 * Gère l'affichage du tableau de bord et les actions sur les matchs
 */

require_once __DIR__ . '/../Modele/DAO/MatchBasketballDAO.php';
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
require_once __DIR__ . '/../Modele/DAO/ParticiperDAO.php';

class GestionFenetrePrincipale {

    /**
     * Affiche la fenêtre principale du tableau de bord
     * Récupère toutes les statistiques et données nécessaires pour l'affichage
     * Vérifie d'abord que l'utilisateur est connecté
     */
    public function afficherFenetrePrincipale() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php");
            exit;
        }

        $matchDAO = new MatchBasketballDAO();
        $joueurDAO = new JoueurDAO();
        
        $allMatches = $matchDAO->getAllMatches();
        $data = [
            'totalMatchs'   => count($allMatches),
            'victoires'     => $matchDAO->getNbMatch("Victoire"),
            'defaites'      => $matchDAO->getNbMatch("Défaite"),
            'totalJoueurs'  => count($joueurDAO->getAll()),
            'matchsAvenir'  => $matchDAO->getMatchsAvenir(),
            'recentResults' => $allMatches,
            'topPlayers'    => $matchDAO->getTopScorers()
        ];
        extract($data);
        require "Vue/FenetrePrincipale.php";
    }

    /**
     * Supprime un match de la base de données
     * Utilise la date et l'heure du match comme identifiant
     * Vérifie d'abord que l'utilisateur est connecté et que les paramètres sont présents
     */
    public function supprimerMatch() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php");
        exit;
    }

    if (!isset($_GET['date'], $_GET['heure'])) {
        header("Location: index.php?action=dashboard");
        exit;
    }

    $date  = $_GET['date'];
    $heure = $_GET['heure'];

    $matchDAO = new MatchBasketballDAO();
    $matchDAO->deleteMatch($date, $heure);

    header("Location: index.php?action=dashboard");
    exit;
}

}
?>