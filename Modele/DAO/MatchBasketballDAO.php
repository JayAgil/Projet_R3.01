<?php
    class MatchBasketballDAO {
    private $linkpdo;

    public function __construct() {
        try {
            $db = 'r301php2025_db';
            $server = 'http://mysql.alwaysdata.com/';
            $login = '442017';
            $mdp = '!@#$1234abcd';
            $this->linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp); 
        }
        catch (Exception $e) {
             die('Erreur : ' . $e->getMessage()); 

        }
    }

    public function getNbMatch ($result){
        $req = $this->linkpdo->prepare('SELECT count(*) as nb from Match_Basketball where Resultat = :resultat');
        $req->execute(array('resultat => $result'));
        $nb = $req->fetch();
        return $nb['nb'];
    }

    public function getTauxDeVictoire(){
        $gagne = $this->getNbMatch("Victoire");
        $req = $this->linkpdo->query('SELECT count(*) as nb from Match_Basketball');
        $row = $req->fetch();
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
    