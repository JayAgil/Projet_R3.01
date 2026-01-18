<?php
require_once __DIR__ . '/../Joueur.class.php';

class JoueurDAO {

    private PDO $pdo;

    /**
     * Connecter à la BD avec PDO
     */
    public function __construct() {
        try {
            $db     = 'if0_40934572_r301php2025_db';
            $server = 'sql112.infinityfree.com';
            $login  = 'if0_40934572';
            $mdp    = 'kgZTli4UVfsK';
            $this->pdo = new PDO(
                "mysql:host=$server;dbname=$db;charset=utf8",
                $login,
                $mdp
            );
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    /**
     * Insère un nouveau joueur dans la base de données
     *
     * @param Joueur $j Objet Joueur à insérer
     */
    public function insert(Joueur $j): void {
        $sql = "
            INSERT INTO joueur (
                NumeroLicence,
                Nom,
                Prenom,
                DateDeNaissance,
                Taille_cm,
                Poids_kg,
                Statut,
                Commentaire
            ) VALUES (
                :nl,
                :n,
                :p,
                :dn,
                :t,
                :pd,
                :s,
                :c
            )
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nl' => $j->getNumeroLicence(),
            ':n'  => $j->getNom(),
            ':p'  => $j->getPrenom(),
            ':dn' => $j->getDateNaissance(),
            ':t'  => $j->getTaille(),
            ':pd' => $j->getPoids(),
            ':s'  => $j->getStatut(),
            ':c'  => $j->getCommentaire()
        ]);
    }

