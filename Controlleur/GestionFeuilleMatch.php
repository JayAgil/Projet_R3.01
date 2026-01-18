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
        
        // 1. ALWAYS initialize empty arrays first
        $currentSelection = [
            'titulars' => [], 
            'subs' => []
        ];

        // 2. Fetch existing players for THIS specific matchId
        $existing = $this->participerDAO->getExistingPlayers($this->matchId);

        // Fill selection ONLY if rows actually exist
        if (!empty($existing)) {
            foreach ($existing as $entry) {
                if ($entry['EstTitulaire']) {
                    $currentSelection['titulars'][$entry['PosteOccupee']] = $entry['NumeroLicence'];
                } else {
                    $currentSelection['subs'][] = [
                        'licence' => $entry['NumeroLicence'],
                        'pos' => $entry['PosteOccupee']
                    ];
                }
            }
        }

        // --- HANDLE SAVING (POST) ---
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

        // --- FETCH DATA FOR VIEW ---
        $players = $this->joueurDAO->getActivePlayers();

        // --- RENDER VIEW ---
        require_once __DIR__ . '/../Vue/feuilleDeMatch.php';
    }
}
