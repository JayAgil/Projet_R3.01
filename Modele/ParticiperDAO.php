<?php
    class ParticiperDAO {
    private $linkpdo;

    public function __construct() {
        try {
            $db = '';
            $server = '';
            $login = '';
            $mdp = '';
            $this->linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp); 
        }
        catch (Exception $e) {
             die('Erreur : ' . $e->getMessage()); 

        }
    }

    public function insertParticiper(Participer $p) {
        $req = $this->linkpdo->query('INSERT INTO Participer (NumeroLicence,DateDeMatch,HeureDeMatch,Note,NbPointsMarque,PosteOccupee,EstTitulaire,Commentaire,Joue)
                                      VALUES(:NumeroLicence,:DateDeMatch,:HeureDeMatch,:Note,:NbPointsMarque,:PosteOccupee,:EstTitulaire,:Commentaire,:Joue)');
        $stmt = $this->pdo->prepare($req);
        $this->bindParticiper($stmt, $p);
        return $stmt->execute();
    }

    public function deleteParticiper(String $numeroLicence,String $dateDeMatch,String $heureDeMatch) {
        $req = $this->linkpdo->query('DELETE Participer 
                                      WHERE NumeroLicence = :NumeroLicence
                                      AND DateDeMatch = :DateDeMatch
                                      AND HeureDeMatch = :HeureDeMatch');
        $stmt = $this->pdo->prepare($req);
        $stmt->bindValue(':NumeroLicence', $numeroLicence);
        $stmt->bindValue(':DateDeMatch', $dateDeMatch);
        $stmt->bindValue(':HeureDeMatch', $heureDeMatch);
        return $stmt->execute();

    }

    public function updateParticiper(Participer $p) {
        $req = $this->linkpdo->query('UPDATE Participer SET
                                      Note = :Note,
                                      NbPointsMarque = :NbPointsMarque,
                                      PosteOccupee = :PosteOccupee,
                                      EstTitulaire = :EstTitulaire,
                                      Commentaire = :Commentaire,
                                      Joue = :Joue
                                      WHERE NumeroLicence = :NumeroLicence 
                                      AND DateDeMatch = :DateDeMatch 
                                      AND HeureDeMatch = :HeureDeMatch');
        $stmt = $this->pdo->prepare($sql);
        $this->bindParticiper($stmt, $p); 
        return $stmt->execute();
    }
    }


?>
