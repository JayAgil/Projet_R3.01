<?php
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';

class GestionFenetreJoueur {
    private JoueurDAO $joueurDAO;
    
    public function __construct() {
        $this->joueurDAO = new JoueurDAO();
    }
    
    public function gererAction() {
        $action = $_GET['action'] ?? '';
        switch ($action) {
            case 'add':
                $this->afficherAjouterJoueur();
                break;
            case 'store':
                $this->stockerJoueur();
                break;
            case 'edit':
                $this->afficherModifierJoueur();
                break;
            case 'update':
                $this->updateJoueur();
                break;
            case 'delete':
                $this->deleteJoueur();
                break;
            default:
                $this->afficherListeJoueur();
                break;
        }
    }
    
    public function afficherAjouterJoueur() {
        require __DIR__ . '/../Vue/FenetreAjouterJoueur.php';
        exit;
    }
    
    public function stockerJoueur() {
        $nouveauJoueur = new Joueur(
            $_GET['NumeroLicence'] ?? '',
            $_GET['Nom'] ?? '',
            $_GET['Prenom'] ?? '',
            $_GET['DateDeNaissance'] ?? '',
            $_GET['Taille_cm'] ?? 0,
            $_GET['Poids_kg'] ?? 0,
            $_GET['Statut'] ?? '',
            $_GET['Commentaire'] ?? ''
        );
        $this->joueurDAO->insert($nouveauJoueur);
        header('Location: /Projet_R3.01/index.php?action=joueurs');
        exit;
    }
    
    public function afficherModifierJoueur() {
        if (!isset($_GET['NumeroLicence'])) {
            echo 'Erreur : numéro de licence manquant.';
            exit;
        }
        $joueur = $this->joueurDAO->getById($_GET['NumeroLicence']);
        if (!$joueur) {
            echo 'Erreur : joueur introuvable.';
            exit;
        }
        require __DIR__ . '/../Vue/FenetreModifierJoueur.php';
        exit;
    }
    
    public function updateJoueur() {
        if (!isset($_GET['NumeroLicence'])) {
            echo 'Erreur : numéro de licence manquant.';
            exit;
        }
        $joueurModifie = new Joueur(
            $_GET['NumeroLicence'],
            $_GET['Nom'] ?? '',
            $_GET['Prenom'] ?? '',
            $_GET['DateDeNaissance'] ?? '',
            $_GET['Taille_cm'] ?? 0,
            $_GET['Poids_kg'] ?? 0,
            $_GET['Statut'] ?? '',
            $_GET['Commentaire'] ?? ''
        );
        $this->joueurDAO->update($joueurModifie);
        header('Location: /Projet_R3.01/index.php?action=joueurs');
        exit;
    }
    
    public function deleteJoueur() {
        if (!isset($_GET['id'])) {
            header('Location: /Projet_R3.01/index.php?action=joueurs');
            exit;
        }
        $this->joueurDAO->delete($_GET['id']);
        header('Location: /Projet_R3.01/index.php?action=joueurs');
        exit;
    }
    
    public function afficherListeJoueur() {
        $joueurs = $this->joueurDAO->getAll();
        require __DIR__ . '/../Vue/FenetreJoueur.php';
        exit;
    }

    public function afficherStatistiquesJoueurs() {
        $joueurs = $this->joueurDAO->getAll();
        $statistiques = [];
        foreach ($joueurs as $joueur) {
            $stats = $this->joueurDAO->getStatistiques($joueur['NumeroLicence']);
            $statistiques[] = array_merge($joueur, $stats);
        }
    
        require __DIR__ . '/../Vue/FenetreStatistiquesJoueurs.php';
        exit;
}
}