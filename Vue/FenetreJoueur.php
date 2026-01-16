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

    <main class="main">
        <section class="content">
            <div class="joueur">
                <h1>Joueurs</h1>

                <form method="GET" action="../Controlleur/GestionFenetreJoueur.php" style="margin-bottom:16px;">
                    <input type="hidden" name="action" value="add">
                    <button type="submit" style="padding:8px 14px; border-radius:8px; border:1px solid rgba(11,18,32,0.15); background:#fff; cursor:pointer;">
                        ➕ Ajouter un joueur
                    </button>
                </form>

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
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
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
                                <td>
                                    <div class="actions-group" style="display:flex; gap:6px;">

                                        <form method="GET" action="../Controlleur/GestionFenetreJoueur.php">
                                            <input type="hidden" name="action" value="edit">
                                            <input type="hidden" name="NumeroLicence" value="<?= htmlspecialchars($j['NumeroLicence']) ?>">
                                            <button type="submit" style="padding:4px 8px; border-radius:6px; border:1px solid rgba(11,18,32,0.15); background:#fff; cursor:pointer;">
                                                ✏️
                                            </button>
                                        </form>

                                        <form method="GET" action="../Controlleur/GestionFenetreJoueur.php" onsubmit="return confirm('Supprimer ce joueur ?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($j['NumeroLicence']) ?>">
                                            <button type="submit" style="padding:4px 8px; border-radius:6px; border:1px solid rgba(11,18,32,0.15); background:#fff; cursor:pointer;">
                                                🗑️
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($joueurs)): ?>
                            <tr>
                                <td colspan="9" style="text-align:center; padding:20px; color:var(--muted);">
                                    Aucun joueur trouvé.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </section>
    </main>
</div>

</body>
</html>
