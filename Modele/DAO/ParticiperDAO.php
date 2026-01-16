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
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Updated: Now uses MatchID to find players who played
     */
    public function getJoueurQuiJoue(string $matchId) {
        $sql = "SELECT * FROM Participer 
                WHERE MatchID = :mid 
                AND Joue = 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':mid' => $matchId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Updated: Deletes based on MatchID
     */
    public function deleteParticiper(string $numeroLicence, string $matchId) {
        $sql = "DELETE FROM Participer 
                WHERE NumeroLicence = :NumeroLicence
                AND MatchID = :MatchID";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':NumeroLicence', $numeroLicence);
        $stmt->bindValue(':MatchID', $matchId);

        return $stmt->execute();
    }

    /**
     * Logic for Feuille de Match: Pre-filling the combo boxes
     */
    public function getExistingPlayers($matchId) {
        $sql = "SELECT NumeroLicence, PosteOccupee, EstTitulaire 
                FROM Participer 
                WHERE MatchID = ?"; 
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$matchId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Logic for Feuille de Match: Saving and Redirecting
     */
    public function saveMatchSheet($matchId, $titulars, $substitutes) {
        try {
            $this->pdo->beginTransaction();

            // 1. Remove old sheet for this match to allow updates
            $stmt = $this->pdo->prepare("DELETE FROM Participer WHERE MatchID = ?");
            $stmt->execute([$matchId]);

            // 2. Insert new sheet
            $sql = "INSERT INTO Participer (NumeroLicence, MatchID, PosteOccupee, EstTitulaire, Joue) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);

            // Insert Titulars (Joue = 1)
            foreach ($titulars as $pos => $licence) {
                if(!empty($licence)) {
                    $stmt->execute([$licence, $matchId, $pos, 1, 1]);
                }
            }

            // Insert Substitutes (Joue = 0 or 1 depending on coach choice, here 0 for "on bench")
            foreach ($substitutes as $sub) {
                if(!empty($sub['licence'])) {
                    $stmt->execute([$sub['licence'], $matchId, $sub['pos'], 0, 1]);
                }
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function getRangJoueurPoints(): array {
        $sql = "SELECT NumeroLicence, SUM(NbPointsMarque) AS totalPoints
                FROM Participer
                GROUP BY NumeroLicence
                ORDER BY totalPoints DESC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>