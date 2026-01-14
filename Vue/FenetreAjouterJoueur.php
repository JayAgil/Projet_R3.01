<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un joueur</title>
    <link rel="stylesheet" href="../css/joueur.css">
</head>
<body>
<div class="form-joueur">
<h1>Ajouter un joueur</h1>

<form method="POST" action="../Controleur/GestionFenetreJoueur.php?action=store">

    <label>Numéro Licence</label><br>
    <input type="text" name="NumeroLicence" required><br><br>

    <label>Nom</label><br>
    <input type="text" name="Nom" required><br><br>

    <label>Prénom</label><br>
    <input type="text" name="Prenom" required><br><br>

    <label>Date de naissance</label><br>
    <input type="date" name="DateDeNaissance"><br><br>

    <label>Taille (cm)</label><br>
    <input type="number" name="Taille_cm"><br><br>

    <label>Poids (kg)</label><br>
    <input type="number" name="Poids_kg"><br><br>

    <label>Statut</label><br>
    <input type="text" name="Statut"><br><br>

    <label>Commentaire</label><br>
    <textarea name="Commentaire"></textarea><br><br>

    <button type="submit">Ajouter</button>
    <a href="FenetreJoueur.php">Annuler</a>

</form>
</div>

</body>
</html>
