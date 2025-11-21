<?php
class participer {
    require_once "database.php";

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

    public static function getAll() {
        $pdo = Database::connect();
        $stmt = $pdo->query("SELECT * FROM Participer");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save() {
        $pdo = Database::connect();
        $sql = "INSERT INTO Participer VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $this->numero_licence, $this->date_match, $this->heure_match,
            $this->note, $this->nb_points, $this->poste,
            $this->est_titulaire, $this->commentaire, $this->joue
        ]);
    }


}
?>