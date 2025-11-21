<?php
    class MatchBasketball {
        private $dateDeMatch ;
        private $heureDeMatch ;
        private $nomEquipeAdversaire;
        private $lieuDeRencontre;
        private $resultat;
        private $pointMarquesParAdversaire;
        private $statut;
    

    public function __construct ($dateDeMatch,$heureDeMatch,$nomEquipeAdversaire,$lieuDeRencontre,$resultat,$pointMarquesParAdversaire,$statut){
        $this->dateDeMatch = $dateDeMatch;
        $this->heureDeMatch = $heureDeMatch;
        $this->nomEquipeAdversaire = $nomEquipeAdversaire;
        $this->lieuDeRencontre = $lieuDeRencontre;
        $this->resultat = $resultat;
        $this->pointMarquesParAdversaire = $pointMarquesParAdversaire;
        $this->statut = $statut;
    }

    public function getDateDeMatch() {
        return $this->dateDeMatch;
    }

    public function getHeureDeMatch() {
        return $this->heureDeMatch;
    }

    public function getNomEquipeAdversaire() {
        return $this->nomEquipeAdversaire;
    }

    public function getLieuDeRencontre() {
        return $this->lieuDeRencontre;
    }

    public function getResultat() {
        return $this->resultat;
    }

    public function getPointMarquesParAdversaire() {
        return $this->pointMarquesParAdversaire;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setDateDeMatch($dateDeMatch) {
        $this->dateDeMatch = $dateDeMatch;
    }

    public function setHeureDeMatch($heureDeMatch) {
        $this->heureDeMatch = $heureDeMatch;
    }

    public function setNomEquipeAdversaire($nomEquipeAdversaire) {
        $this->nomEquipeAdversaire = $nomEquipeAdversaire;
    }

    public function setLieuDeRencontre($lieuDeRencontre) {
        $this->lieuDeRencontre = $lieuDeRencontre;
    }

    public function setResultat($resultat) {
        $this->resultat = $resultat;
    }

    public function setPointMarquesParAdversaire($pointMarquesParAdversaire) {
        $this->pointMarquesParAdversaire = $pointMarquesParAdversaire;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }


}