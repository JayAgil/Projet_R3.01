<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un joueur</title>
    <link rel="stylesheet" href="/Projet_R3.01/css/joueur.css">
</head>
<body>
    <div class="form-joueur">
        <h1>Modifier un joueur</h1>
        <?php if (!isset($joueur) || !$joueur): ?>
            <p>Erreur : joueur introuvable.</p>
            <a href="../index.php?action=joueurs">Retour à la liste</a>
        <?php else: ?>
            <form method="GET" action="/Projet_R3.01/index.php">

                <input type="hidden" name="action" value="update">
                <!-- Numéro de licence (identifiant unique du joueur) -->
                <input type="hidden" name="NumeroLicence" value="<?= htmlspecialchars($joueur->getNumeroLicence()) ?>">
                
                <!-- Champ : Numéro de licence -->
                <div>
                    <label>Numéro Licence</label>
                    <input type="text" value="<?= htmlspecialchars($joueur->getNumeroLicence()) ?>" disabled>
                </div>
                
                <!-- Champ : Nom du joueur -->
                <div>
                    <label>Nom</label>
                    <input type="text" name="Nom" value="<?= htmlspecialchars($joueur->getNom()) ?>" required>
                </div>
                
                <!-- Champ : Prénom du joueur -->
                <div>
                    <label>Prénom</label>
                    <input type="text" name="Prenom" value="<?= htmlspecialchars($joueur->getPrenom()) ?>" required>
                </div>
                
                <!-- Champ : Date de naissance -->
                <div>
                    <label>Date de naissance</label>
                    <input type="date" name="DateDeNaissance" value="<?= htmlspecialchars($joueur->getDateNaissance()) ?>">
                </div>
                
                <!-- Champ : Taille en centimètres -->
                <div>
                    <label>Taille (cm)</label>
                    <input type="number" name="Taille_cm" value="<?= htmlspecialchars($joueur->getTaille()) ?>">
                </div>
                
                <!-- Champ : Poids en kilogrammes -->
                <div>
                    <label>Poids (kg)</label>
                    <input type="number" name="Poids_kg" value="<?= htmlspecialchars($joueur->getPoids()) ?>">
                </div>
                
                <!-- Champ : Statut du joueur -->
                <div>
                    <label>Statut</label>
                    <input type="text" name="Statut" value="<?= htmlspecialchars($joueur->getStatut()) ?>">
                </div>
                
                <!-- Champ : Commentaire libre sur le joueur -->
                <div>
                    <label>Commentaire</label>
                    <textarea name="Commentaire"><?= htmlspecialchars($joueur->getCommentaire()) ?></textarea>
                </div>
                
                <!-- Boutons d'action : Enregistrer les modifications ou Annuler -->
                <div class="form-buttons">
                    <button type="submit">Enregistrer</button>
                    <a href="/Projet_R3.01/index.php?action=joueurs">Annuler</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>