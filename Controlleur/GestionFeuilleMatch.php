<?php
    require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';

class GestionFeuilleMatch {
    private $joueurDAO;
    private $matchDate;
    private $matchTime;

    public function __construct($matchDate, $matchTime) {
        $this->joueurDAO = new JoueurDAO();
        $this->matchDate = $matchDate;
        $this->matchTime = $matchTime;
    }

    public function executer() {
        $players = $this->joueurDAO->getActivePlayers();

        // Handle POST submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulars = $_POST['titular'] ?? [];
            $subs = $_POST['substitute'] ?? [];

            // Minimum 5 titulars
            if (count($titulars) < 5) {
                $error = "Vous devez sélectionner 5 titulaires.";
            }
        }

        // Return data to view
        return [
            'players' => $players,
            'error' => $error ?? '',
            'success' => $success ?? ''
        ];
    }
}
?>
