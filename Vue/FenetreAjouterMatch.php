<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Ajouter un Match</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Main shared style -->
    <link rel="stylesheet" href="/Projet_R3.01/css/principale.css">
    <!-- Page specific -->
    <link rel="stylesheet" href="/Projet_R3.01/css/ajouterMatch.css">
</head>
<body>

<div class="app">

    <!-- ===== SIDEBAR ===== -->
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
            <a class="nav-item active" href="/Projet_R3.01/index.php?action=ajouterMatch">
                <span>➕</span><span class="label">Ajouter Match</span>
            </a>
            <a class="nav-item" href="/Projet_R3.01/index.php?action=statistiques">
                <span>📊</span><span class="label">Statistiques</span>
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

    <!-- ===== MAIN ===== -->
    <main class="main">
        <header class="topbar">
            <h2>Ajouter un Match</h2>
        </header>

        <section class="content">

            <div class="match-card">
                <h3>📝 Nouveau Match</h3>

                <form action="/Projet_R3.01/index.php?action=saveMatch" method="POST" class="match-form">

                    <div class="row">
                        <div class="field-group">
                            <label>Date du match</label>
                            <input type="date" name="date" required>
                        </div>

                        <div class="field-group">
                            <label>Heure</label>
                            <input type="time" name="heure" required>
                        </div>
                    </div>

                    <div class="field-group">
                        <label>Équipe adverse</label>
                        <input type="text" name="equipe" placeholder="Nom de l'équipe" required>
                    </div>

                    <div class="field-group">
                        <label>Lieu de rencontre</label>
                        <input type="text" name="lieu" placeholder="Salle / Stade" required>
                    </div>

                    <div class="row">
                        <div class="field-group">
                            <label>Résultat</label>
                            <select name="resultat">
                                <option value="">— Non défini —</option>
                                <option value="Victoire">Victoire</option>
                                <option value="Défaite">Défaite</option>
                                <option value="N/A">N/A</option>
                            </select>
                        </div>

                        <div class="field-group">
                            <label>Points adversaire</label>
                            <input type="number" name="pointsAdv" value="0" min="0">
                        </div>
                    </div>

                    <div class="field-group">
                        <label>Statut</label>
                        <select name="statut">
                            <option value="Avenir">À venir</option>
                            <option value="Prepare">Préparé</option>
                            <option value="Termine">Terminé</option>
                        </select>
                    </div>

                    <button type="submit">➕ Ajouter le match</button>

                </form>
            </div>

        </section>
    </main>
</div>
</body>
</html>
