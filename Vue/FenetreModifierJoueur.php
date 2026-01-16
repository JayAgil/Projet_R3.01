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

    <?php if (!isset($joueur) || !$joueur): ?>
        <p>Erreur : joueur introuvable.</p>
    <?php else: ?>
    <form method="GET" action="../Controlleur/GestionFenetreJoueur.php">

        <input type="hidden" name="action" value="update">
        <input type="hidden" name="NumeroLicence" value="<?= htmlspecialchars($joueur->getNumeroLicence()) ?>">

        <label>Numéro Licence</label>
        <input type="text" value="<?= htmlspecialchars($joueur->getNumeroLicence()) ?>" disabled>

        <label>Nom</label>
        <input type="text" name="Nom" value="<?= htmlspecialchars($joueur->getNom()) ?>" required>

        <label>Prénom</label>
        <input type="text" name="Prenom" value="<?= htmlspecialchars($joueur->getPrenom()) ?>" required>

        <label>Date de naissance</label>
        <input type="date" name="DateDeNaissance" value="<?= htmlspecialchars($joueur->getDateNaissance()) ?>">

        <label>Taille (cm)</label>
        <input type="number" name="Taille_cm" value="<?= htmlspecialchars($joueur->getTaille()) ?>">

        <label>Poids (kg)</label>
        <input type="number" name="Poids_kg" value="<?= htmlspecialchars($joueur->getPoids()) ?>">

        <label>Statut</label>
        <input type="text" name="Statut" value="<?= htmlspecialchars($joueur->getStatut()) ?>">

        <label>Commentaire</label>
        <textarea name="Commentaire"><?= htmlspecialchars($joueur->getCommentaire()) ?></textarea>

        <div class="form-buttons">
            <button type="submit">Enregistrer</button>
            <a href="/Projet_R3.01/Vue/FenetreJoueur.php">Annuler</a>
        </div>

    </form>
    <?php endif; ?>
</div>

</body>
</html>
