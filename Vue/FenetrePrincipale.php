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
      <a class="nav-item" href="fenetre_joueur.html"><span class="nav-ico">👥</span> Joueurs</a>
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

      <!-- CARDS -->
      <div class="cards">

        <div class="card">
          <div class="card-title">Total Joueurs</div>
          <div class="card-value">42</div>
        </div>

        <div class="card">
          <div class="card-title">Total Matchs</div>
          <div class="card-value">18</div>
        </div>

        <div class="card">
          <div class="card-title">Matchs Prévu</div>
          <div class="card-value">4</div>
        </div>

        <div class="card">
          <div class="card-title">Matchs Terminés</div>
          <div class="card-value">14</div>
        </div>
      </div>

      <!-- UPCOMING MATCHES -->
      <div class="panel">
        <div class="panel-header">
          <h2>Prochains Matchs</h2>
        </div>

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
            <tr>
              <td>15/01/2025</td>
              <td>18:00</td>
              <td>Tigers</td>
              <td>Domicile</td>
              <td><span class="status avenir">À venir</span></td>
            </tr>
            <tr>
              <td>22/01/2025</td>
              <td>20:30</td>
              <td>Wolves</td>
              <td>Extérieur</td>
              <td><span class="status avenir">À venir</span></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- RECENT RESULTS -->
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
            <tr>
              <td>08/01/2025</td>
              <td>Eagles</td>
              <td><span class="status victoire">Victoire</span></td>
              <td>79 / 61</td>
            </tr>
            <tr>
              <td>03/01/2025</td>
              <td>Bulls</td>
              <td><span class="status defaite">Défaite</span></td>
              <td>68 / 71</td>
            </tr>
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
            <tr>
              <td>Martin Dupont</td>
              <td>189</td>
              <td>12</td>
            </tr>
            <tr>
              <td>Julien Arnaud</td>
              <td>172</td>
              <td>12</td>
            </tr>
            <tr>
              <td>Kilian Morel</td>
              <td>155</td>
              <td>11</td>
            </tr>
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
