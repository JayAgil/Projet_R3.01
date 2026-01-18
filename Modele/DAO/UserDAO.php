<?php
    class UserDAO {
    private $linkpdo;

    /**
     * Connecter à la BD avec PDO
    */
    public function __construct() {
        try {
            $db     = 'if0_40934572_r301php2025_db';
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
     * Récupère le mot de passe associé à un nom d'utilisateur.
     *
     * Cette méthode est principalement utilisée lors du processus
     * d'authentification afin de vérifier les identifiants fournis
     * par l'utilisateur.
     *
     * @param string $username Nom d'utilisateur
     * @return string Mot de passe correspondant ou null si l'utilisateur n'existe pas
    */
   public function getMdpByUsername($username) {
    $req = $this->linkpdo->prepare(
        "SELECT Password FROM users WHERE Username = :user"
    );
    $req->execute([":user" => $username]);

    $result = $req->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['Password'] : null;
   }
}


?>
