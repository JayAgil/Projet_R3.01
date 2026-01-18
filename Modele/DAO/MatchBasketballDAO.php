<?php
    require_once __DIR__ . '/../MatchBasketball.class.php';
class MatchBasketballDAO {
    private $linkpdo;

    /**
     * Connecter à la BD avec PDO
     */
    public function __construct() {
        try {
            $db     = 'if0_40934572_XXX';
            $server = 'sql112.infinityfree.com';
            $login  = 'if0_40934572';
            $mdp    = 'kgZTli4UVfsK';
            $this->linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp); 
        }
        catch (Exception $e) {
             die('Erreur : ' . $e->getMessage()); 

        }
    }

    /**
     * Retourne le nombre de matchs selon un résultat donné
     *
     * @param string $result Résultat recherché (ex : Victoire, Défaite)
     * @return int Nombre de matchs correspondants
     */
    public function getNbMatch ($result){
        $req = $this->linkpdo->prepare('SELECT count(*) as nb from match_basketball where Resultat = :resultat');
        $req->execute(array(":resultat" => $result));
        $nb = $req->fetch(PDO::FETCH_ASSOC);
        return $nb['nb'];
    }

    /**
     * Calcule le taux de victoire de l'équipe
     *
     * @return float Pourcentage de victoires
     */
    public function getTauxDeVictoire(){
        $gagne = $this->getNbMatch("Victoire");
        $req = $this->linkpdo->query('SELECT count(*) as nb from match_basketball');
        $row = $req->fetch(PDO::FETCH_ASSOC);
        $total = $row['nb'];
        return ($gagne/$total) * 100;
    }

    /**
     * Retourne le nombre de matchs joués durant le mois en cours
     *
     * @return int Nombre de matchs du mois
     */
    public function getNbMatchCeMois(){
        $req = $this->linkpdo->prepare(
            'SELECT COUNT(*) AS nb
             FROM match_basketball
             WHERE MONTH(DateDeMatch) = MONTH(CURDATE())
             AND YEAR(DateDeMatch) = YEAR(CURDATE())'
        );    
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        return $row['nb'];
    }

    /**
     * Récupère tous les matchs sous forme d'objets MatchBasketball
     *
     * @return array Liste des matchs
     */
    public function getAllMatches(){
        $req = $this->linkpdo->query("SELECT * FROM match_basketball");
        $matches = []b
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $matches[] = new MatchBasketball(
                $row['DateDeMatch'],
                $row['HeureDeMatch'],
                $row['NomEquipeAdversaire'],
                $row['LieuDeRencontre'],
                $row['Resultat'],
                $row['PointsMarquesParAdversaire'],
                $row['Statut']
            );
        }

        return $matches;
    }

    /**
     * Insère un nouveau match dans la base de données
     *
     * @return bool Résultat de l'exécution de la requête
     */
    public function insertMatch($date, $heure, $equipe, $lieu, $resultat, $pointsAdv, $statut) {
        $req = $this->linkpdo->prepare(
            'INSERT INTO match_basketball
            (DateDeMatch, HeureDeMatch, NomEquipeAdversaire, LieuDeRencontre, Resultat, PointsMarquesParAdversaire, Statut)
            VALUES (:date, :heure, :equipe, :lieu, :resultat, :pointsAdv, :statut)'
        );
        return $req->execute(array(
            ":date"     => $date,
            ":heure"    => $heure,
            ":equipe"   => $equipe,
            ":lieu"     => $lieu,
            ":resultat" => $resultat,
            ":pointsAdv"=> $pointsAdv,
            ":statut"   => $statut
        ));
    }

    /**
     * Met à jour les informations d'un match existant
     *
     * @return bool Résultat de la mise à jour
     */
    public function updateMatch(
        $dateAncien, $heureAncien,
        $dateNouvelle, $heureNouvelle,
        $nomEquipe,
        $lieu,
        $resultat,
        $points,
        $statut
    ) {
        $sql = 'UPDATE match_basketball
                SET DateDeMatch = :newDate,
                    HeureDeMatch = :newTime,
                    NomEquipeAdversaire = :nomEquipe,
                    LieuDeRencontre = :lieu,
                    Resultat = :resultat,
                    PointsMarquesParAdversaire = :points,
                    Statut = :statut
                WHERE DateDeMatch = :oldDate
                  AND HeureDeMatch = :oldTime';

        $req = $this->linkpdo->prepare($sql);

        return $req->execute(array(
            ':newDate'   => $dateNouvelle,
            ':newTime'   => $heureNouvelle,
            ':nomEquipe' => $nomEquipe,
            ':lieu'      => $lieu,
            ':resultat'  => $resultat,
            ':points'    => $points,
            ':statut'    => $statut,
            ':oldDate'   => $dateAncien,
            ':oldTime'   => $heureAncien
        ));
    }

    /**
     * Met à jour le statut d'un match à partir de son identifiant
     *
     * @return bool Résultat de la mise à jour
     */
    public function updateStatut($matchId, $nouveauStatut) {
        $sql = "UPDATE match_basketball 
                SET Statut = :statut
                WHERE MatchID = :id";
        $stmt = $this->linkpdo->prepare($sql);
        return $stmt->execute([
            ':statut' => $nouveauStatut,
            ':id' => $matchId
        ]);
    }

    /**
     * Met à jour le résultat d'un match à partir de sa date et de son heure
     *
     * @return bool Résultat de la mise à jour
     */
    public function updateResultat($date, $heure, $nouveauRes) {
        $req = $this->linkpdo->prepare(
            "UPDATE match_basketball 
             SET Resultat = :resultat
             WHERE DateDeMatch = :d AND HeureDeMatch = :heure"
        );

        return $req->execute(array(
            ":resultat" => $nouveauRes,
            ":d"   => $date,
            ":heure"  => $heure
        ));
    }

    /**
     * Supprime un match à partir de sa date et de son heure
     *
     * @return bool Résultat de la suppression
     */
    public function deleteMatch($date, $heure){
        $req = $this->linkpdo->prepare('DELETE FROM match_basketball WHERE DateDeMatch = :d AND HeureDeMatch = :h');
        return $req->execute(['d' => $date, 'h' => $heure]);
    }

    /**
     * Calcule la moyenne des points marqués par l'équipe adverse
     *
     * @return float Moyenne des points adverses
     */
    public function getMoyennePointsAdversaire() {
        $stmt = $this->linkpdo->query("
            SELECT AVG(PointsMarquesParAdversaire) AS MoyennePointsAdversaire
            FROM match_basketball
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC)['MoyennePointsAdversaire'];
    }

    /**
     * Récupère les matchs à venir ou en préparation
     *
     * @return array Liste des matchs à venir
     */
    public function getMatchsAvenir() {
        $stmt = $this->linkpdo->query("
            SELECT * 
            FROM match_basketball
            WHERE Statut IN ('Avenir','Prepare')
            ORDER BY DateDeMatch, HeureDeMatch
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les meilleurs marqueurs (top 5)
     *
     * @return array Liste des meilleurs scoreurs
     */
    public function getTopScorers() {
        $stmt = $this->linkpdo->prepare("
            SELECT j.NumeroLicence, j.Nom, j.Prenom, SUM(p.NbPointsMarque) AS TotalPoints
            FROM participer p
            JOIN joueur j ON p.NumeroLicence = j.NumeroLicence
            WHERE p.Joue = TRUE
            GROUP BY j.NumeroLicence
            ORDER BY TotalPoints DESC
            LIMIT 5
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un match à partir de son identifiant
     *
     * @return array Données du match
     */
    public function getMatchById($matchId) {
        $sql = "SELECT NomEquipeAdversaire, DateDeMatch, HeureDeMatch, LieuDeRencontre
                FROM match_basketball
                WHERE MatchID = ?";
        $stmt = $this->linkpdo->prepare($sql);
        $stmt->execute([$matchId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un match à partir de sa date et de son heure
     *
     * @return array Match trouvé ou null
     */
    public function getMatchByDateHeure(string $date, string $heure): ?array {
        $sql = "
            SELECT MatchID, NomEquipeAdversaire, DateDeMatch, HeureDeMatch, LieuDeRencontre,
                   Resultat, PointsMarquesParAdversaire, Statut
            FROM match_basketball
            WHERE DateDeMatch = ? AND HeureDeMatch = ?
        ";

        $stmt = $this->linkpdo->prepare($sql);
        $stmt->execute([$date, $heure]);
        $match = $stmt->fetch(PDO::FETCH_ASSOC);

        return $match ?: null;
    }



}

?>
