<?php
if (!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}

require_once __DIR__ . '/../Modele/DAO/MatchBasketballDAO.php';
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
require_once __DIR__ . '/../Modele/DAO/ParticiperDAO.php';

$matchDAO = new MatchBasketballDAO();
$joueurDAO = new JoueurDAO();
$participerDAO = new ParticiperDAO();

if (!isset($_GET['date'], $_GET['heure'])) {
    die("Match non spécifié");
}

$date  = $_GET['date'];
$heure = $_GET['heure'];

$match = $matchDAO->getMatchByDateHeure($date, $heure);
if (!$match) {
    die("Match introuvable");
}

$matchID = $match['MatchID'];
$joueurs = $participerDAO->getJoueursParMatch($matchID);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $resultat = $_POST['resultat'];
    $pointsAdv = (int) $_POST['points_adv'];

    $matchDAO->updateResultat($date, $heure, $resultat);
    $matchDAO->updateStatut($date, $heure, 'Termine');

    $matchID = $match['MatchID'];

    foreach ($_POST['joueurs'] as $licence => $data) {
        $participerDAO->insertParticipationSimple(
            $licence,
            $matchID,
            (int)$data['points'],
            isset($data['titulaire']) ? 1 : 0,
            isset($data['joue']) ? 1 : 0,
            $data['note'] !== '' ? (float)$data['note'] : null
        );
    }

    header("Location: FenetrePrincipale.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Saisie Résultat</title>
<link rel="stylesheet" href="css/principale.css">
<link rel="stylesheet" href="css/resultat.css">
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
    <a class="nav-item" href="/Projet_R3.01/index.php?action=dashboard">🏠 Dashboard</a>
    <a class="nav-item" href="/Projet_R3.01/index.php?action=joueurs">👥 Joueurs</a>
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

<div class="main">
<div class="content">

<h1>Saisie du résultat</h1>

<p class="muted">
<?= $match['DateDeMatch'] ?> – <?= $match['HeureDeMatch'] ?><br>
vs <?= htmlspecialchars($match['NomEquipeAdversaire']) ?>
</p>

<form method="POST">

<div class="result-box">
    <label>Résultat</label>
    <select name="resultat" required>
        <option value="Victoire">Victoire</option>
        <option value="Defaite">Défaite</option>
        <option value="Nul">Nul</option>
    </select>

    <label>Points adverses</label>
    <input type="number" name="points_adv" value="0" min="0" required>
</div>

<h2>Feuille de match</h2>

<table class="table">
<thead>
<tr>
    <th>Joueur</th>
    <th>Points</th>
    <th>Est Titulaire</th>
    <th>A joué</th>
    <th>Note</th>
</tr>
</thead>
<tbody>
<?php foreach ($joueurs as $j): ?>
<tr>
    <td><?= htmlspecialchars($j['Nom'].' '.$j['Prenom']) ?></td>
    <td>
        <input type="number" name="joueurs[<?= $j['NumeroLicence'] ?>][points]" value="<?= $j['NbPointsMarque'] ?? 0 ?>" min="0">
    </td>
    <td>
        <?= isset($j['EstTitulaire']) && $j['EstTitulaire'] ? '✔' : '❌' ?>
    </td>
    <td>
        <?php if (isset($j['EstTitulaire']) && $j['EstTitulaire']): ?>
            <input type="checkbox" name="joueurs[<?= $j['NumeroLicence'] ?>][joue]" <?= isset($j['Joue']) && $j['Joue'] ? 'checked' : '' ?>>
        <?php else: ?>
            <span style="color: gray;">N/A</span>
        <?php endif; ?>
    </td>
    <td>
        <input type="number" step="0.1" min="0" max="10"
               name="joueurs[<?= $j['NumeroLicence'] ?>][note]" value="<?= $j['Note'] ?? '' ?>">
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>



<button class="btn-primary">💾 Enregistrer</button>

</form>

</div>
</div>
</div>
</body>
</html>
