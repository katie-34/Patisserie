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


//Pour modifier une commande

// Pour modifier une commande

if(isset($_POST['update_order'])){
    $order_id = $_POST['order_id'];
    $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

    $update_payment = $_POST['update_payment'];
    $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);

    $update_pay = $conn->prepare("UPDATE `commandes` SET statuts_paiement = ? WHERE id = ?");
    if($update_pay->execute([$update_payment, $order_id])) {
        $success_msg[] = "La commande a été modifiée avec succès";
    } else {
        $error_msg[] = "Une erreur s'est produite lors de la modification de la commande";
    }
}





if(isset($_POST['delete_order'])){


    $delete_id = $_POST['order_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);


    $verify_delete = $conn->prepare("SELECT * FROM `commandes` WHERE id = ?");
    $verify_delete->execute([$delete_id]);
     
    if($verify_delete->rowCount() > 0){


        $delete_order = $conn->prepare("DELETE FROM `commandes` WHERE id = ?");
        $delete_order->execute([$delete_id]);

        $success_msg[] = 'Commande supprimée';
    }else{
        $warning_msg[] = 'Cette commande a déja été supprimée';
    }
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
    <section class="order-container">
    <div class="heading">
        <!--<h1>Tableau de bord</h1>-->
    </div>
<div class="box-container">
   <?php
   $select_order = $conn->prepare("SELECT * FROM `commandes` WHERE id_administrateur = ?");
   $select_order->execute([$id_administrateur]);

   if($select_order->rowCount() > 0){
    while($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)){

        ?>
        <div class="box">
            <div class="status" style="color: <?php if($fetch_order['statuts'] == 'En cours'){
              echo "limegreen";}else{echo "red";} ?>"><?= $fetch_order['statuts']; ?></div>
              <div class="details">
                 <p>Nom du client : <span><?= $fetch_order['Nom']; ?></span></p>
                 <p>id du client : <span><?= $fetch_order['id_utilisateur']; ?></span></p>
                 <p>Commande le : <span><?= $fetch_order['date']; ?></span></p>
                 <p>Numero du client : <span><?= $fetch_order['Numero']; ?></span></p>
                 <p>Email du client : <span><?= $fetch_order['email']; ?></span></p>
                 <p>Total du prix : <span><?= $fetch_order['prix']; ?></span></p>
                 <p>Methode de paiement : <span><?= $fetch_order['methode']; ?></span></p>
                 <p>Adresse du client : <span><?= $fetch_order['adresse']; ?></span></p>
            </div>
            <form action="" method="post">
                <input type="hidden" name="order_id" value="<?= $fetch_order['id']; ?>">
                <select name="update_payment" class="box" style="width: 90%;">
                    <option disabled selected><?= $fetch_order['statuts_paiement']; ?></option>
                    <option value="En attente">En attente</option>
                    <option value="Commandes livrées">Commandes livrées</option>
                </select>
                <div class="flex-btn">
                    <input type="submit" name="update_order" value="Modifier le paiement" class="btn">
                    <input type="submit" name="delete_order" value="Supprimer la commande" class="btn" onclick="return confirm('Voulez-vous vraiment supprimer cette commande ?');">
                </div>
            </form>
        </div>
        <?php
    } 
   }else{
    echo  '
    <div class="empty">
             <p>Aucune commande passées pour le moment</p>
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













