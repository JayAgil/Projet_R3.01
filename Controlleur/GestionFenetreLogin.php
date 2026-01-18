<?php
/**
 * Contrôleur de gestion de la fenêtre de connexion
 * Gère l'authentification des utilisateurs
 */

require_once __DIR__ . '/../Modele/DAO/UserDAO.php';

class GestionFenetreLogin {
    private $userDAO;
    private $username;
    private $mdp;
    
    /**
     * Constructeur - Initialise les informations de connexion
     * 
     */
    public function __construct($username, $mdp) {
        $this->userDAO = new UserDAO();
        $this->username = $username;
        $this->mdp = $mdp;
    }
    
    /**
     * Vérifie que l'utilisateur existe dans la base de données
     * et que le mot de passe correspond
     */
    public function executer() {
        $mdpHash = $this->userDAO->getMdpByUsername($this->username);
        return password_verify($this->mdp, $mdpHash);
    }
}
