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
    <div class="container">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <svg class="logo" viewBox="0 0 24 24"><path d="M3 3h8v8H3zM13 3h8v8h-8zM3 13h8v8H3zM13 13h8v8h-8z"/></svg>
                <span class="brand-text">Gestion Matchs</span>
                <button class="btn-toggle" id="btnToggle">☰</button>
            </div>

            <nav class="nav">
                <a class="nav-item active" href="FenetrePrincipale.php"><span class="nav-ico">🏠</span> Dashboard</a>
                <a class="nav-item" href="FenetreJoueur.php"><span class="nav-ico">👥</span> Joueurs</a>
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

        <main class="main-content">
            <div class="joueur">
                <h1>Joueurs</h1>

                <form method="GET" class="rechercher">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Rechercher un joueur..." 
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                        style="padding: 8px; width: 250px;"
                    >
                    <button type="submit">Filtrer</button>
                </form>

                <table>
                    <tr>
                        <th>Numéro Licence</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de Naissance</th>
                        <th>Taille (cm)</th>
                        <th>Poids (kg)</th>
                        <th>Statut</th>
                        <th>Commentaire</th>
                    </tr>

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
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">Aucun joueur trouvé.</td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
