<?php
    class GestionFenetreLogin {
        private $userDAO;
        private $username;
        private $mdp;

        public function __construct ($username, $mdp){
         
            $this->userDAO = new UserDAO();
            $this->username = $username;
            $this->mdp = $mdp;
            
        }

        public function executer(){
            return $this->userDao->verifierUserExiste($this->username, $this ->mdp);
        }

}
?>