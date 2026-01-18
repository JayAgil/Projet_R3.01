<?php

class Participer {

    /** Numéro de licence du joueur */
    private $numero_licence;

    /** Date du match */
    private $date_match;

    /** Heure du match */
    private $heure_match;

    /** Note attribuée au joueur pour le match */
    private $note;

    /** Nombre de points marqués par le joueur */
    private $nb_points_marque;

    /** Poste occupé par le joueur pendant le match */
    private $poste_occupee;

    /** @Indique si le joueur est titulaire */
    private $est_titulaire;

    /** Commentaire sur la prestation du joueur */
    private $commentaire;

    /** Indique si le joueur a effectivement joué le match */
    private $joue;

    /**
     * Constructeur de la classe Participer
     *
     * @param string $numero_licence     Numéro de licence du joueur
     * @param string $date_match         Date du match
     * @param string $heure_match        Heure du match
     * @param float  $note               Note du joueur
     * @param int    $nb_points_marque   Points marqués par le joueur
     * @param string $poste_occupee      Poste occupé
     * @param bool   $est_titulaire      Statut de titulaire
     * @param string $commentaire        Commentaire sur le joueur
     * @param bool   $joue               Indique si le joueur a joué
     */
    public function __construct(
        $numero_licence,
        $date_match,
        $heure_match,
        $note,
        $nb_points_marque,
        $poste_occupee,
        $est_titulaire,
        $commentaire,
        $joue
    ) {
        $this->numero_licence = $numero_licence;
        $this->date_match = $date_match;
        $this->heure_match = $heure_match;
        $this->note = $note;
        $this->nb_points_marque = $nb_points_marque;
        $this->poste_occupee = $poste_occupee;
        $this->est_titulaire = $est_titulaire;
        $this->commentaire = $commentaire;
        $this->joue = $joue;
    }

    /**
     * Retourne le numéro de licence du joueur
     *
     * @return string
     */
    public function getNumeroLicence() {
        return $this->numero_licence;
    }

    /**
     * Retourne la date du match
     *
     * @return string
     */
    public function getDateMatch() {
        return $this->date_match;
    }

    /**
     * Retourne l'heure du match
     *
     * @return string
     */
    public function getHeureMatch() {
        return $this->heure_match;
    }

    /**
     * Retourne la note du joueur
     *
     * @return float
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Retourne le nombre de points marqués
     *
     * @return int
     */
    public function getNbPointsMarque() {
        return $this->nb_points_marque;
    }

    /**
     * Retourne le poste occupé par le joueur
     *
     * @return string
     */
    public function getPosteOccupee() {
        return $this->poste_occupee;
    }

    /**
     * Indique si le joueur est titulaire
     *
     * @return bool
     */
    public function getEstTitulaire() {
        return $this->est_titulaire;
    }

    /**
     * Retourne le commentaire sur le joueur
     *
     * @return string
     */
    public function getCommentaire() {
        return $this->commentaire;
    }

    /**
     * Indique si le joueur a joué le match
     *
     * @return bool
     */
    public function getJoue() {
        return $this->joue;
    }

    /**
     * Modifie le numéro de licence
     *
     * @param string $numero_licence
     */
    public function setNumeroLicence($numero_licence) {
        $this->numero_licence = $numero_licence;
    }

    /**
     * Modifie la date du match
     *
     * @param string $date_match
     */
    public function setDateMatch($date_match) {
        $this->date_match = $date_match;
    }

    /**
     * Modifie l'heure du match
     *
     * @param string $heure_match
     */
    public function setHeureMatch($heure_match) {
        $this->heure_match = $heure_match;
    }

    /**
     * Modifie la note du joueur
     *
     * @param float $note
     */
    public function setNote($note) {
        $this->note = $note;
    }

    /**
     * Modifie le nombre de points marqués
     *
     * @param int $nb_points_marque
     */
    public function setNbPointsMarque($nb_points_marque) {
        $this->nb_points_marque = $nb_points_marque;
    }

    /**
     * Modifie le poste occupé
     *
     * @param string $poste_occupee
     */
    public function setPosteOccupee($poste_occupee) {
        $this->poste_occupee = $poste_occupee;
    }

    /**
     * Modifie le statut de titulaire
     *
     * @param bool $est_titulaire
     */
    public function setEstTitulaire($est_titulaire) {
        $this->est_titulaire = $est_titulaire;
    }

    /**
     * Modifie le commentaire
     *
     * @param string $commentaire
     */
    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    /**
     * Modifie l'indication de participation au match
     *
     * @param bool $joue
     */
    public function setJoue($joue) {
        $this->joue = $joue;
    }
}
