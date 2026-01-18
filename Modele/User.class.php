<?php

class User {

    /** Nom d'utilisateur */
    private $user;

    /** Mot de passe de l'utilisateur */
    private $mdp;

    /**
     * Constructeur de la classe User
     *
     * @param string $user Nom d'utilisateur
     * @param string $mdp  Mot de passe
     */
    public function __construct($user, $mdp) {
        $this->user = $user;
        $this->mdp = $mdp;
    }

    /**
     * Retourne le nom d'utilisateur
     *
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Retourne le mot de passe de l'utilisateur
     *
     * @return string
     */
    public function getMdp() {
        return $this->mdp;
    }

    /**
     * Modifie le nom d'utilisateur
     *
     * @param string $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * Modifie le mot de passe de l'utilisateur
     *
     * @param string $mdp
     */
    public function setMdp($mdp) {
        $this->mdp = $mdp;
    }
}
