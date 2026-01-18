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
        
        <!-- Formulaire d'ajout - envoie les données via GET à index.php -->
        <form method="GET" action="/Projet_R3.01/index.php">
            <input type="hidden" name="action" value="store">
            
            <!-- Champ : Numéro de licence -->
            <div>
                <label>Numéro Licence</label>
                <input type="text" name="NumeroLicence" required>
            </div>
            
            <!-- Champ : Nom du joueur -->
            <div>
                <label>Nom</label>
                <input type="text" name="Nom" required>
            </div>
            
            <!-- Champ : Prénom du joueur -->
            <div>
                <label>Prénom</label>
                <input type="text" name="Prenom" required>
            </div>
            
            <!-- Champ : Date de naissance -->
            <div>
                <label>Date de naissance</label>
                <input type="date" name="DateDeNaissance">
            </div>
            
            <!-- Champ : Taille en centimètres -->
            <div>
                <label>Taille (cm)</label>
                <input type="number" name="Taille_cm">
            </div>
            
            <!-- Champ : Poids en kilogrammes -->
            <div>
                <label>Poids (kg)</label>
                <input type="number" name="Poids_kg">
            </div>
            
            <!-- Champ : Statut du joueur -->
            <div>
                <label>Statut</label>
                <input type="text" name="Statut">
            </div>
            
            <!-- Champ : Commentaire libre sur le joueur -->
            <div>
                <label>Commentaire</label>
                <textarea name="Commentaire"></textarea>
            </div>
            
            <!-- Boutons d'action : Ajouter ou Annuler -->
            <div class="form-buttons">
                <button type="submit">Ajouter</button>
                <a href="/Projet_R3.01/index.php?action=joueurs">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>