<?php
require_once __DIR__ . '/../Joueur.class.php';
require_once __DIR__ . '/../MatchBasketball.class.php';
require_once __DIR__ . '/../Participer.class.php';

class JoueurDAO {

    private PDO $pdo;

    public function __construct() {
        try {
            $db     = 'r301php2025_db';
            $server = 'localhost';
            $login  = 'root';
            $mdp    = '';
            $this->pdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $login, $mdp);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    public function insert(Joueur $j): void {
        $sql = "INSERT INTO Joueur (NumeroLicence, Statut, Commentaire, Nom, Prenom, DateDeNaissance, Taille_cm, Poids_kg)
                VALUES (:nl, :s, :c, :n, :p, :dn, :t, :pd)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nl' => $j->numero_licence,
            ':s'  => $j->statut,
            ':c'  => $j->commentaire,
            ':n'  => $j->nom,
            ':p'  => $j->prenom,
            ':dn' => $j->date_naissance,
            ':t'  => $j->taille,
            ':pd' => $j->poids
        ]);
    }

    public function delete(string $numeroLicence): void {
        $sql = "DELETE FROM Joueur WHERE NumeroLicence = :nl";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nl' => $numeroLicence]);
    }

    public function update(Joueur $j): void {
        $sql = "UPDATE Joueur 
                SET Statut = :s, Commentaire = :c, Nom = :n, Prenom = :p, DateDeNaissance = :dn, Taille_cm = :t, Poids_kg = :pd
                WHERE NumeroLicence = :nl";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':s'  => $j->statut,
            ':c'  => $j->commentaire,
            ':n'  => $j->nom,
            ':p'  => $j->prenom,
            ':dn' => $j->date_naissance,
            ':t'  => $j->taille,
            ':pd' => $j->poids,
            ':nl' => $j->numero_licence
        ]);
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM Joueur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search(string $term): array {
        $sql = "SELECT * FROM Joueur
                WHERE Nom LIKE :term
                   OR Prenom LIKE :term
                   OR NumeroLicence LIKE :term
                   OR Statut LIKE :term";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':term' => "%$term%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTop10Taille(): array {
        $stmt = $this->pdo->query("SELECT Nom, Prenom, Taille_cm FROM Joueur ORDER BY Taille_cm DESC LIMIT 10");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTop10Poids(): array {
        $stmt = $this->pdo->query("SELECT Nom, Prenom, Poids_kg FROM Joueur ORDER BY Poids_kg DESC LIMIT 10");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlayersByStatut(): array {
        $stmt = $this->pdo->query("SELECT Statut, COUNT(*) AS nb_players FROM Joueur GROUP BY Statut");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivePlayers(): array {
        $stmt = $this->pdo->query("SELECT * FROM Joueur WHERE Statut = 'Actif'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInactivePlayers(): array {
        $stmt = $this->pdo->query("SELECT * FROM Joueur WHERE Statut != 'Actif'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPoints(string $numeroLicence): int {
        $stmt = $this->pdo->prepare("SELECT SUM(NbPointsMarque) AS TotalPoints
                                     FROM Participer
                                     WHERE NumeroLicence = :nl AND Joue = TRUE");
        $stmt->execute([':nl' => $numeroLicence]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['TotalPoints'] ?? 0;
    }

    public function getNombreMatchsJoues(string $numeroLicence): int {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS Nombre
                                     FROM Participer
                                     WHERE NumeroLicence = :nl AND Joue = TRUE");
        $stmt->execute([':nl' => $numeroLicence]);
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['Nombre'] ?? 0;
    }

}
?>
