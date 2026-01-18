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

        // -Recuperer les informations du match
        $matchInfo = $this->matchDAO->getMatchById($this->matchId);

        // Affichage du titulaires et remplacants s'il y en a qui sont déjà enregistrés
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


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recupérer les joueurs selectionnés comme titulaires
    $titulars = [
        'PG' => $_POST['titular_PG'] ?? '',
        'SG' => $_POST['titular_SG'] ?? '',
        'SF' => $_POST['titular_SF'] ?? '',
        'PF' => $_POST['titular_PF'] ?? '',
        'C'  => $_POST['titular_C'] ?? ''
    ];

    // Recupérer les joueurs selectionnés comme remplaçants
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

    // Verifier qu'il y a bien 5 joueurs distincts comme titulaires
    $filledTitulars = array_filter($titulars);
    if (count($filledTitulars) < 5) {
        $error = "Erreur : Vous devez sélectionner 5 titulaires.";
    } elseif (count(array_unique($filledTitulars)) !== 5) {
        $error = "Erreur : Chaque titulaire doit être un joueur distinct.";
    } else {
        // Verifier que tous les joueurs selectionnés sont distincts
        $allSelected = array_merge(array_values($titulars), array_column($subs, 'licence'));
        $filledSelected = array_filter($allSelected); 
        if (count($filledSelected) !== count(array_unique($filledSelected))) {
            $error = "Erreur : Aucun joueur ne peut être choisi deux fois (titulaire + remplaçant).";
        } else {
            // Inserer dans la BD les titulaires et les remplaçants
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

    // S'il y a une erreur, garder les joueurs selectionnés
    $currentSelection['titulars'] = $titulars;
    $currentSelection['subs'] = $subs;
}


        // Recupérer tous les jouers actives
        $players = $this->joueurDAO->getActivePlayers();

        // Recupérer la dernière note de chaque joueur actif
        $lastNotes = [];
        foreach ($players as $p) {
             $lastNotes[$p['NumeroLicence']] = $this->participerDAO->getLastNoteByPlayer($p['NumeroLicence']);
        
             }
        // Affichage du vue
        require_once __DIR__ . '/../Vue/FeuilleDeMatch.php';
    }
}
?>
