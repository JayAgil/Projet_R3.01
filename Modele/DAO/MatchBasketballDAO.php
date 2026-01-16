<?php
require_once __DIR__ . '/../Joueur.class.php';
require_once __DIR__ . '/../MatchBasketball.class.php';
require_once __DIR__ . '/../Participer.class.php';
    class MatchBasketballDAO {
    private $linkpdo;

    public function __construct() {
        try {
             $db = 'r301php2025_db';
            $server = 'localhost';
            $login = 'root';
            $mdp = '';
            $this->linkpdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $login, $mdp);
            $this->linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getNbMatch ($result){
        $req = $this->linkpdo->prepare('SELECT count(*) as nb from Match_Basketball where Resultat = :resultat');
        $req->execute(array(":resultat" => $result));
        $nb = $req->fetch(PDO::FETCH_ASSOC);
        return $nb['nb'];
    }

    public function getTauxDeVictoire(){
        $gagne = $this->getNbMatch("Victoire");
        $req = $this->linkpdo->query('SELECT count(*) as nb from Match_Basketball');
        $row = $req->fetch(PDO::FETCH_ASSOC);
        $total = $row['nb'];
        return ($gagne/$total) * 100;
    }

    public function getNbMatchCeMois(){
    $req = $this->linkpdo->prepare(
        'SELECT COUNT(*) AS nb
         FROM Match_Basketball
         WHERE MONTH(DateDeMatch) = MONTH(CURDATE())
         AND YEAR(DateDeMatch) = YEAR(CURDATE())'
    );    
    $req->execute();
    $row = $req->fetch(PDO::FETCH_ASSOC);
    return $row['nb'];
    }

    public function getAllMatches(){
        $req = $this->linkpdo->query("SELECT * FROM Match_Basketball");
        $matches = [];
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

    public function insertMatch($date, $heure, $equipe, $lieu, $resultat, $pointsAdv, $statut) {
     $req = $this->linkpdo->prepare(
        'INSERT INTO Match_Basketball
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

    public function updateMatch(
    $dateAncien, $heureAncien,
    $dateNouvelle, $heureNouvelle,
    $nomEquipe,
    $lieu,
    $resultat,
    $points,
    $statut
    ) {
    $sql = 'UPDATE Match_Basketball
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

public function updateStatut($date, $heure, $nouveauStatut) {
    $req = $this->linkpdo->prepare(
        "UPDATE Match_Basketball 
         SET Statut = :statut
         WHERE DateDeMatch = :d AND HeureDeMatch = :heure"
    );

    return $req->execute([
        ":statut" => $nouveauStatut,
        ":d"   => $date,
        ":heure"  => $heure
    ]);

}

    public function updateResultat($date, $heure, $nouveauRes) {
        $req = $this->linkpdo->prepare(
            "UPDATE Match_Basketball 
            SET Resultat = :resultat
            WHERE DateDeMatch = :d AND HeureDeMatch = :heure"
        );

        return $req->execute(array(
            ":resultat" => $nouveauRes,
            ":d"   => $date,
            ":heure"  => $heure
        ));

    }

    public function deleteMatch($date, $heure){
        $req = $this->linkpdo->prepare('DELETE FROM Match_Basketball WHERE DateDeMatch = :d AND HeureDeMatch = :h');
        return $req->execute(['d' => $date, 'h' => $heure]);
    }

    

    public function getMoyennePointsAdversaire() {
            $stmt = $this->linkpdo->query("
                SELECT AVG(PointsMarquesParAdversaire) AS MoyennePointsAdversaire
                FROM Match_Basketball
            ");
            return $stmt->fetch(PDO::FETCH_ASSOC)['MoyennePointsAdversaire'];
    }

    public function getMatchsAvenir() {
            $stmt = $this->linkpdo->query("
                SELECT * 
                FROM Match_Basketball
                WHERE Statut IN ('Avenir','Prepare')
                ORDER BY DateDeMatch, HeureDeMatch
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopScorers() {
        $stmt = $this->linkpdo->prepare("
            SELECT j.NumeroLicence, j.Nom, j.Prenom, SUM(p.NbPointsMarque) AS TotalPoints
            FROM Participer p
            JOIN Joueur j ON p.NumeroLicence = j.NumeroLicence
            WHERE p.Joue = TRUE
            GROUP BY j.NumeroLicence
            ORDER BY TotalPoints DESC
            LIMIT 5
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMatchByDateHeure(string $date, string $heure): ?array {
        $stmt = $this->linkpdo->prepare("
            SELECT * FROM Match_Basketball
            WHERE DateDeMatch = :d AND HeureDeMatch = :h
        ");
        $stmt->execute([
            ':d' => $date,
            ':h' => $heure
        ]);
        $match = $stmt->fetch(PDO::FETCH_ASSOC);
        return $match ?: null;
    }

    




    }

?>
