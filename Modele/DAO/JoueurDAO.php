<?php
require_once __DIR__ . '/../Joueur.class.php';

class JoueurDAO {

    private PDO $pdo;

    public function __construct() {
        try {
            $db     = 'r301php2025_db';
            $server = 'localhost';
            $login  = 'root';
            $mdp    = '';

            $this->pdo = new PDO(
                "mysql:host=$server;dbname=$db;charset=utf8",
                $login,
                $mdp,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    // ----------------------------
    // INSERT
    // ----------------------------
    public function insert(Joueur $j): void {
        $sql = "
            INSERT INTO Joueur (
                NumeroLicence,
                Nom,
                Prenom,
                DateDeNaissance,
                Taille_cm,
                Poids_kg,
                Statut,
                Commentaire
            ) VALUES (
                :nl,
                :n,
                :p,
                :dn,
                :t,
                :pd,
                :s,
                :c
            )
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nl' => $j->getNumeroLicence(),
            ':n'  => $j->getNom(),
            ':p'  => $j->getPrenom(),
            ':dn' => $j->getDateNaissance(),
            ':t'  => $j->getTaille(),      // or getTailleCm()
            ':pd' => $j->getPoids(),       // or getPoidsKg()
            ':s'  => $j->getStatut(),
            ':c'  => $j->getCommentaire()
        ]);
    }

    // ----------------------------
    // UPDATE
    // ----------------------------
    public function update(Joueur $j): void {
        $sql = "
            UPDATE Joueur
            SET
                Nom = :n,
                Prenom = :p,
                DateDeNaissance = :dn,
                Taille_cm = :t,
                Poids_kg = :pd,
                Statut = :s,
                Commentaire = :c
            WHERE NumeroLicence = :nl
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nl' => $j->getNumeroLicence(),
            ':n'  => $j->getNom(),
            ':p'  => $j->getPrenom(),
            ':dn' => $j->getDateNaissance(),
            ':t'  => $j->getTaille(),
            ':pd' => $j->getPoids(),
            ':s'  => $j->getStatut(),
            ':c'  => $j->getCommentaire()
        ]);
    }

    // ----------------------------
    // DELETE
    // ----------------------------
    public function delete(string $numeroLicence): void {
        $stmt = $this->pdo->prepare(
            "DELETE FROM Joueur WHERE NumeroLicence = :nl"
        );
        $stmt->execute([':nl' => $numeroLicence]);
    }

    // ----------------------------
    // GET ALL
    // ----------------------------
    public function getAll(): array {
        return $this->pdo
            ->query("SELECT * FROM Joueur")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    // ----------------------------
    // SEARCH
    // ----------------------------
    public function search(string $term): array {
        $stmt = $this->pdo->prepare("
            SELECT * FROM Joueur
            WHERE Nom LIKE :term
               OR Prenom LIKE :term
               OR NumeroLicence LIKE :term
               OR Statut LIKE :term
        ");
        $stmt->execute([':term' => "%$term%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ----------------------------
    // GET BY ID
    // ----------------------------
    public function getById(string $numeroLicence): ?Joueur {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Joueur WHERE NumeroLicence = ?"
        );
        $stmt->execute([$numeroLicence]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        return new Joueur(
            $data['NumeroLicence'],
            $data['Nom'],
            $data['Prenom'],
            $data['DateDeNaissance'],
            $data['Taille_cm'],
            $data['Poids_kg'],
            $data['Statut'],
            $data['Commentaire']
        );
    }
}
