<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include '../Composants/connexion.php';

if (isset($_COOKIE['id_administrateur'])) {
    $id_administrateur = $_COOKIE['id_administrateur'];
} else {
    header('Location:formulaireconn.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Page d'administration</title>
    <link rel="stylesheet" type="text/css" href="../css/administrateur.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../Composants/administrateur_entete.php'; ?>
    <section class="user-container">
    <div class="heading">
        <!--<h1>Tableau de bord</h1>-->
    </div>
<div class="box-container">
    <?php
    $select_users = $conn->prepare("SELECT * FROM `utilisateurs`");
    $select_users->execute();

    if($select_users->rowCount() > 0){
        while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
            $user_id = $fetch_users['id'];


    ?>
    <div class="box">
        <img src="../fichiers_téléchargés/<?= $fetch_users['image']; ?>" alt="">
        <p>id utilisateurs : <span><?= $user_id; ?></span></p>
        <p>Nom d'utilisateur : <span><?= $fetch_users['Nom']; ?></span></p>
        <p>Email d'utilisateur : <span><?= $fetch_users['Email']; ?></span></p>
    </div>
    <?php
        }
    }else{

    }
    
    ?>
</div>
 </section>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/administrateur_script.js"></script>
<?php include '../Composants/alert.php'; ?>

</body>
</html>













