<?php 
class User {

    private $user;
    private $mdp;

    public function __construct($user,$mdp) {
        $this->user = $user;
        $this->mdp = $mdp;
    }
}

