<?php
require("../Modele/Dao/JoueurDAO.php");

$dao = new JoueurDAO();
$search = $_GET['search'];

if (!empty($search)) {
    $joueurs = $dao->search($search);
} else {
    $joueurs = $dao->getAll();
}

require("../Vue/FenetreJoueur.php");
?>