    /**
     * Met à jour les informations d'un joueur existant
     *
     * @param Joueur $j Objet Joueur contenant les nouvelles données
     */
    public function update(Joueur $j): void {
        $sql = "
            UPDATE joueur
            SET
                Nom = :n,
                Prenom = :p,
                DateDeNaissance = :dn,
                Taille_cm = :t,
                Poids_kg = :pd,
                Statut = :s,
                Commentaire = :c
            WHERE NumeroLicence = :nl
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nl' => $j->getNumeroLicence(),
            ':n'  => $j->getNom(),
            ':p'  => $j->getPrenom(),
            ':dn' => $j->getDateNaissance(),
            ':t'  => $j->getTaille(),
            ':pd' => $j->getPoids(),
            ':s'  => $j->getStatut(),
            ':c'  => $j->getCommentaire()
        ]);
    }

    /**
     * Supprime un joueur à partir de son numéro de licence
     *
     * @param string $numeroLicence Numéro de licence du joueur à supprimer
     */
    public function delete(string $numeroLicence): void {
        $stmt = $this->pdo->prepare(
            "DELETE FROM joueur WHERE NumeroLicence = :nl"
        );
        $stmt->execute([':nl' => $numeroLicence]);
    }

    /**
     * Récupère tous les joueurs
     *
     * @return array Liste de tous les joueurs (tableau associatif)
     */
    public function getAll(): array {
        return $this->pdo
            ->query("SELECT * FROM joueur")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche des joueurs à partir d'un terme (nom, prénom, licence ou statut)
     *
     * @param string $term Terme de recherche
     * @return array Résultats de la recherche
     */
    public function search(string $term): array {
        $stmt = $this->pdo->prepare("
            SELECT * FROM joueur
            WHERE Nom LIKE :term
               OR Prenom LIKE :term
               OR NumeroLicence LIKE :term
               OR Statut LIKE :term
        ");
        $stmt->execute([':term' => "%$term%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un joueur à partir de son numéro de licence
     *
     * @param string $numeroLicence Numéro de licence du joueur
     * @return Joueur|null Objet Joueur ou null si non trouvé
     */
    public function getById(string $numeroLicence): ?Joueur {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM joueur WHERE NumeroLicence = ?"
        );
        $stmt->execute([$numeroLicence]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        return new Joueur(
            $data['NumeroLicence'],
            $data['Nom'],
            $data['Prenom'],
            $data['DateDeNaissance'],
            $data['Taille_cm'],
            $data['Poids_kg'],
            $data['Statut'],
            $data['Commentaire']
        );
    }

    /**
     * Récupère la liste des joueurs actifs
     *
     * @return array Liste des joueurs actifs
     */
    public function getActivePlayers(): array {
        try {
            $sql = "SELECT * FROM joueur WHERE Statut = 'Actif' ORDER BY Nom, Prenom";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Enregistre l'erreur dans les logs sans interrompre l'application
            error_log("Error in getActivePlayers: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Calcule et retourne les statistiques d'un joueur
     *
     * @param string $numeroLicence Numéro de licence du joueur
     * @return array Statistiques du joueur
     */
    public function getStatistiques(string $numeroLicence): array {
        $req = $this->pdo->prepare("
            SELECT 
                j.Statut,
                j.Prenom as PostePreferere,
                COUNT(CASE WHEN p.EstTitulaire = 1 THEN 1 END) as selections_titulaire,
                COUNT(CASE WHEN p.EstTitulaire = 0 THEN 1 END) as selections_remplacant,
                AVG(p.Note) as moyenne_evaluation,
                COUNT(p.NumeroLicence) as total_matchs,
                SUM(CASE WHEN m.Resultat = 'Victoire' THEN 1 ELSE 0 END) as victoires
            FROM joueur j
            LEFT JOIN participer p ON j.NumeroLicence = p.NumeroLicence
            LEFT JOIN match_basketball m ON p.MatchID = m.MatchID
            WHERE j.NumeroLicence = :licence
            GROUP BY j.NumeroLicence, j.Statut, j.Prenom
        ");
        
        $req->execute([':licence' => $numeroLicence]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
        
        // Valeurs par défaut si aucune statistique n'est trouvée
        if (!$result) {
            return [
                'selections_titulaire' => 0,
                'selections_remplacant' => 0,
                'moyenne_evaluation' => 0,
                'pourcentage_victoires' => 0,
                'selections_consecutives' => 0,
                'PostePreferere' => 'N/A',
                'PosteOccupee' => 'N/A'
            ];
        }
        
        // Calcul du pourcentage de victoires
        $pourcentageVictoires = $result['total_matchs'] > 0 
            ? round(($result['victoires'] / $result['total_matchs']) * 100, 1)
            : 0;
        
        // Recherche du poste le plus souvent occupé
        $reqPoste = $this->pdo->prepare("
            SELECT PosteOccupee, COUNT(*) as freq
            FROM participer
            WHERE NumeroLicence = :licence
            AND PosteOccupee IS NOT NULL
            GROUP BY PosteOccupee
            ORDER BY freq DESC
            LIMIT 1
        ");
        $reqPoste->execute([':licence' => $numeroLicence]);
        $poste = $reqPoste->fetch(PDO::FETCH_ASSOC);
        $posteOccupee = $poste ? $poste['PosteOccupee'] : 'N/A';
        
        // Calcul du nombre de matchs consécutifs joués
        $reqConsecutive = $this->pdo->prepare("
            SELECT COUNT(*) as consecutives
            FROM (
                SELECT m.MatchID
                FROM match_basketball m
                WHERE m.DateDeMatch <= CURDATE()
                ORDER BY m.DateDeMatch DESC, m.HeureDeMatch DESC
                LIMIT 10
            ) recent_matches
            INNER JOIN participer p ON recent_matches.MatchID = p.MatchID
            WHERE p.NumeroLicence = :licence
            AND p.Joue = 1
        ");
        
        $reqConsecutive->execute([':licence' => $numeroLicence]);
        $consecutive = $reqConsecutive->fetch(PDO::FETCH_ASSOC)['consecutives'] ?? 0;
        
        return [
            'selections_titulaire' => (int)$result['selections_titulaire'],
            'selections_remplacant' => (int)$result['selections_remplacant'],
            'moyenne_evaluation' => $result['moyenne_evaluation'] ? round($result['moyenne_evaluation'], 2) : 0,
            'pourcentage_victoires' => $pourcentageVictoires,
            'selections_consecutives' => $consecutive,
            'PostePreferere' => $posteOccupee
        ];
    }

    /**
     * Récupère les joueurs ayant déjà occupé un poste donné
     *
     * @param string $position Poste recherché
     * @return array Liste des joueurs correspondant au poste
     */
    public function getJoueursByPosition(string $position): array {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT j.*
            FROM joueur j
            INNER JOIN participer p ON j.NumeroLicence = p.NumeroLicence
            WHERE p.PosteOccupee = :position
            ORDER BY j.Nom, j.Prenom
        ");
        $stmt->execute([':position' => $position]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère la liste de tous les postes distincts occupés
     *
     * @return array Liste des postes
     */
    public function getAllPositions(): array {
        $stmt = $this->pdo->query("
            SELECT DISTINCT PosteOccupee
            FROM participer
            WHERE PosteOccupee IS NOT NULL
            ORDER BY PosteOccupee
        ");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

}