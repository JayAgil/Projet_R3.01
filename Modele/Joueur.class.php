<?php

class Joueur {

    /** Numéro de licence du joueur */
    private string $numeroLicence;

    /** Nom du joueur */
    private string $nom;

    /** Prénom du joueur */
    private string $prenom;

    /** Date de naissance du joueur */
    private string $dateNaissance;

    /** Taille du joueur en centimètres */
    private int $tailleCm;

    /** Poids du joueur en kilogrammes */
    private int $poidsKg;

    /** Statut du joueur (actif, blessé, suspendu, etc.) */
    private string $statut;

    /** Commentaire libre concernant le joueur */
    private string $commentaire;

    /**
     * Constructeur de la classe Joueur
     *
     * @param string      $numeroLicence Numéro de licence du joueur
     * @param string      $nom            Nom du joueur
     * @param string      $prenom         Prénom du joueur
     * @param string      $dateNaissance  Date de naissance
     * @param int         $tailleCm       Taille en centimètres
     * @param int         $poidsKg        Poids en kilogrammes
     * @param string      $statut         Statut du joueur
     * @param string      $commentaire    Commentaire optionnel
     */
    public function __construct(
        string $numeroLicence,
        string $nom,
        string $prenom,
        string $dateNaissance,
        int $tailleCm,
        int $poidsKg,
        string $statut,
        string $commentaire
    ) {
        $this->numeroLicence = $numeroLicence;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
        $this->tailleCm = $tailleCm;
        $this->poidsKg = $poidsKg;
        $this->statut = $statut;
        $this->commentaire = $commentaire;
    }

    /**
     * Retourne le numéro de licence du joueur
     *
     * @return string
     */
    public function getNumeroLicence() {
        return $this->numeroLicence;
    }

    /**
     * Retourne le nom du joueur
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Retourne le prénom du joueur
     *
     * @return string
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * Retourne la date de naissance du joueur
     *
     * @return string
     */
    public function getDateNaissance() {
        return $this->dateNaissance;
    }

    /**
     * Retourne la taille du joueur en centimètres
     *
     * @return int
     */
    public function getTaille() {
        return $this->tailleCm;
    }

    /**
     * Retourne le poids du joueur en kilogrammes
     *
     * @return int
     */
    public function getPoids() {
        return $this->poidsKg;
    }

    /**
     * Retourne le statut du joueur
     *
     * @return string
     */
    public function getStatut() {
        return $this->statut;
    }

    /**
     * Retourne le commentaire associé au joueur
     *
     * @return string
     */
    public function getCommentaire() {
        return $this->commentaire;
    }

    /**
     * Modifie le numéro de licence du joueur
     *
     * @param string $numeroLicence
     */
    public function setNumeroLicence(string $numeroLicence) {
        $this->numeroLicence = $numeroLicence;
    }

    /**
     * Modifie le nom du joueur
     *
     * @param string $nom
     */
    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    /**
     * Modifie le prénom du joueur
     *
     * @param string $prenom
     */
    public function setPrenom(string $prenom) {
        $this->prenom = $prenom;
    }

    /**
     * Modifie la date de naissance du joueur
     *
     * @param string $dateNaissance
     */
    public function setDateNaissance(string $dateNaissance) {
        $this->dateNaissance = $dateNaissance;
    }

    /**
     * Modifie la taille du joueur en centimètres
     *
     * @param int $tailleCm
     */
    public function setTaille(int $tailleCm) {
        $this->tailleCm = $tailleCm;
    }

    /**
     * Modifie le poids du joueur en kilogrammes
     *
     * @param int $poidsKg
     */
    public function setPoids(int $poidsKg) {
        $this->poidsKg = $poidsKg;
    }

    /**
     * Modifie le statut du joueur
     *
     * @param string $statut
     */
    public function setStatut(string $statut) {
        $this->statut = $statut;
    }

    /**
     * Modifie le commentaire associé au joueur
     *
     * @param string $commentaire
     */
    public function setCommentaire(string $commentaire) {
        $this->commentaire = $commentaire;
    }

}
