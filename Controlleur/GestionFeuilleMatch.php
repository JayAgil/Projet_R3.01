<?php
require_once __DIR__ . '/../Modele/DAO/ParticiperDAO.php'; 
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
class GestionFeuilleMatch {
    private $joueurDAO;
    private $participerDAO;
    private $matchId;

    public function __construct($matchId) {
        $this->joueurDAO = new JoueurDAO();
        $this->participerDAO = new ParticiperDAO();
        $this->matchId = $matchId; // The ID passed from the main menu
    }

    public function executer() {
        $error = "";
        $success = "";

        // --- 1. HANDLE SAVING (POST) ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get Titulars from the 5 specific selects
            $titulars = [
                'PG' => $_POST['titular_PG'] ?? '',
                'SG' => $_POST['titular_SG'] ?? '',
                'SF' => $_POST['titular_SF'] ?? '',
                'PF' => $_POST['titular_PF'] ?? '',
                'C'  => $_POST['titular_C'] ?? ''
            ];

            // Validation: Exactly 5 unique players
            $filled = array_filter($titulars);
            if (count($filled) < 5 || count(array_unique($filled)) !== 5) {
                $error = "Veuillez sélectionner 5 titulaires différents.";
            } else {
                // Collect Substitutes from the arrays
                $subs = [];
                if (isset($_POST['substitute_player'])) {
                    foreach ($_POST['substitute_player'] as $index => $licence) {
                        if (!empty($licence)) {
                            $subs[] = [
                                'licence' => $licence,
                                'pos' => $_POST['substitute_pos'][$index] ?? 'Remplaçant'
                            ];
                        }
                    }
                }

                // Call DAO to save using the MatchID
                if ($this->participerDAO->saveMatchSheet($this->matchId, $titulars, $subs)) {
                    $success = "Feuille de match enregistrée !";
                }
            }
        }

        // --- 2. PREPARE VIEW DATA ---
        $players = $this->joueurDAO->getActivePlayers();
        $existing = $this->participerDAO->getExistingPlayers($this->matchId);
        
        // Organize for the View
        $currentSelection = ['titulars' => [], 'subs' => []];
        foreach ($existing as $entry) {
            if ($entry['EstTitulaire']) {
                $currentSelection['titulars'][$entry['PosteOccupee']] = $entry['NumeroLicence'];
            } else {
                $currentSelection['subs'][] = $entry;
            }
        }

        require_once __DIR__ . '/../Vue/feuilleDeMatch.php';
    }
}