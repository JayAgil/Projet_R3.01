<?php
    class UserDAO {
    private $linkpdo;

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

   public function getMdpByUsername($username) {
    $req = $this->linkpdo->prepare(
        "SELECT Password FROM Users WHERE Username = :user"
    );
    $req->execute([":user" => $username]);

    $result = $req->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['Password'] : null;
}






    
}


?>
