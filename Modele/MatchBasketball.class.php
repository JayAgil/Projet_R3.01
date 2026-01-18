<?php

class MatchBasketball {

    /** Date du match */
    private $dateDeMatch;

    /** Heure du match */
    private $heureDeMatch;

    /** Nom de l'équipe adverse */
    private $nomEquipeAdversaire;

    /** Lieu de la rencontre */
    private $lieuDeRencontre;

    /** Résultat du match (victoire, défaite, nul, score, etc.) */
    private $resultat;

    /** Nombre de points marqués par l'équipe adverse */
    private $pointMarquesParAdversaire;

    /** Statut du match (prévu, en cours, terminé, annulé, etc.) */
    private $statut;

    /**
     * Constructeur de la classe MatchBasketball
     *
     * @param string $dateDeMatch               Date du match
     * @param string $heureDeMatch              Heure du match
     * @param string $nomEquipeAdversaire       Nom de l'équipe adverse
     * @param string $lieuDeRencontre           Lieu de la rencontre
     * @param string $resultat                  Résultat du match
     * @param int    $pointMarquesParAdversaire Points marqués par l'adversaire
     * @param string $statut                    Statut du match
     */
    public function __construct(
        $dateDeMatch,
        $heureDeMatch,
        $nomEquipeAdversaire,
        $lieuDeRencontre,
        $resultat,
        $pointMarquesParAdversaire,
        $statut
    ) {
        $this->dateDeMatch = $dateDeMatch;
        $this->heureDeMatch = $heureDeMatch;
        $this->nomEquipeAdversaire = $nomEquipeAdversaire;
        $this->lieuDeRencontre = $lieuDeRencontre;
        $this->resultat = $resultat;
        $this->pointMarquesParAdversaire = $pointMarquesParAdversaire;
        $this->statut = $statut;
    }

    /**
     * Retourne la date du match
     *
     * @return string
     */
    public function getDateDeMatch() {
        return $this->dateDeMatch;
    }

    /**
     * Retourne l'heure du match
     *
     * @return string
     */
    public function getHeureDeMatch() {
        return $this->heureDeMatch;
    }

    /**
     * Retourne le nom de l'équipe adverse
     *
     * @return string
     */
    public function getNomEquipeAdversaire() {
        return $this->nomEquipeAdversaire;
    }

    /**
     * Retourne le lieu de la rencontre
     *
     * @return string
     */
    public function getLieuDeRencontre() {
        return $this->lieuDeRencontre;
    }

    /**
     * Retourne le résultat du match
     *
     * @return string
     */
    public function getResultat() {
        return $this->resultat;
    }

    /**
     * Retourne le nombre de points marqués par l'équipe adverse
     *
     * @return int
     */
    public function getPointMarquesParAdversaire() {
        return $this->pointMarquesParAdversaire;
    }

    /**
     * Retourne le statut du match
     *
     * @return string
     */
    public function getStatut() {
        return $this->statut;
    }

    /**
     * Modifie la date du match
     *
     * @param string $dateDeMatch
     */
    public function setDateDeMatch($dateDeMatch) {
        $this->dateDeMatch = $dateDeMatch;
    }

    /**
     * Modifie l'heure du match
     *
     * @param string $heureDeMatch
     */
    public function setHeureDeMatch($heureDeMatch) {
        $this->heureDeMatch = $heureDeMatch;
    }

    /**
     * Modifie le nom de l'équipe adverse
     *
     * @param string $nomEquipeAdversaire
     */
    public function setNomEquipeAdversaire($nomEquipeAdversaire) {
        $this->nomEquipeAdversaire = $nomEquipeAdversaire;
    }

    /**
     * Modifie le lieu de la rencontre
     *
     * @param string $lieuDeRencontre
     */
    public function setLieuDeRencontre($lieuDeRencontre) {
        $this->lieuDeRencontre = $lieuDeRencontre;
    }

    /**
     * Modifie le résultat du match
     *
     * @param string $resultat
     */
    public function setResultat($resultat) {
        $this->resultat = $resultat;
    }

    /**
     * Modifie le nombre de points marqués par l'équipe adverse
     *
     * @param int $pointMarquesParAdversaire
     */
    public function setPointMarquesParAdversaire($pointMarquesParAdversaire) {
        $this->pointMarquesParAdversaire = $pointMarquesParAdversaire;
    }

    /**
     * Modifie le statut du match
     *
     * @param string $statut
     */
    public function setStatut($statut) {
        $this->statut = $statut;
    }
}
