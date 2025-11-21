<?php
class joueur {

    private $numero_licence;
    private $statut;
    private $commentaire;
    private $nom;
    private $prenom;
    private $date_naissance;
    private $taille;
    private $poids;

    public function __construct($numero_licence, $statut, $commentaire, $nom, $prenom, $date_naissance, $taille,$poids) {
        $this->numero_licence = $numero_licence;
        $this->statut = $statut;
        $this->commentaire = $commentaire;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->taille = $taille;
        $this->poids = $poids;
    }

    public function getNumeroLicence() {
        return $this->numero_licence;
    }

    public function setNumeroLicence($n) {
        $this->numero_licence = $n;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setStatut($s) {
        $this->statut = $s;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function setCommentaire($c) {
        $this->commentaire = $c;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($n) {
        $this->nom = $n;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($p) {
        $this->prenom = $p;
    }

    public function getDateNaissance() {
        return $this->date_naissance;
    }

    public function setDateNaissance($d) {
        $this->date_naissance = $d;
    }

    public function getTaille() {
        return $this->taille."cm";
    }

    public function setTaille($t) {
        $this->taille = $t;
    }

    public function getPoids() {
        return $this->poids;
    }

    public function setPoids($p) {
        $this->poids = $p."kg";
    }

}
?>