<?php
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
require_once __DIR__ . '/../Modele/DAO/ParticiperDAO.php';

class GestionFeuilleMatch {
    private $joueurDAO;
    private $participerDAO;
    private $matchDate;
    private $matchTime;

    public function __construct($matchDate, $matchTime) {
        $this->joueurDAO = new JoueurDAO();
        $this->participerDAO = new ParticiperDAO();
        $this->matchDate = $matchDate;
        $this->matchTime = $matchTime;
    }

    public function executer() {
        $error = "";
        $success = "";

        // 1. Handle Form Submission (Save to DB)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulars = [
                'PG' => $_POST['titular_PG'] ?? '',
                'SG' => $_POST['titular_SG'] ?? '',
                'SF' => $_POST['titular_SF'] ?? '',
                'PF' => $_POST['titular_PF'] ?? '',
                'C'  => $_POST['titular_C'] ?? ''
            ];

            $filledTitulars = array_filter($titulars); 
            if (count($filledTitulars) < 5) {
                $error = "Erreur : Vous devez sélectionner les 5 titulaires.";
            } elseif (count(array_unique($filledTitulars)) !== 5) {
                $error = "Erreur : Un joueur ne peut pas être sélectionné deux fois.";
            } else {
                $substitutes = [];
                if (isset($_POST['substitute_player'])) {
                    foreach ($_POST['substitute_player'] as $index => $licence) {
                        if (!empty($licence)) {
                            $substitutes[] = [
                                'licence' => $licence,
                                'pos' => $_POST['substitute_pos'][$index] ?? 'Remplaçant'
                            ];
                        }
                    }
                }

                if ($this->participerDAO->saveMatchSheet($this->matchDate, $this->matchTime, $titulars, $substitutes)) {
                    $success = "La feuille de match a été enregistrée avec succès !";
                } else {
                    $error = "Une erreur est survenue lors de l'enregistrement.";
                }
            }
        }

        // 2. Fetch data needed for the form
        $players = $this->joueurDAO->getActivePlayers();
        $existingEntries = $this->participerDAO->getExistingPlayers($this->matchDate, $this->matchTime);
        
        // 3. Organize existing data for the View to pre-fill dropdowns
        $currentSelection = [
            'titulars' => [],
            'subs' => []
        ];

        foreach ($existingEntries as $entry) {
            if ($entry['EstTitulaire']) {
                $currentSelection['titulars'][$entry['PosteOccupee']] = $entry['NumeroLicence'];
            } else {
                $currentSelection['subs'][] = [
                    'licence' => $entry['NumeroLicence'],
                    'pos' => $entry['PosteOccupee']
                ];
            }
        }

        // 4. Finally, LOAD THE VIEW (Only once, at the very end)
        require_once __DIR__ . '/../Vue/feuilleDeMatch.php';
    }
}