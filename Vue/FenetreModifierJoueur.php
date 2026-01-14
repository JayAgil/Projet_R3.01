<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un joueur</title>
    <link rel="stylesheet" href="../css/joueur.css">
</head>
<body>

<div class="form-joueur">
    <h1>Modifier un joueur</h1>

    <form method="GET" action="../Controlleur/GestionFenetreJoueur.php">

        <!-- Hidden inputs to tell controller what to do -->
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="NumeroLicence" value="<?= htmlspecialchars($joueur['NumeroLicence']) ?>">

        <label>Numéro Licence</label>
        <input type="text" value="<?= htmlspecialchars($joueur['NumeroLicence']) ?>" disabled>

        <label>Nom</label>
        <input type="text" name="Nom" value="<?= htmlspecialchars($joueur['Nom']) ?>" required>

        <label>Prénom</label>
        <input type="text" name="Prenom" value="<?= htmlspecialchars($joueur['Prenom']) ?>" required>

        <label>Date de naissance</label>
        <input type="date" name="DateDeNaissance" value="<?= htmlspecialchars($joueur['DateDeNaissance']) ?>">

        <label>Taille (cm)</label>
        <input type="number" name="Taille_cm" value="<?= htmlspecialchars($joueur['Taille_cm']) ?>">

        <label>Poids (kg)</label>
        <input type="number" name="Poids_kg" value="<?= htmlspecialchars($joueur['Poids_kg']) ?>">

        <label>Statut</label>
        <input type="text" name="Statut" value="<?= htmlspecialchars($joueur['Statut']) ?>">

        <label>Commentaire</label>
        <textarea name="Commentaire"><?= htmlspecialchars($joueur['Commentaire']) ?></textarea>

        <div class="form-buttons">
            <button type="submit">Enregistrer</button>
            <a href="FenetreJoueur.php">Annuler</a>
        </div>

    </form>
</div>

</body>
</html>
