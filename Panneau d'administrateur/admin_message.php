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
    <section class="message-container">
    <div class="heading">
        <!--<h1>Tableau de bord</h1>-->
    </div>
<div class="box-container">
    <?php
    $select_message = $conn->prepare("SELECT * FROM `message` ");
    $select_message->execute();
    if($select_message->rowCount() > 0){
     while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){


        ?>
        <div class="box">
            <h3 class="name"><?= $fetch_message['Nom']; ?></h3>
            <h4><?= $fetch_message['sujet']; ?></h4>
            <p><?= $fetch_message['message']; ?></p>
            <form action="" method="post">
                <input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">
                <input type="submit" name="delete_msg" value="supprimer un message" class="btn" onclick="return confirm('Voulez-vous vraiment supprimer ce message ?');">
            </form>
        </div>
        <?php
     }
    }else{
        echo  '
            <div class="empty">
                     <p>Aucun message non lu</p>
            </div>
            ';
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













