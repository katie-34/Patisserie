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
    <section class="dashboard">
    <div class="heading">
        <!--<h1>Tableau de bord</h1>-->
    </div>
<div class="box-container">
    <div class="box">
       <h3>Bienvenue!</h3>
        <p><?= $fetch_profile['Nom']; ?></p>
        <a href="update.php" class="btn">Actualiser</a>
    </div>
    <!--<div class="box">
        </*?php
        $select_message = $conn->prepare("SELECT * FROM `message`");
        $select_message->execute();
        $number_of_msg = $select_message->rowCount();
        ?>*/
       <h3></*?= $number_of_msg; ?></h3>
        <p>Messages non lus</p>
        <a href="admin_message.php" class="btn">Voir messages</a>
    </div>-->
    <div class="box">
        <?php
        $select_products = $conn->prepare("SELECT * FROM `produits` WHERE id_administrateur = ?");
        $select_products->execute([$id_administrateur]);
        $number_of_products = $select_products->rowCount();
        ?>
       <h3><?= $number_of_products ; ?></h3>
        <p>Gateau ajoutés</p>
        <a href="add_product.php" class="btn">Ajouter un gateau</a>
    </div>
    <div class="box">
        <?php
        $select_active_products = $conn->prepare("SELECT * FROM `produits` WHERE id_administrateur = ? AND status = ?");
        $select_active_products->execute([$id_administrateur, 'active']);
        $number_of_active_products = $select_products->rowCount();
        ?>
       <h3><?=  $number_of_active_products; ?></h3>
        <p>Total de gateaux disponible</p>
        <a href="view_product.php" class="btn">Voir les gateaux disponibles</a>
    </div>
    <div class="box">
        <?php
        $select_deactive_products = $conn->prepare("SELECT * FROM `produits` WHERE id_administrateur = ? AND status = ?");
        $select_deactive_products->execute([$id_administrateur ,'deactive']);
        $number_of_active_products = $select_products->rowCount();
        ?>
       <h3><?=  $number_of_active_products; ?></h3>
        <p>Total de gateaux non disponible</p>
        <a href="view_product.php" class="btn">Supprimer un gateau</a>
    </div>
    <div class="box">
        <?php
        $select_users = $conn->prepare("SELECT * FROM `utilisateurs`");
        $select_users->execute();
        $number_of_users = $select_users->rowCount();
        ?>
       <h3><?= $number_of_users; ?></h3>
        <p>Compte utilisateur</p>
        <a href="user_accounts.php" class="btn">Voir les utilisateurs</a>
    </div>
    <div class="box">
        <?php
        $select_sellers = $conn->prepare("SELECT * FROM `administrateurs`");
        $select_sellers->execute();
        $number_of_sellers = $select_sellers->rowCount();
        ?>
       <h3><?= $number_of_sellers; ?></h3>
        <p>Compte patissiers</p>
        <a href="user_accounts.php" class="btn">Voir les patissiers</a>
    </div>
    <div class="box">
        <?php
        $select_orders = $conn->prepare("SELECT * FROM `commandes`WHERE id_administrateur = ?");
        $select_orders->execute([$id_administrateur]);
        $number_of_orders = $select_orders->rowCount();
        ?>
       <h3><?= $number_of_orders; ?></h3>
        <p>Total de commandes passées</p>
        <a href="admin_order.php" class="btn">Total commande</a>
    </div>
    <div class="box">
        <?php
        $select_confirm_orders = $conn->prepare("SELECT * FROM `commandes` WHERE id_administrateur = ? AND statuts= ?");
        $select_confirm_orders->execute([$id_administrateur, 'in progress']);
        $number_of_confirm_orders = $select_confirm_orders->rowCount();
        ?>
       <h3><?= $number_of_confirm_orders; ?></h3>
        <p>Total de commandes confirmées</p>
        <a href="administrateur_commande.php" class="btn">Confirmer commande</a>
    </div>
    <div class="box">
        <?php
        $select_canceled_orders = $conn->prepare("SELECT * FROM `commandes` WHERE id_administrateur = ? AND statuts= ?");
        $select_canceled_orders->execute([$id_administrateur, 'canceled']);
        $number_of_canceled_orders = $select_canceled_orders->rowCount();
        ?>
       <h3><?= $number_of_canceled_orders; ?></h3>
        <p>Total de commandes annulées</p>
        <a href="administrateur_commande.php" class="btn">Annuler la commande</a>
    </div>
</div>
 </section>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/administrateur_script.js"></script>
<?php include '../Composants/alert.php'; ?>

</body>
</html>













