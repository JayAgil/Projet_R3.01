<?php
class participer {
    private $numero_licence;
    private $date_match;
    private $heure_match;
    private $note;
    private $nb_points_marque;
    private $poste_occupee;
    private $est_titulaire;
    private $commentaire;
    private $joue;

    public function __construct($numero_licence,$date_match,$heure_match,$note,$nb_points_marque,$poste_occupee,$est_titulaire,$commentaire,$joue) {
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

    public function getNumeroLicence() {
        return $this->numero_licence;
    }

    public function getDateMatch() {
        return $this->date_match;
    }

    public function getHeureMatch() {
        return $this->heure_match;
    }

    public function getNote() {
        return $this->note;
    }

    public function getNbPointsMarque() {
        return $this->nb_points_marque;
    }

    public function getPosteOccupee() {
        return $this->poste_occupee;
    }

    public function getEstTitulaire() {
        return $this->est_titulaire;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function getJoue() {
        return $this->joue;
    }
    
    public function setNumeroLicence($numero_licence) {
        $this->numero_licence = $numero_licence;
    }

    public function setDateMatch($date_match) {
        $this->date_match = $date_match;
    }

    public function setHeureMatch($heure_match) {
        $this->heure_match = $heure_match;
    }

    public function setNote($note) {
        $this->note = $note;
    }

    public function setNbPointsMarque($nb_points_marque) {
        $this->nb_points_marque = $nb_points_marque;
    }

    public function setPosteOccupee($poste_occupee) {
        $this->poste_occupee = $poste_occupee;
    }

    public function setEstTitulaire($est_titulaire) {
        $this->est_titulaire = $est_titulaire;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    public function setJoue($joue) {
        $this->joue = $joue;
    }


}
?>