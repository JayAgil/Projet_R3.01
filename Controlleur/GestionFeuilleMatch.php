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
        $this->matchId = $matchId; 
    }

   public function executer() {
    $error = "";
    $success = "";

    // --- 1. HANDLE SAVING (POST) ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulars = [
            'PG' => $_POST['titular_PG'] ?? '',
            'SG' => $_POST['titular_SG'] ?? '',
            'SF' => $_POST['titular_SF'] ?? '',
            'PF' => $_POST['titular_PF'] ?? '',
            'C'  => $_POST['titular_C'] ?? ''
        ];

        $filledTitulars = array_filter($titulars);
        if (count($filledTitulars) < 5 || count(array_unique($filledTitulars)) !== 5) {
            $error = "Erreur: Vous devez sélectionner 5 titulaires différents.";
        } else {
            $subs = [];
            if (isset($_POST['substitute_player'])) {
                foreach ($_POST['substitute_player'] as $index => $licence) {
                    if (!empty($licence)) {
                        $subs[] = [
                            'licence' => $licence,
                            'pos' => $_POST['sub_target_pos'][$index] ?? 'Remplaçant'
                        ];
                    }
                }
            }

            if ($this->participerDAO->saveMatchSheet($this->matchId, $titulars, $subs)) {
                header("Location: index.php?action=principale&status=updated");
                exit();
            }
        }
    }

    // --- 2. THE MISSING PART: FETCH DATA FOR THE VIEW ---
    // This must run for both GET (initial load) and POST (if validation fails)
    $players = $this->joueurDAO->getActivePlayers();
    $existing = $this->participerDAO->getExistingPlayers($this->matchId);

    // Organize existing data so the view can "pre-fill" the combo boxes
    // Inside GestionFeuilleMatch.php -> executer()
$currentSelection = ['titulars' => [], 'subs' => []];
foreach ($existing as $entry) {
    if ($entry['EstTitulaire']) {
        $currentSelection['titulars'][$entry['PosteOccupee']] = $entry['NumeroLicence'];
    } else {
        // We push them into the array. Index 0 will be sub 1, index 1 will be sub 2...
        $currentSelection['subs'][] = [
            'licence' => $entry['NumeroLicence'],
            'pos' => $entry['PosteOccupee']
        ];
    }
}

    // --- 3. RENDER THE VIEW ---
    require_once __DIR__ . '/../Vue/feuilleDeMatch.php';
}
}