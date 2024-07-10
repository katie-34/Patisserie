<?php
include 'connexion.php';

setcookie('id_administrateur', '', time() - 1, '/');
header('Location: ../Panneau%20d\'administrateur/formulaireconn.php');
exit();
?>
