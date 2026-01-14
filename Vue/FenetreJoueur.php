<?php
require_once __DIR__ . '/../Modele/DAO/MatchBasketballDAO.php';
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
require_once __DIR__ . '/../Modele/DAO/ParticiperDAO.php';

$matchDAO = new MatchBasketballDAO();
$joueurDAO = new JoueurDAO();
$participerDAO = new ParticiperDAO();

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($searchTerm !== '') {
    $joueurs = $joueurDAO->search($searchTerm);
} else {
    $joueurs = $joueurDAO->getAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table des joueurs</title>
    <link rel="stylesheet" href="../css/principale.css">
    <link rel="stylesheet" href="../css/joueur.css">
</head>

<body>
<div class="app">

    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <span class="brand-text">Gestion Matchs</span>
        </div>

        <nav class="nav">
            <a class="nav-item active" href="FenetrePrincipale.php">🏠 Dashboard</a>
            <a class="nav-item" href="FenetreJoueur.php">👥 Joueurs</a>
        </nav>
    </aside>

    <div class="main">
        <div class="content">

            <div class="joueur">
                <h1>Joueurs</h1>

                <!-- ADD BUTTON -->
                <a href="../Controlleur/GestionFenetreJoueur.php?action=add">
                    ➕ Ajouter un joueur
                </a>

                <form method="GET" class="rechercher">
                    <input
                        type="text"
                        name="search"
                        placeholder="Rechercher un joueur..."
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                    >
                    <button type="submit">Filtrer</button>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>Numéro Licence</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de Naissance</th>
                            <th>Taille (cm)</th>
                            <th>Poids (kg)</th>
                            <th>Statut</th>
                            <th>Commentaire</th>
                            <th>Actions</th> <!-- ADDED -->
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($joueurs)): ?>
                            <?php foreach ($joueurs as $j): ?>
                                <tr>
                                    <td><?= htmlspecialchars($j['NumeroLicence']) ?></td>
                                    <td><?= htmlspecialchars($j['Nom']) ?></td>
                                    <td><?= htmlspecialchars($j['Prenom']) ?></td>
                                    <td><?= htmlspecialchars($j['DateDeNaissance']) ?></td>
                                    <td><?= htmlspecialchars($j['Taille_cm']) ?></td>
                                    <td><?= htmlspecialchars($j['Poids_kg']) ?></td>
                                    <td><?= htmlspecialchars($j['Statut']) ?></td>
                                    <td><?= htmlspecialchars($j['Commentaire']) ?></td>

                                    <!-- ACTIONS -->
                                    <td>
                                        <a href="../Controlleur/GestionFenetreJoueur.php?action=edit&id=<?= $j['NumeroLicence'] ?>">✏️</a>
                                        <a href="../Controlleur/GestionFenetreJoueur.php?action=delete&id=<?= $j['NumeroLicence'] ?>"
                                           onclick="return confirm('Supprimer ce joueur ?');">
                                           🗑️
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9">Aucun joueur trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
</body>
</html>
