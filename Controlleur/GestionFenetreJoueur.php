<?php
require_once __DIR__ . '/../Modele/DAO/JoueurDAO.php';

$joueurDAO = new JoueurDAO();
$action = $_GET['action'] ?? '';

if ($action === 'add') {
    require __DIR__ . '/../Vue/FenetreAjouterJoueur.php';
}

if ($action === 'edit' && isset($_GET['id'])) {
    $joueur = $joueurDAO->getById($_GET['id']);
    require __DIR__ . '/../Vue/FenetreModifierJoueur.php';
}

if ($action === 'delete' && isset($_GET['id'])) {
    $joueurDAO->delete($_GET['id']);
    header('Location: ../Vue/FenetreJoueur.php');
    exit;
}
