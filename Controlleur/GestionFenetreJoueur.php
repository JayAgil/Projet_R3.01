<?php
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';
require_once __DIR__ . '/../Modele/Joueur.php'; // Include Joueur class

$joueurDAO = new JoueurDAO();
$action = $_GET['action'] ?? '';

// ----------------------------
// SHOW ADD FORM
// ----------------------------
if ($action === 'add') {
    require __DIR__ . '/../Vue/FenetreAjouterJoueur.php';
    exit;
}

// ----------------------------
// STORE NEW JOUER
// ----------------------------
if ($action === 'store') {
    // Create a Joueur object from GET data
    $nouveauJoueur = new Joueur(
        $_GET['NumeroLicence'],
        $_GET['Nom'],
        $_GET['Prenom'],
        $_GET['DateDeNaissance'],
        $_GET['Taille_cm'],
        $_GET['Poids_kg'],
        $_GET['Statut'],
        $_GET['Commentaire']
    );

    $joueurDAO->insert($nouveauJoueur);

    // Redirect to table after adding
    header('Location: ../Vue/FenetreJoueur.php');
    exit;
}

// ----------------------------
// SHOW EDIT FORM
// ----------------------------
if ($action === 'edit' && isset($_GET['id'])) {
    $joueur = $joueurDAO->getById($_GET['id']);
    require __DIR__ . '/../Vue/FenetreModifierJoueur.php';
    exit;
}

// ----------------------------
// UPDATE JOUER
// ----------------------------
if ($action === 'update' && isset($_GET['NumeroLicence'])) {
    // Create a Joueur object with updated data
    $joueurModifie = new Joueur(
        $_GET['NumeroLicence'],
        $_GET['Nom'],
        $_GET['Prenom'],
        $_GET['DateDeNaissance'],
        $_GET['Taille_cm'],
        $_GET['Poids_kg'],
        $_GET['Statut'],
        $_GET['Commentaire']
    );

    $joueurDAO->update($joueurModifie);

    // Redirect to table after updating
    header('Location: ../Vue/FenetreJoueur.php');
    exit;
}

// ----------------------------
// DELETE JOUER
// ----------------------------
if ($action === 'delete' && isset($_GET['id'])) {
    $joueurDAO->delete($_GET['id']);
    header('Location: ../Vue/FenetreJoueur.php');
    exit;
}
