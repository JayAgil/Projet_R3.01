<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un joueur</title>
    <link rel="stylesheet" href="/Projet_R3.01/css/joueur.css">
</head>
<body>

<div class="form-joueur">
    <h1>Ajouter un joueur</h1>
    
    <form method="GET" action="/Projet_R3.01/index.php">
        <input type="hidden" name="action" value="store">
        
        <div>
            <label>Numéro Licence</label>
            <input type="text" name="NumeroLicence" required>
        </div>
        
        <div>
            <label>Nom</label>
            <input type="text" name="Nom" required>
        </div>
        
        <div>
            <label>Prénom</label>
            <input type="text" name="Prenom" required>
        </div>
        
        <div>
            <label>Date de naissance</label>
            <input type="date" name="DateDeNaissance">
        </div>
        
        <div>
            <label>Taille (cm)</label>
            <input type="number" name="Taille_cm">
        </div>
        
        <div>
            <label>Poids (kg)</label>
            <input type="number" name="Poids_kg">
        </div>
        
        <div>
            <label>Statut</label>
            <input type="text" name="Statut">
        </div>
        
        <div>
            <label>Commentaire</label>
            <textarea name="Commentaire"></textarea>
        </div>
        
        <div class="form-buttons">
            <button type="submit">Ajouter</button>
            <a href="/Projet_R3.01/index.php?action=joueurs">Annuler</a>
        </div>
    </form>
</div>

</body>
</html>