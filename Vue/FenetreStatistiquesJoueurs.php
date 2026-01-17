<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Joueurs</title>
    <link rel="stylesheet" href="/Projet_R3.01/css/principale.css">
    <link rel="stylesheet" href="/Projet_R3.01/css/joueur.css">
</head>
<body>

<div class="app">
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <svg class="logo" viewBox="0 0 24 24">
                <path d="M3 3h8v8H3zM13 3h8v8h-8zM3 13h8v8H3zM13 13h8v8h-8z"/>
            </svg>
            <span class="brand-text">Gestion Matchs</span>
            <button class="btn-toggle" id="btnToggle">☰</button>
        </div>

        <nav class="nav">
            <a class="nav-item" href="/Projet_R3.01/index.php?action=dashboard">
                <span>🏠</span><span class="label">Dashboard</span>
            </a>
            <a class="nav-item" href="/Projet_R3.01/index.php?action=joueurs">
                <span>👥</span><span class="label">Joueurs</span>
            </a>
            <a class="nav-item active" href="/Projet_R3.01/index.php?action=statistiques">
                <span>📊</span><span class="label">Statistiques</span>
            </a>
            <a class="nav-item" href="/Projet_R3.01/index.php?action=ajouterMatch">
                <span>➕</span><span class="label">Ajouter Match</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user">
                <div class="avatar">GM</div>
                <div class="user-info">
                    <div class="name">Admin</div>
                    <div class="role">Gestionnaire</div>
                </div>
            </div>
        </div>
    </aside>

    <main class="main">
        <section class="content">
            <div class="joueur">
                <h1>Statistiques des Joueurs</h1>

                <table>
                    <thead>
                        <tr>
                            <th>Joueur</th>
                            <th>Statut Actuel</th>
                            <th>Poste Préféré</th>
                            <th>Sél. Titulaire</th>
                            <th>Sél. Remplaçant</th>
                            <th>Moy. Évaluation</th>
                            <th>% Victoires</th>
                            <th>Sél. Consécutives</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($statistiques as $stat): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($stat['Nom'] . ' ' . $stat['Prenom']) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($stat['Statut']) ?></td>
                                <td><?= htmlspecialchars($stat['PostePreferere'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($stat['selections_titulaire']) ?></td>
                                <td><?= htmlspecialchars($stat['selections_remplacant']) ?></td>
                                <td><?= htmlspecialchars($stat['moyenne_evaluation']) ?>/5</td>
                                <td><?= htmlspecialchars($stat['pourcentage_victoires']) ?>%</td>
                                <td><?= htmlspecialchars($stat['selections_consecutives']) ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($statistiques)): ?>
                            <tr>
                                <td colspan="8" style="text-align:center; padding:20px; color:var(--muted);">
                                    Aucune statistique disponible.
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