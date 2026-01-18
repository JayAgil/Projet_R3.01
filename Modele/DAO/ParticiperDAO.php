<?php
class ParticiperDAO {
    private $pdo;

    public function __construct() {
        try {
            $db     = 'if0_40934572_XXX';
            $server = 'sql112.infinityfree.com';
            $login  = 'if0_40934572';
            $mdp    = 'kgZTli4UVfsK';
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

        // Step A: Wipe existing data for this match to handle the "Update" logic
        $delete = $this->pdo->prepare("DELETE FROM Participer WHERE MatchID = ?");
        $delete->execute([$matchId]);

        // Step B: Prepare the insert statement
        $sql = "INSERT INTO Participer (NumeroLicence, MatchID, PosteOccupee, EstTitulaire, Joue) 
                VALUES (?, ?, ?, ?, 1)";
        $stmt = $this->pdo->prepare($sql);

        // Step C: Insert the 5 Starters (EstTitulaire = 1)
        foreach ($titulars as $posCode => $licence) {
            $stmt->execute([$licence, $matchId, $posCode, 1]);
        }

        // Step D: Insert the Substitutes (EstTitulaire = 0)
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

    public function getRangJoueurPoints(): array {
        $sql = "SELECT NumeroLicence, SUM(NbPointsMarque) AS totalPoints
                FROM Participer
                GROUP BY NumeroLicence
                ORDER BY totalPoints DESC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJoueursParMatch($matchId) {
        $sql = "SELECT Joueur.NumeroLicence, Joueur.Nom, Joueur.Prenom, Participer.PosteOccupee 
                FROM Joueur, Participer
                WHERE Joueur.NumeroLicence = Participer.NumeroLicence 
                AND Participer.MatchID = :mid";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':mid' => $matchId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   // ParticiperDAO.php
   public function getLastNoteByPlayer($numeroLicence) {
        $sql = "SELECT p.Note
                FROM Participer p
                JOIN Match_Basketball m ON p.MatchID = m.MatchID
                WHERE p.NumeroLicence = :num
                AND p.Note IS NOT NULL
                ORDER BY m.DateDeMatch DESC, m.HeureDeMatch DESC
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':num' => $numeroLicence]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['Note'] ?? null; // return null if no note exists
    }

}
?>