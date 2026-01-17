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
            ':t'  => $j->getTaille(),      
            ':pd' => $j->getPoids(),      
            ':s'  => $j->getStatut(),
            ':c'  => $j->getCommentaire()
        ]);
    }

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

    public function delete(string $numeroLicence): void {
        $stmt = $this->pdo->prepare(
            "DELETE FROM Joueur WHERE NumeroLicence = :nl"
        );
        $stmt->execute([':nl' => $numeroLicence]);
    }

    public function getAll(): array {
        return $this->pdo
            ->query("SELECT * FROM Joueur")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

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

public function getActivePlayers() {
    try {
        $sql = "SELECT * FROM Joueur WHERE Statut = 'Actif' ORDER BY Nom, Prenom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error in getActivePlayers: " . $e->getMessage());
        return [];
    }
}

public function getStatistiques($numeroLicence) {
    $req = $this->pdo->prepare("
        SELECT 
            j.Statut,
            j.Prenom as PostePreferere,
            COUNT(CASE WHEN p.EstTitulaire = 1 THEN 1 END) as selections_titulaire,
            COUNT(CASE WHEN p.EstTitulaire = 0 THEN 1 END) as selections_remplacant,
            AVG(p.Note) as moyenne_evaluation,
            COUNT(p.NumeroLicence) as total_matchs,
            SUM(CASE WHEN m.Resultat = 'Victoire' THEN 1 ELSE 0 END) as victoires
        FROM joueur j
        LEFT JOIN participer p ON j.NumeroLicence = p.NumeroLicence
        LEFT JOIN match_basketball m ON p.MatchID = m.MatchID
        WHERE j.NumeroLicence = :licence
        GROUP BY j.NumeroLicence, j.Statut, j.Prenom
    ");
    
    $req->execute([':licence' => $numeroLicence]);
    $result = $req->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        return [
            'selections_titulaire' => 0,
            'selections_remplacant' => 0,
            'moyenne_evaluation' => 0,
            'pourcentage_victoires' => 0,
            'selections_consecutives' => 0,
            'PostePreferere' => 'N/A',
            'PosteOccupee' => 'N/A'
        ];
    }
    
    $pourcentageVictoires = $result['total_matchs'] > 0 
        ? round(($result['victoires'] / $result['total_matchs']) * 100, 1)
        : 0;
    
    $reqPoste = $this->pdo->prepare("
        SELECT PosteOccupee, COUNT(*) as freq
        FROM participer
        WHERE NumeroLicence = :licence
        AND PosteOccupee IS NOT NULL
        GROUP BY PosteOccupee
        ORDER BY freq DESC
        LIMIT 1
    ");
    $reqPoste->execute([':licence' => $numeroLicence]);
    $poste = $reqPoste->fetch(PDO::FETCH_ASSOC);
    $posteOccupee = $poste ? $poste['PosteOccupee'] : 'N/A';
    
    $reqConsecutive = $this->pdo->prepare("
        SELECT COUNT(*) as consecutives
        FROM (
            SELECT m.MatchID
            FROM match_basketball m
            WHERE m.DateDeMatch <= CURDATE()
            ORDER BY m.DateDeMatch DESC, m.HeureDeMatch DESC
            LIMIT 10
        ) recent_matches
        INNER JOIN participer p ON recent_matches.MatchID = p.MatchID
        WHERE p.NumeroLicence = :licence
        AND p.Joue = 1
    ");
    
    $reqConsecutive->execute([':licence' => $numeroLicence]);
    $consecutive = $reqConsecutive->fetch(PDO::FETCH_ASSOC)['consecutives'] ?? 0;
    
    return [
        'selections_titulaire' => (int)$result['selections_titulaire'],
        'selections_remplacant' => (int)$result['selections_remplacant'],
        'moyenne_evaluation' => $result['moyenne_evaluation'] ? round($result['moyenne_evaluation'], 2) : 0,
        'pourcentage_victoires' => $pourcentageVictoires,
        'selections_consecutives' => $consecutive,
        'PostePreferere' => $posteOccupee
    ];
}


}
