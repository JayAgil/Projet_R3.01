<?php
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
require_once __DIR__ . '/../Modele/Joueur.class.php';

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

    private function afficherAjouterJoueur() {
        require __DIR__ . '/../Vue/FenetreAjouterJoueur.php';
        exit;
    }

    private function stockerJoueur() {
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
        $this->afficherListeJoueur();
    }

    private function afficherModifierJoueur() {
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

    private function updateJoueur() {
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
        $this->afficherListeJoueur();
    }

    private function deleteJoueur() {
        if (!isset($_GET['id'])) {
            $this->afficherListeJoueur();
        }

        $this->joueurDAO->delete($_GET['id']);
        $this->afficherListeJoueur();
    }

    private function afficherListeJoueur() {
        header('Location: ../Vue/FenetreJoueur.php');
        exit;
    }
}

$controller = new GestionFenetreJoueur();
$controller->gererAction();
