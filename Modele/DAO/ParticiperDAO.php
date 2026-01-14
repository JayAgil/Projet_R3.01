<?php
class ParticiperDAO {
    private $pdo;

    public function __construct() {
        try {
            $db = 'r301php2025_db';
            $server = 'localhost';
            $login = 'root';
            $mdp = '';
            $this->pdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp); 
            // Good practice: set error mode to exceptions
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    

    public function insertParticiper(Participer $p) {
        $sql = "INSERT INTO Participer 
                (NumeroLicence, DateDeMatch, HeureDeMatch, Note, NbPointsMarque, PosteOccupee, EstTitulaire, Commentaire, Joue)
                VALUES (:NumeroLicence, :DateDeMatch, :HeureDeMatch, :Note, :NbPointsMarque, :PosteOccupee, :EstTitulaire, :Commentaire, :Joue)";
        
        $stmt = $this->pdo->prepare($sql);
        $this->bindParticiper($stmt, $p);
        return $stmt->execute();
    }

    public function deleteParticiper(string $numeroLicence, string $dateDeMatch, string $heureDeMatch) {
        $sql = "DELETE FROM Participer 
                WHERE NumeroLicence = :NumeroLicence
                AND DateDeMatch = :DateDeMatch
                AND HeureDeMatch = :HeureDeMatch";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':NumeroLicence', $numeroLicence);
        $stmt->bindValue(':DateDeMatch', $dateDeMatch);
        $stmt->bindValue(':HeureDeMatch', $heureDeMatch);

        return $stmt->execute();
    }

    public function updateParticiper(Participer $p) {
        $sql = "UPDATE Participer SET
                    Note = :Note,
                    NbPointsMarque = :NbPointsMarque,
                    PosteOccupee = :PosteOccupee,
                    EstTitulaire = :EstTitulaire,
                    Commentaire = :Commentaire,
                    Joue = :Joue
                WHERE NumeroLicence = :NumeroLicence
                AND DateDeMatch = :DateDeMatch
                AND HeureDeMatch = :HeureDeMatch";

        $stmt = $this->pdo->prepare($sql);
        $this->bindParticiper($stmt, $p);
        return $stmt->execute();
    }

    public function getJoueurQuiJoue(string $date, string $heure) {
        $sql = "SELECT * FROM Participer 
                WHERE DateDeMatch = :d 
                AND HeureDeMatch = :h 
                AND Joue = 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':d' => $date, ':h' => $heure]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRangJoueurPoints(): array {
        $sql = "SELECT NumeroLicence, SUM(NbPointsMarque) AS totalPoints
                FROM Participer
                GROUP BY NumeroLicence
                ORDER BY totalPoints DESC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    private function bindParticiper(PDOStatement $stmt, Participer $p) {
        $stmt->bindValue(':NumeroLicence', $p->NumeroLicence);
        $stmt->bindValue(':DateDeMatch', $p->DateDeMatch);
        $stmt->bindValue(':HeureDeMatch', $p->HeureDeMatch);
        $stmt->bindValue(':Note', $p->Note);
        $stmt->bindValue(':NbPointsMarque', $p->NbPointsMarque);
        $stmt->bindValue(':PosteOccupee', $p->PosteOccupee);
        $stmt->bindValue(':EstTitulaire', $p->EstTitulaire, PDO::PARAM_INT);
        $stmt->bindValue(':Commentaire', $p->Commentaire);
        $stmt->bindValue(':Joue', $p->Joue, PDO::PARAM_INT);
    }

    public function insertParticipationSimple(
    string $numeroLicence,
    int $matchID,
    int $points,
    int $titulaire,
    int $joue,
    ?float $note
): bool {
    $stmt = $this->pdo->prepare("
        INSERT INTO Participer
        (NumeroLicence, MatchID, NbPointsMarque, EstTitulaire, Joue, Note)
        VALUES (:nl, :mid, :pts, :tit, :joue, :note)
    ");

    return $stmt->execute([
        ':nl'   => $numeroLicence,
        ':mid'  => $matchID,
        ':pts'  => $points,
        ':tit'  => $titulaire,
        ':joue' => $joue,
        ':note' => $note
    ]);
}

public function getJoueursParMatch(int $matchID): array {
    $stmt = $this->pdo->prepare("
        SELECT j.*
        FROM Joueur j
        JOIN Participer p ON j.NumeroLicence = p.NumeroLicence
        WHERE p.MatchID = :matchID
        ORDER BY j.Nom
    ");
    $stmt->execute([':matchID' => $matchID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getExistingPlayers($matchId) {
    // We now filter by matchId only
    $sql = "SELECT NumeroLicence, PosteOccupee, EstTitulaire 
            FROM Participer 
            WHERE matchId = ?"; 
            
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$matchId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function saveMatchSheet($matchId, $titulars, $substitutes) {
    try {
        $this->pdo->beginTransaction();

        // Remove old sheet for this match
        $stmt = $this->pdo->prepare("DELETE FROM Participer WHERE MatchID = ?");
        $stmt->execute([$matchId]);

        // Insert new sheet
        $sql = "INSERT INTO Participer (NumeroLicence, MatchID, PosteOccupee, EstTitulaire, Joue) VALUES (?, ?, ?, ?, 1)";
        $stmt = $this->pdo->prepare($sql);

        // Titulars
        foreach ($titulars as $pos => $licence) {
            $stmt->execute([$licence, $matchId, $pos, 1]);
        }

        // Substitutes
        foreach ($substitutes as $sub) {
            $stmt->execute([$sub['licence'], $matchId, $sub['pos'], 0]);
        }

        $this->pdo->commit();
        return true;
    } catch (Exception $e) {
        $this->pdo->rollBack();
        return false;
    }

}

    
}
?>