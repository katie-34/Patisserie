<?php
include 'connexion.php';

setcookie('id_utilisateur', '', time() - 1, '/');
header('Location: home.php');
exit();
?>
