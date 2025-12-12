<?php
require("../Modele/Dao/JoueurDAO.php");

$dao = new JoueurDAO();
$joueurs = $dao->getAll();   

require("../Vue/FenetreJoueur.php");
?>