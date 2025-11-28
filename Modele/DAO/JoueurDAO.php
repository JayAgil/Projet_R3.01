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

    public function getPlusGrandTaille() {
        $stmt = $this->linkpdo->query("SELECT Nom, Prenom, Taille_cm FROM Joueur ORDER BY Taille_cm DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPlusLourde(){
        $stmt = $this->linkpdo->query("SELECT Nom, Prenom, Poids_kg FROM Joueur ORDER BY Poids_kg DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getJoueurParStatut() {
        $stmt = $this->linkpdo->query("SELECT Statut, COUNT(*) AS nb_players FROM Joueur GROUP BY Statut");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }






}
?>
