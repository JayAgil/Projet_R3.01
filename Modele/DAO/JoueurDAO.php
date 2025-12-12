<?php
class JoueurDAO {

    private $linkpdo;

    public function __construct() {
        try {
            $db = 'r301php2025_db';
            $server = 'mysql-r301php2025.alwaysdata.net';
            $login = '442017';
            $mdp = '!@#$1234abcd';
            $this->linkpdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $login, $mdp);
            $this->linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function insert(Joueur $j){
        $sql = 'INSERT INTO Joueur(NumeroLicence, Statut, Commentaire, Nom, Prenom, DateDeNaissance, Taille_cm, Poids_kg)
                VALUES(:nl, :s, :c, :n, :p, :dn, :t, :pd)';
        $stmt = $this->linkpdo->prepare($sql);
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

    public function delete($nl){
        $sql = 'DELETE FROM Joueur WHERE NumeroLicence = :numerolicence';
        $stmt = $this->linkpdo->prepare($sql);
        $stmt->execute([':numerolicence' => $nl]);
    }

    public function update(Joueur $j){
        $sql = 'UPDATE Joueur 
                SET Statut = :s, Commentaire = :c, Nom = :n, Prenom = :p, DateDeNaissance = :ddn, Taille_cm = :t, Poids_kg = :pd 
                WHERE NumeroLicence = :nl';
        $stmt = $this->linkpdo->prepare($sql);
        $stmt->execute([
            ':s'   => $j->statut,
            ':c'   => $j->commentaire,
            ':n'   => $j->nom,
            ':p'   => $j->prenom,
            ':ddn' => $j->date_naissance,
            ':t'   => $j->taille,
            ':pd'  => $j->poids,
            ':nl'  => $j->numero_licence
        ]);
    }

    public function getAll() {
        $stmt = $this->linkpdo->query("SELECT * FROM Joueur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($search) {
        $sql = "SELECT * FROM joueurs
                WHERE Nom LIKE :search
                   OR Prenom LIKE :search
                   OR NumeroLicence LIKE :search
                   OR Statut LIKE :search";
        $stmt = $this->linkpdo->prepare($sql);
        $stmt->execute(['search' => '%' . $search . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get10PlusGrandTaille() {
        $stmt = $this->linkpdo->query("SELECT Nom, Prenom, Taille_cm FROM Joueur ORDER BY Taille_cm DESC LIMIT 10");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get10PlusLourde(){
        $stmt = $this->linkpdo->query("SELECT Nom, Prenom, Poids_kg FROM Joueur ORDER BY Poids_kg DESC LIMIT 10");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getJoueurParStatut() {
        $stmt = $this->linkpdo->query("SELECT Statut, COUNT(*) AS nb_players FROM Joueur GROUP BY Statut");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBestPlayerByPoste($poste) {
        $sql = "
            SELECT j.NumeroLicence, j.Nom, j.Prenom, AVG(p.Note) AS MoyenneNote
            FROM Participer p
            JOIN Joueur j ON p.NumeroLicence = j.NumeroLicence
            WHERE p.Joue = TRUE 
            AND p.Note IS NOT NULL
            AND p.PosteOccupee = :poste
            GROUP BY j.NumeroLicence
            ORDER BY MoyenneNote DESC
            LIMIT 1
        ";
        
        $stmt = $this->linkpdo->prepare($sql);
        $stmt->execute(['poste' => $poste]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAverageNote($numeroLicence) {
        $stmt = $this->linkpdo->prepare("
            SELECT AVG(Note) AS MoyenneNote
            FROM Participer
            WHERE NumeroLicence = :numeroLicence AND Joue = TRUE
        ");
        $stmt->execute(['numeroLicence' => $numeroLicence]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['MoyenneNote'];
    }

    public function getNombreTitularisations($numeroLicence) {
        $stmt = $this->linkpdo->prepare("
            SELECT COUNT(*) AS Nombre
            FROM Participer
            WHERE NumeroLicence = :numeroLicence AND EstTitulaire = TRUE AND Joue = TRUE
        ");
        $stmt->execute(['numeroLicence' => $numeroLicence]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['Nombre'];
    }

    public function getNombreRemplacements($numeroLicence) {
        $stmt = $this->linkpdo->prepare("
            SELECT COUNT(*) AS Nombre
            FROM Participer
            WHERE NumeroLicence = :numeroLicence AND EstTitulaire = FALSE AND Joue = TRUE
        ");
        $stmt->execute(['numeroLicence' => $numeroLicence]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['Nombre'];
    }
    
    public function getNombreMatchsJoues($numeroLicence) {
        $stmt = $this->linkpdo->prepare("
            SELECT COUNT(*) AS Nombre
            FROM Participer
            WHERE NumeroLicence = :numeroLicence AND Joue = TRUE
        ");
        $stmt->execute(['numeroLicence' => $numeroLicence]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['Nombre'];
    }

    public function getPostePrefere($numeroLicence) {
        $stmt = $this->linkpdo->prepare("
            SELECT PosteOccupee, AVG(Note) AS MoyenneNote
            FROM Participer
            WHERE NumeroLicence = :numeroLicence AND Joue = TRUE
            GROUP BY PosteOccupee
            ORDER BY MoyenneNote DESC
            LIMIT 1
        ");
        $stmt->execute(['numeroLicence' => $numeroLicence]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPourcentageVictoires($numeroLicence) {
        $stmt = $this->linkpdo->prepare("
            SELECT 
                SUM(CASE WHEN m.Resultat = 'Victoire' THEN 1 ELSE 0 END)/COUNT(*)*100 AS PourcentageVictoires
            FROM Participer p
            JOIN Match_Basketball m ON p.MatchID = m.MatchID
            WHERE p.NumeroLicence = :numeroLicence AND p.Joue = TRUE
        ");
        $stmt->execute(['numeroLicence' => $numeroLicence]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['PourcentageVictoires'];
    }

     public function getTotalPoints($numeroLicence) {
        $stmt = $this->linkpdo->prepare("
            SELECT SUM(NbPointsMarque) AS TotalPoints
            FROM Participer
            WHERE NumeroLicence = :numeroLicence AND Joue = TRUE
        ");
        $stmt->execute(['numeroLicence' => $numeroLicence]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['TotalPoints'];
    }

    public function getActivePlayers() {
        $stmt = $this->linkpdo->query("
            SELECT * FROM Joueur WHERE Statut = 'Actif'
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInactivePlayers() {
        $stmt = $this->linkpdo->query("
            SELECT * FROM Joueur WHERE Statut != 'Actif'
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }







}
?>
