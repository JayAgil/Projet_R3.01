<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un joueur</title>
    <link rel="stylesheet" href="../css/joueur.css">
</head>

<div class="form-joueur">
  <h1>Ajouter un joueur</h1>

  <form method="GET" action="../Controlleur/GestionFenetreJoueur.php">

      <input type="hidden" name="action" value="store">

      <label>Numéro Licence</label>
      <input type="text" name="NumeroLicence" required>

      <label>Nom</label>
      <input type="text" name="Nom" required>

      <label>Prénom</label>
      <input type="text" name="Prenom" required>

      <label>Date de naissance</label>
      <input type="date" name="DateDeNaissance">

      <label>Taille (cm)</label>
      <input type="number" name="Taille_cm">

      <label>Poids (kg)</label>
      <input type="number" name="Poids_kg">

      <label>Statut</label>
      <input type="text" name="Statut">

      <label>Commentaire</label>
      <textarea name="Commentaire"></textarea>

      <div class="form-buttons">
          <button type="submit">Ajouter</button>
          <a href="/Projet_R3.01/Vue/FenetreJoueur.php">Annuler</a>
      </div>
  </form>
</div>
</html>