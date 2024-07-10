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

$select_products = $conn->prepare("SELECT * FROM `produits` WHERE id_administrateur = ?");
$select_products->execute([$id_administrateur]);
$total_products = $select_products->rowCount();

$select_orders = $conn->prepare("SELECT * FROM `commandes` WHERE id_administrateur = ?");
$select_orders->execute([$id_administrateur]);
$total_orders = $select_products->rowCount();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Profile de patissiers</title>
    <link rel="stylesheet" type="text/css" href="../css/administrateur.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../Composants/administrateur_entete.php'; ?>
    <section class="seller-profile">
    <div class="heading">
        <!--<h1>Tableau de bord</h1>-->
    </div>
    <div class="details">
        <div class="seller">
            <img src="../fichiers_téléchargés/<?= $fetch_profile['image']; ?>">
            <h3 class="name"><?= $fetch_profile['Nom']; ?></h3>
            <span>patissiers</span>
            <a href="update.php" class="btn">Actualiser</a>
        </div>
        <div class="flex">
          <div class="box">
            <span><?= $total_products; ?></span>
            <p>total gateau</p>
            <a href="view_product.php" class="btn">Voir mes gateaux</a>
          </div>
          <div class="box">
            <span><?= $number_of_orders; ?></span>
            <p>total de commande passée</p>
            <a href="admin_order.php" class="btn">Voir les commandes</a>
          </div>
        </div>
    </div>

 </section>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/administrateur_script.js"></script>
<?php include '../Composants/alert.php'; ?>

</body>
</html>













