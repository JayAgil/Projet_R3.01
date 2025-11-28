<?php 
class User {

    private $user;
    private $mdp;

    public function __construct($user,$mdp) {
        $this->user = $user;
        $this->mdp = $mdp;
    }
    public function getUser() {
        return $this->user;
    }

    public function getMdp() {
        return $this->mdp;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setMdp($mdp) {
        $this->mdp = $mdp;
    }

}

