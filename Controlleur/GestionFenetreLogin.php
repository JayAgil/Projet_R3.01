<?php
    require_once __DIR__ . '/../Modele/DAO/UserDAO.php';

    class GestionFenetreLogin {
        private $userDAO;
        private $username;
        private $mdp;

        public function __construct ($username, $mdp){

            $this->userDAO = new UserDAO();
            $this->username = $username;
            $this->mdp = $mdp;
            
        }

        // Verifier que le user existe dans la BD
        public function executer(){
            $mdp = $this->userDAO->getMdpByUsername($this->username);
            return password_verify($this->mdp,$mdp);
        }

}
?>