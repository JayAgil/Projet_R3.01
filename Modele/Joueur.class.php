<?php
class joueur {

    require_once "r301php2025_db";

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

    public static function getAll() {
        $pdo = Database::connect();
        $stmt = $pdo->query("SELECT * FROM Joueur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save() {
        $pdo = Database::connect();
        $sql = "INSERT INTO Joueur VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $this->numero_licence, $this->statut, $this->commentaire,
            $this->nom, $this->prenom, $this->date_naissance,
            $this->taille, $this->poids
        ]);
    }

}
?>