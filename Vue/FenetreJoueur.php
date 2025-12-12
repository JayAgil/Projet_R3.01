
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table des joueurs</title>
</head>
<body>

<h1>Joueurs</h1>

<table border="1">
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

</body>
</html>
