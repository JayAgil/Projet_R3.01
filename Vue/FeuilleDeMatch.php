<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Feuille de Match</title>
<link rel="stylesheet" href="css/feuilleDeMatch.css">
</head>
<body>

<div class="container">
    <!-- Left panel: active players -->
    <div class="left-panel">
        <h2>Joueurs actifs</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Commentaire</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($players as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['Nom']) ?></td>
                    <td><?= htmlspecialchars($p['Prenom']) ?></td>
                    <td><?= htmlspecialchars($p['Taille_cm']) ?> cm</td>
                    <td><?= htmlspecialchars($p['Poids_kg']) ?> kg</td>
                    <td><?= htmlspecialchars($p['Commentaire']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Right panel: court + selections -->
    <div class="right-panel">
        <h2>Feuille de match</h2>
        <form method="POST">
            <!-- Court with 5 titular spots -->
            <div class="court">
                <?php for($i=1; $i<=5; $i++): ?>
                    <select name="titular[]">
                        <option value="">Position <?= $i ?></option>
                        <?php foreach($players as $p): ?>
                        <option value="<?= $p['NumeroLicence'] ?>"><?= $p['Nom'].' '.$p['Prenom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endfor; ?>
            </div>

            <!-- Substitutes -->
            <h3>Remplaçants</h3>
            <div class="substitutes">
                <?php for($i=1; $i<=12; $i++): ?>
                    <select name="substitute[]">
                        <option value="">Remplaçant <?= $i ?></option>
                        <?php foreach($players as $p): ?>
                        <option value="<?= $p['NumeroLicence'] ?>"><?= $p['Nom'].' '.$p['Prenom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endfor; ?>
            </div>

            <button type="submit">Enregistrer</button>
        </form>

        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    </div>
</div>

</body>
</html>
