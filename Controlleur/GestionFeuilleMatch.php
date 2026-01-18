<?php
require_once __DIR__ . '/../Modele/DAO/ParticiperDAO.php'; 
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
require_once __DIR__ . '/../Modele/DAO/MatchBasketballDAO.php';

class GestionFeuilleMatch {
    private $joueurDAO;
    private $participerDAO;
    private $matchDAO;
    private $matchId;

    public function __construct($matchId) {
        $this->joueurDAO = new JoueurDAO();
        $this->participerDAO = new ParticiperDAO();
        $this->matchDAO = new MatchBasketballDAO();
        $this->matchId = $matchId;
    }

    public function executer() {
        $error = "";
        $success = "";

        // --- Fetch match info for top display ---
        $matchInfo = $this->matchDAO->getMatchById($this->matchId);

        // --- Initialize selections ---
        $currentSelection = ['titulars' => [], 'subs' => []];
        $existing = $this->participerDAO->getExistingPlayers($this->matchId);

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

        // --- Handle POST ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect titulars
    $titulars = [
        'PG' => $_POST['titular_PG'] ?? '',
        'SG' => $_POST['titular_SG'] ?? '',
        'SF' => $_POST['titular_SF'] ?? '',
        'PF' => $_POST['titular_PF'] ?? '',
        'C'  => $_POST['titular_C'] ?? ''
    ];

    // Collect subs
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

    // --- VALIDATION: ensure 5 distinct titulars ---
    $filledTitulars = array_filter($titulars);
    if (count($filledTitulars) < 5) {
        $error = "Erreur : Vous devez sélectionner 5 titulaires.";
    } elseif (count(array_unique($filledTitulars)) !== 5) {
        $error = "Erreur : Chaque titulaire doit être un joueur distinct.";
    } else {
        // --- VALIDATION: ensure all selected (titular + subs) are unique ---
        $allSelected = array_merge(array_values($titulars), array_column($subs, 'licence'));
        $filledSelected = array_filter($allSelected); // remove empty
        if (count($filledSelected) !== count(array_unique($filledSelected))) {
            $error = "Erreur : Aucun joueur ne peut être choisi deux fois (titulaire + remplaçant).";
        } else {
            // Save to DB
            if ($this->participerDAO->saveMatchSheet($this->matchId, $titulars, $subs)) {
                $success = "Feuille de match enregistrée avec succès !";
                $this->matchDAO->updateStatut($this->matchId, 'Preparé');
                header("Location: index.php?action=principale&status=updated");
                exit();
            } else {
                $error = "Erreur lors de l'enregistrement.";
            }
        }
    }

    // Keep currentSelection filled so the form keeps user's choices
    $currentSelection['titulars'] = $titulars;
    $currentSelection['subs'] = $subs;
}


        // --- Fetch players for combo boxes ---
        $players = $this->joueurDAO->getActivePlayers();

        // --- Render view ---
        require_once __DIR__ . '/../Vue/feuilleDeMatch.php';
    }
}
?>
