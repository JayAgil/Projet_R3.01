<?php
    class UserDAO {
    private $linkpdo;

    public function __construct() {
        try {
            $db = 'r301php2025_db';
            $server = 'mysql-r301php2025.alwaysdata.net';
            $login = '442017';
            $mdp = '!@#$1234abcd';
            $this->linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp); 
        }
        catch (Exception $e) {
             die('Erreur : ' . $e->getMessage()); 
        }
    }

    public function verifierUserExiste($username,$mdp){
        $req = $this->linkpdo->prepare('SELECT count(*) as nb from User where Username = :user AND Password = :mdp');
        $req->execute(array('user' => $username,'mdp' => $mdp));
        $nb = $req->fetch(PDO::FETCH_ASSOC);
        if ($nb['nb'] > 0) {
            return true;
        }
        return false;

    }


    
}


?>
