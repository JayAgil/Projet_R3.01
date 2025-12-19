<?php
    class UserDAO {
    private $linkpdo;

    public function __construct() {
        try {
            $db = 'r301php2025_db';
            $server = 'localhost';
            $login = 'root';
            $mdp = '';
            $this->linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp); 
        }
        catch (Exception $e) {
             die('Erreur : ' . $e->getMessage()); 
        }
    }

    public function verifierUserExiste($username, $mdp) {
    $req = $this->linkpdo->prepare('SELECT count(*) as nb FROM Users WHERE Username = :user AND Password = :mdp');
    $req->execute(array(':user' => $username, ':mdp' => $mdp));
    $nb = $req->fetch(PDO::FETCH_ASSOC);
    
    return $nb['nb'] > 0;
    }



    
}


?>
