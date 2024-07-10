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

// Pour supprimer un produit
if(isset($_POST['delete'])){
    $p_id = $_POST['id_produit'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

    $delete_product = $conn->prepare("DELETE FROM `produits` WHERE id = ?");
    $delete_product->execute([$p_id]);

    $success_msg[] = "Gateau supprimé avec succès";
}
$get_id = $_GET['post_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Afficher la page des gateaux</title>
    <link rel="stylesheet" type="text/css" href="../css/administrateur.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../Composants/administrateur_entete.php'; ?>
    <section class="show-post">
    <div class="heading">
    </div>
<div class="box-container">
    <?php
    $select_product = $conn->prepare("SELECT * FROM `produits` WHERE id_administrateur = ?");
    $select_product->execute([$id_administrateur]);
    if ($select_product->rowCount() > 0){
        while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){

       
    ?>
    <form action="" method="post" class="box">
        <input type="hidden" name="id_produit" value="<?=$fetch_product['id']; ?>">
        <?php if($fetch_product['image'] != ''){ ?>
           <img src="../fichiers_téléchargés/<?=$fetch_product['image']; ?>" class="image" alt="">
        <?php } ?>
        <div class="status" style="color: <?php if($fetch_product['status'] == 'disponible') {
        echo 'limegreen';}else{echo 'coral';} ?>"><?=$fetch_product['status']; ?></div>
        <div class="price"><?=$fetch_product['prix']; ?>f</div>
        <div class="content">
            <img src="../image/shape-19.png" class="shap">
            <div class="title"><?=$fetch_product['Nom']; ?></div>
            <div class="flex-btn">
                <a href="edit_product.php?id=<?= $fetch_product['id']; ?>" class="btn">Modifier</a>
                <button type="submit" name="delete" class="btn" onclick="return confirm('supprimer ce gateau');">supprimer</button>
                <!--<a href="read_product.php?post_id=<?= $fetch_product['id']; ?>" class="btn">Voir</a>-->
            </div>
        </div>
    </form>
    <?php
          }
        }else{
            echo '
            <div class="empty">
                     <p>pas encore de gateau ajouté ? <br> <a href="add_product.php" class="btn" style="margin-top: 1.5rem;">Ajouter des gateaux</a></p>
            </div>
            ';
        }
    ?>
 </section>
</div>
<div class="empty">
<p>pas encore de gateau ajouté ? <br><br> <a href="add_product.php" class="btn" style="margin-top: 1.5rem;">Ajouter des gateaux</a></p>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/administrateur_script.js"></script>
<?php include '../Composants/alert.php'; ?>

</body>
</html>













