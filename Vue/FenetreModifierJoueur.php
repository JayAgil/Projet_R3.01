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

<form method="POST" action="../Controleur/GestionFenetreJoueur.php?action=update">

    <input type="hidden" name="NumeroLicence" value="<?= htmlspecialchars($joueur['NumeroLicence']) ?>">

    <label>Numéro Licence</label><br>
    <input type="text" value="<?= htmlspecialchars($joueur['NumeroLicence']) ?>" disabled><br><br>

    <label>Nom</label><br>
    <input type="text" name="Nom" value="<?= htmlspecialchars($joueur['Nom']) ?>" required><br><br>

    <label>Prénom</label><br>
    <input type="text" name="Prenom" value="<?= htmlspecialchars($joueur['Prenom']) ?>" required><br><br>

    <label>Date de naissance</label><br>
    <input type="date" name="DateDeNaissance" value="<?= htmlspecialchars($joueur['DateDeNaissance']) ?>"><br><br>

    <label>Taille (cm)</label><br>
    <input type="number" name="Taille_cm" value="<?= htmlspecialchars($joueur['Taille_cm']) ?>"><br><br>

    <label>Poids (kg)</label><br>
    <input type="number" name="Poids_kg" value="<?= htmlspecialchars($joueur['Poids_kg']) ?>"><br><br>

    <label>Statut</label><br>
    <input type="text" name="Statut" value="<?= htmlspecialchars($joueur['Statut']) ?>"><br><br>

    <label>Commentaire</label><br>
    <textarea name="Commentaire"><?= htmlspecialchars($joueur['Commentaire']) ?></textarea><br><br>

    <button type="submit">Enregistrer</button>
    <a href="FenetreJoueur.php">Annuler</a>

</form>
</div>
</body>
</html>
