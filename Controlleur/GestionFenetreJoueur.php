<?php
/**
 * Contrôleur de gestion de la fenêtre des joueurs
 * Gère toutes les actions liées aux joueurs (ajout, modification, suppression, affichage)
 */

require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
require_once __DIR__ . '/../Modele/Joueur.class.php';

class GestionFenetreJoueur {
    private JoueurDAO $joueurDAO;
    
    /**
     * Constructeur - Initialise le DAO des joueurs
     */
    public function __construct() {
        $this->joueurDAO = new JoueurDAO();
    }
    
    /**
     * Gère les différentes actions selon le paramètre GET 'action'
     * Routes vers la méthode appropriée
     */
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
    
    /**
     * Affiche le formulaire d'ajout d'un nouveau joueur
     */
    public function afficherAjouterJoueur() {
        require __DIR__ . '/../Vue/FenetreAjouterJoueur.php';
        exit;
    }
    
    /**
     * Enregistre un nouveau joueur dans la base de données
     * Récupère les données du formulaire via GET et crée un objet Joueur
     */
    public function stockerJoueur() {
        $nouveauJoueur = new Joueur(
            $_GET['NumeroLicence'] ?? '',
            $_GET['Nom'] ?? '',
            $_GET['Prenom'] ?? '',
            $_GET['DateDeNaissance'] ?? null,
            $_GET['Taille_cm'] ?? 0,
            $_GET['Poids_kg'] ?? 0,
            $_GET['Statut'] ?? '',
            $_GET['Commentaire'] ?? ''
        );
        
        $this->joueurDAO->insert($nouveauJoueur);
        header('Location: /Projet_R3.01/index.php?action=joueurs');
        exit;
    }
    
    /**
     * Affiche le formulaire de modification d'un joueur existant
     * Récupère le joueur par son numéro de licence
     */
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
    
    /**
     * Met à jour les informations d'un joueur existant
     * Récupère les nouvelles données du formulaire via GET
     */
    public function updateJoueur() {

        if (!isset($_GET['NumeroLicence'])) {
            echo 'Erreur : numéro de licence manquant.';
            exit;
        }

        $joueurModifie = new Joueur(
            $_GET['NumeroLicence'],
            $_GET['Nom'] ?? '',
            $_GET['Prenom'] ?? '',
            $_GET['DateDeNaissance'] ?? null,
            $_GET['Taille_cm'] ?? 0,
            $_GET['Poids_kg'] ?? 0,
            $_GET['Statut'] ?? '',
            $_GET['Commentaire'] ?? ''
        );
        
        $this->joueurDAO->update($joueurModifie);

        header('Location: /Projet_R3.01/index.php?action=joueurs');
        exit;
    }
    
    /**
     * Supprime un joueur de la base de données
     * Utilise le paramètre GET 'id' (numéro de licence)
     */
    public function deleteJoueur() {

        if (!isset($_GET['id'])) {
            header('Location: /Projet_R3.01/index.php?action=joueurs');
            exit;
        }

        $this->joueurDAO->delete($_GET['id']);
        header('Location: /Projet_R3.01/index.php?action=joueurs');
        exit;
    }
    
    /**
     * Affiche la liste complète de tous les joueurs
     * Récupère tous les joueurs depuis la base de données
     */
    public function afficherListeJoueur() {

        $joueurs = $this->joueurDAO->getAll();
        require __DIR__ . '/../Vue/FenetreJoueur.php';
        exit;
    }
    
    /**
     * Affiche les statistiques détaillées de tous les joueurs
     * Calcule et affiche : sélections, évaluations, victoires, etc.
     */
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
