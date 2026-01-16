<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard – Gestion Matchs</title>
  <link rel="stylesheet" href="../css/principale.css" />
</head>
<body>

<div class="app">
  <aside class="sidebar" id="sidebar">
    <div class="brand">
      <svg class="logo" viewBox="0 0 24 24"><path d="M3 3h8v8H3zM13 3h8v8h-8zM3 13h8v8H3zM13 13h8v8h-8z"/></svg>
      <span class="brand-text">Gestion Matchs</span>
      <button class="btn-toggle" id="btnToggle">☰</button>
    </div>

    <nav class="nav">
      <a class="nav-item active" href="FenetrePrincipale.php">🏠 Dashboard</a>
      <a class="nav-item" href="FenetreJoueur.php">👥 Joueurs</a>
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
    <header class="topbar">
      <h2 style="margin:0; font-size:18px;">Tableau de Bord</h2>
      <div class="top-actions">
        <div class="profile">
          <div class="avatar" style="width:32px; height:32px; font-size:12px; background:var(--accent);">AD</div>
          <span style="font-weight:600; margin-left:8px;">Admin</span>
        </div>
      </div>
    </header>

    <section class="content">
      <div class="cards">
          <div class="card"><div class="card-title">Joueurs</div><div class="card-value"><?= $totalJoueurs ?></div></div>
          <div class="card"><div class="card-title">Matchs Totaux</div><div class="card-value"><?= $totalMatchs ?></div></div>
          <div class="card"><div class="card-title">À Venir</div><div class="card-value"><?= count($matchsAvenir) ?></div></div>
          <div class="card"><div class="card-title">Terminés</div><div class="card-value"><?= $victoires + $defaites ?></div></div>
      </div>

      <div class="panel">
        <div class="panel-header"><h2>Prochains Matchs</h2></div>
        <table class="table">
          <thead>
            <tr>
              <th>Date / Heure</th>
              <th>Adversaire</th>
              <th>Lieu</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($matchsAvenir as $m): ?>
              <tr>
                <td><strong><?= $m['DateDeMatch'] ?></strong><br><small><?= $m['HeureDeMatch'] ?></small></td>
                <td><?= $m['NomEquipeAdversaire'] ?></td>
                <td><?= $m['LieuDeRencontre'] ?></td>
                <td><span class="status avenir"><?= $m['Statut'] ?></span></td>
                <td>
                  <div class="actions-group">
                    <form action="FenetreAjouterResultat.php" method="GET">
                        <input type="hidden" name="date" value="<?= $m['DateDeMatch'] ?>">
                        <input type="hidden" name="heure" value="<?= $m['HeureDeMatch'] ?>">
                        <button type="submit" class="btn-action"><span>➕</span> Résultat</button>
                    </form>
                    <form action="../index.php" method="POST">
                        <input type="hidden" name="DateDeMatch" value="<?= $m['DateDeMatch'] ?>">
                        <input type="hidden" name="HeureDeMatch" value="<?= $m['HeureDeMatch'] ?>">
                        <button type="submit" class="btn-action"><span>📋</span> Feuille</button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="stats-stack">
        <div class="panel">
          <div class="panel-header"><h2>Derniers Résultats</h2></div>
          <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Adversaire</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
              <?php 
              $count = 0;
              foreach($recentResults as $r): 
                if($count < 4 && in_array($r->getResultat(), ['Victoire', 'Défaite'])): 
                $count++;
              ?>
                <tr>
                  <td><?= $r->getDateDeMatch() ?></td>
                  <td>vs <?= $r->getNomEquipeAdversaire() ?></td>
                  <td><span class="status <?= strtolower($r->getResultat()) ?>"><?= $r->getResultat() ?></span></td>
                </tr>
              <?php endif; endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="panel">
          <div class="panel-header"><h2>Top Buteurs</h2></div>
          <table class="table">
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th style="text-align:right">Points</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach(array_slice($topPlayers, 0, 5) as $p): ?>
                <tr>
                  <td><?= $p['Nom'] . ' ' . $p['Prenom'] ?></td>
                  <td style="text-align:right"><strong><?= $p['TotalPoints'] ?></strong> pts</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
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