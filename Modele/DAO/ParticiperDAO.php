<?php
class ParticiperDAO {
    private $pdo;
    
    /**
     * Connecter à la BD avec PDO
     */
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
     * Récupère les joueurs qui ont effectivement joué un match donné
     * (Joue = 1), en se basant sur l'identifiant du match.
     *
     * @param string $matchId Identifiant du match
     * @return array Liste des participations des joueurs ayant joué
     */
    public function getJoueurQuiJoue(string $matchId) {
        $sql = "SELECT * FROM participer 
                WHERE MatchID = :mid 
                AND Joue = 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':mid' => $matchId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Supprime la participation d’un joueur à un match donné.
     * Utilisé par exemple lorsqu’un joueur est retiré de la feuille de match.
     *
     * @param string $numeroLicence Numéro de licence du joueur
     * @param string $matchId Identifiant du match
     * @return bool true si la suppression a réussi
     */
    public function deleteParticiper(string $numeroLicence, string $matchId) {
        $sql = "DELETE FROM participer 
                WHERE NumeroLicence = :NumeroLicence
                AND MatchID = :MatchID";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':NumeroLicence', $numeroLicence);
        $stmt->bindValue(':MatchID', $matchId);

        return $stmt->execute();
    }


    /**
     * Récupère les joueurs déjà enregistrés pour un match
     * afin de pré-remplir la feuille de match (postes et titulaires).
     *
     * @param string $matchId Identifiant du match
     * @return array Liste des joueurs avec leur poste et statut
     */
    public function getExistingPlayers($matchId) {
        $sql = "SELECT NumeroLicence, PosteOccupee, EstTitulaire 
                FROM participer 
                WHERE MatchID = ?"; 
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$matchId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Sauvegarde complète de la feuille de match.
     * - Supprime les anciennes participations
     * - Insère les titulaires et les remplaçants
     * - Utilise une transaction pour garantir l'intégrité des données
     *
     * @param string $matchId Identifiant du match
     * @param array $titulars Joueurs titulaires (poste => licence)
     * @param array $substitutes Joueurs remplaçants
     * @return bool true si la sauvegarde a réussi
     */
    public function saveMatchSheet($matchId, $titulars, $substitutes) {
        try {
            // Démarrage de la transaction
            $this->pdo->beginTransaction();

            // Suppression des anciennes participations du match
            $delete = $this->pdo->prepare("DELETE FROM participer WHERE MatchID = ?");
            $delete->execute([$matchId]);

            // Préparation de la requête d'insertion
            $sql = "INSERT INTO participer 
                    (NumeroLicence, MatchID, PosteOccupee, EstTitulaire, Joue) 
                    VALUES (?, ?, ?, ?, 1)";
            $stmt = $this->pdo->prepare($sql);

            // Insertion des 5 titulaires
            foreach ($titulars as $posCode => $licence) {
                $stmt->execute([$licence, $matchId, $posCode, 1]);
            }

            // Insertion des remplaçants
            foreach ($substitutes as $sub) {
                $stmt->execute([$sub['licence'], $matchId, $sub['pos'], 0]);
            }

            // Validation de la transaction
            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            // Annulation en cas d’erreur
            $this->pdo->rollBack();
            return false;
        }
    }


    /**
     * Classement des joueurs en fonction du nombre total de points marqués.
     *
     * @return array Liste des joueurs classés par points décroissants
     */
    public function getRangJoueurPoints(): array {
        $sql = "SELECT NumeroLicence, SUM(NbPointsMarque) AS totalPoints
                FROM participer
                GROUP BY NumeroLicence
                ORDER BY totalPoints DESC";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Récupère la liste des joueurs ayant participé à un match
     * avec leurs informations principales et leur poste.
     *
     * @param string $matchId Identifiant du match
     * @return array Liste des joueurs du match
     */
    public function getJoueursParMatch($matchId) {
        $sql = "SELECT Joueur.NumeroLicence, Joueur.Nom, Joueur.Prenom, Participer.PosteOccupee 
                FROM joueur, participer
                WHERE Joueur.NumeroLicence = Participer.NumeroLicence 
                AND Participer.MatchID = :mid";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':mid' => $matchId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Récupère la dernière note attribuée à un joueur,
     * basée sur le match le plus récent.
     *
     * @param string $numeroLicence Numéro de licence du joueur
     * @return int Dernière note ou null si aucune note n'existe
     */
    public function getLastNoteByPlayer($numeroLicence) {
        $sql = "SELECT p.Note
                FROM participer p
                JOIN match_basketball m ON p.MatchID = m.MatchID
                WHERE p.NumeroLicence = :num
                AND p.Note IS NOT NULL
                ORDER BY m.DateDeMatch DESC, m.HeureDeMatch DESC
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':num' => $numeroLicence]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retourne null si aucune note n’a été trouvée
        return $row['Note'] ?? null;
    }


}
?>