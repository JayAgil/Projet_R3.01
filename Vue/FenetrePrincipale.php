<?php
    require_once __DIR__ . '/../Modele/DAO/MatchBasketballDAO.php';
    require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
    require_once __DIR__ . '/../Modele/DAO/ParticiperDAO.php';

    $matchDAO = new MatchBasketballDAO();
    $joueurDAO = new JoueurDAO();
    $participerDAO = new ParticiperDAO();

    $totalMatchs = count($matchDAO->getAllMatches());  
    $matchsCeMois = $matchDAO->getNbMatchCeMois();     
    $victoires = $matchDAO->getNbMatch("Victoire");    
    $defaites = $matchDAO->getNbMatch("Défaite");     
    $totalJoueurs = count($joueurDAO->getAllJoueurs()); 

    $matchsAvenir = $matchDAO->getMatchsAvenir();       
    $recentResults = $matchDAO->getAllMatches();        
    $topPlayers = $matchDAO->getTopScorers();  
?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestionnaire des Matchs – Dashboard</title>
  <link rel="stylesheet" href="../css/principale.css" />
</head>
<body>

<div class="app">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="brand">
      <svg class="logo" viewBox="0 0 24 24"><path d="M3 3h8v8H3zM13 3h8v8h-8zM3 13h8v8H3zM13 13h8v8h-8z"/></svg>
      <span class="brand-text">Gestion Matchs</span>
      <button class="btn-toggle" id="btnToggle">☰</button>
    </div>

    <nav class="nav">
      <a class="nav-item active" href="#"><span class="nav-ico">🏠</span> Dashboard</a>
      <a class="nav-item" href="fenetre_match.html"><span class="nav-ico">🏀</span> Matchs</a>
      <a class="nav-item" href="feuille_de_match.html"><span class="nav-ico">📄</span> Feuilles de match</a>
      <a class="nav-item" href="../Vue/FenetreJoueur.php"><span class="nav-ico">👥</span> Joueurs</a>
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

  <!-- MAIN AREA -->
  <main class="main">

    <!-- TOPBAR -->
    <header class="topbar">
      <h2 class="page-header">Dashboard</h2>
      <div class="top-actions">
        <button class="icon-btn">🔔</button>
        <button class="icon-btn">✉️</button>
        <div class="profile">
          <div class="avatar small">AD</div>
          Admin
        </div>
      </div>
    </header>

    <!-- CONTENT -->
    <section class="content">

        <div class="cards">

            <div class="card">
                <div class="card-title">Total Joueurs</div>
                <div class="card-value"><?= $totalJoueurs ?></div>
            </div>

            <div class="card">
                <div class="card-title">Total Matchs</div>
                <div class="card-value"><?= $totalMatchs ?></div>
            </div>

            <div class="card">
                <div class="card-title">Matchs Prévu</div>
                <div class="card-value"><?= count($matchsAvenir) ?></div>
            </div>

            <div class="card">
                <div class="card-title">Matchs Terminés</div>
                <div class="card-value"><?= $victoires + $defaites ?></div>
            </div>
        </div>


      <!-- UPCOMING MATCHES -->
      <div class="panel">
        <div class="panel-header">
          <h2>Prochains Matchs</h2>
        </div>

        <!-- Match Avenir -->
        <table class="table">
          <thead>
            <tr>
              <th>Date</th>
              <th>Heure</th>
              <th>Adversaire</th>
              <th>Lieu</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($matchsAvenir as $m): ?>
              <tr>
                <td><?= $m['DateDeMatch'] ?></td>
                <td><?= $m['HeureDeMatch'] ?></td>
                <td><?= $m['NomEquipeAdversaire'] ?></td>
                <td><?= $m['LieuDeRencontre'] ?></td>
                <td>
                  <span class="status avenir"><?= $m['Statut'] ?></span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>


      <!-- Resultat -->
      <div class="panel">
        <div class="panel-header">
          <h2>Résultats Récents</h2>
        </div>
              <table class="table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Adversaire</th>
                    <th>Résultat</th>
                    <th>Points (Nous / Eux)</th>
                  </tr>
                </thead>
                <tbody>

              <?php
              $compteur = 0;   // counter
              ?>

              <?php foreach ($recentResults as $r): ?>

                <?php
                // Check if match was played
                if (
                    ($r['Resultat'] == 'Victoire' ||
                    $r['Resultat'] == 'Défaite' ||
                    $r['Resultat'] == 'Nul')
                    && $compteur < 5
                ):
                    $compteur++;
                    $statusClass = strtolower($r['Resultat']);
                ?>
                  <tr>
                    <td><?= $r['DateDeMatch'] ?></td>
                    <td><?= $r['NomEquipeAdversaire'] ?></td>
                    <td>
                      <span class="status <?= $statusClass ?>">
                        <?= $r['Resultat'] ?>
                      </span>
                    </td>
                    <td><?= $r['PointsMarquesParAdversaire'] ?> / ???</td>
                  </tr>

                <?php endif; ?>

              <?php endforeach; ?>

                </tbody>
      </table>

        </div>

      <!-- TOP PLAYERS -->
      <div class="panel">
        <div class="panel-header">
          <h2>Top 5 Joueurs (Points)</h2>
        </div>

          <table class="table">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Points total</th>
                <th>Matchs joués</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($topPlayers as $p): ?>
                <tr>
                  <td><?= $p['Nom'] . ' ' . $p['Prenom'] ?></td>
                  <td><?= $p['TotalPoints'] ?></td>
                  <td>???</td> <!-- replace ??? with number of matches played if available -->
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

      </div>

    </section>

  </main>
</div>

<script>
const btn = document.getElementById('btnToggle');
const sidebar = document.getElementById('sidebar');
btn.onclick = () => sidebar.classList.toggle('collapsed');
</script>

</body>
</html>
