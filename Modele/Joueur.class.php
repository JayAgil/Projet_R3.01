<?php

class Joueur {

    private string $numeroLicence;
    private string $nom;
    private string $prenom;
    private string $dateNaissance;
    private int $tailleCm;
    private int $poidsKg;
    private string $statut;
    private string $commentaire;

    public function __construct(
        string $numeroLicence,
        string $nom,
        string $prenom,
        ?string $dateNaissance,
        ?int $tailleCm,
        ?int $poidsKg,
        ?string $statut,
        ?string $commentaire
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

    public function getNumeroLicence() {
        return $this->numeroLicence;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getDateNaissance() {
        return $this->dateNaissance;
    }

    public function getTaille() {
        return $this->tailleCm;
    }

    public function getPoids() {
        return $this->poidsKg;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }
}
