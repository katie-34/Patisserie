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
    <section class="read-post">
    <div class="heading">
    </div>
 <div class="box-container">
    <?php
    $select_product = $conn->prepare("SELECT * FROM `produits` WHERE id = ? AND id_administrateur = ?");
    $select_product->execute([$get_id, $id_administrateur]);
    if($select_product->rowCount() > 0){
        while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){


       ?>
       <form action="" method="post" class="box">
        <input type="hidden" name="id_produit" value="<?= $fetch_product['id']; ?>">
        <div class="status" style="color: <?php if ($fetch_product['status'] == 'disponible'){
            echo 'limegreen';
        } else{echo 'coral';} ?>">
               <?= $fetch_product['status']; ?>
        </div>
        <?php if($fetch_product['image'] != '' ){
            ?><img src="../fichiers_téléchargés/<?= $fetch_product['image']; ?>" class="image">
            <?php }?>
            <div class="price"><?= $fetch_product['prix']; ?>f</div>
            <div class="title"><?= $fetch_product['Nom']; ?></div>
            <div class="content"><?= $fetch_product['detail_produit']; ?></div>
            <div class="flex-btn">
                <a href="edit_product.php?id=<? $fetch_product['id']; ?>" class="btn">Modifier</a>
                <button type="submit" name="delete" class="btn" onclick="return confirm('Voulez-vous vraiment supprimer ce gateau ?');">Supprimer</button>
                <a href="view_product.php?post_id=<?= $fetch_product['id']; ?>" class="btn">Retour</a>
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
</div>   
 </section>
</div>
<div class="empty">
<p>pas encore de gateau ajouté ? <br> <a href="add_product.php" class="btn" style="margin-top: 1.5rem;">Ajouter des gateaux</a></p>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/administrateur_script.js"></script>
<?php include '../Composants/alert.php'; ?>

</body>
</html>




<!--</?/*php

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

$get_id = $_GET['post_id'];

// Pour supprimer un gateau

if(isset($_POST['delete'])){
    $p_id = $_POST['id_produit'];
    $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);

    $delete_image = $conn->prepare("SELECT * FROM `produits` WHERE id = ? AND id_administrateur = ?");
    $delete_image ->execute([$p_id , $id_administrateur]);
    
    $fetch_delete_image = $delete_image->fetch(PDO:: FETCH_ASSOC);
    if($fetch_delete_image[''] != ''){
        unlink('..fichiers_téléchargés/'.$fetch_delete_image['image']);
    }
    $delete_product = $conn->prepare("DELETE FROM `produits` WHERE id = ? AND id_administrateur = ?");
    $delete_product->execute([$p_id, $id_administrateur]);
    header("Location:view_product.php");
}

?*/>

/*<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Détails du gâteau</title>
    <link rel="stylesheet" type="text/css" href="../css/administrateur.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="main-container">
    </*?php include '../Composants/administrateur_entete.php'; ?>
    <section class="read-post">
    <div class="heading">
        <h1>Détails du gâteau</h1>
    </div>
    <div class="box-container">
        <:µ?php
        try {
            $select_product = $conn->prepare("SELECT * FROM `produits` WHERE id = ? AND id_administrateur = ?");
            $select_product->execute([$get_id, $id_administrateur]);
            if($select_product->rowCount() > 0){
                $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="box">
            <input type="hidden" name="id_produit" value="</*?= htmlspecialchars($fetch_product['id']); ?>">
            <div class="status" style="color: </*?= $fetch_product['status'] == 'disponible' ? "limegreen" : "coral"; ?>">
                </*?= htmlspecialchars($fetch_product['status']); ?>
            </div>
            </*?php if(!empty($fetch_product['image'])): ?>
                <img src="../fichiers_téléchargés/</*?= htmlspecialchars($fetch_product['image']); ?>" class="image">
            </*?php endif; ?>
            <div class="price"></*?= htmlspecialchars($fetch_product['prix']); ?>f</div>
            <div class="title"></*?= htmlspecialchars($fetch_product['Nom']); ?></div>
            <div class="content"></*?= nl2br(htmlspecialchars($fetch_product['detail_produit'])); ?></div>
            <div class="flex-btn">
                <a href="edit_product.php?id=</*?= htmlspecialchars($fetch_product['id']); ?>" class="btn">Modifier</a>
                <a href="view_product.php?post_id=</*?= htmlspecialchars($fetch_product['id']); ?>" class="btn">Retour</a>
                <button type="submit" name="delete" class="btn" onclick="return confirm('Voulez-vous vraiment supprimer ce gateau ?');">Supprimer</button>
            </div>
        </div>
        </*?php
            } else {
                echo '
                <div class="empty">
                    <p>Gâteau non trouvé.</p>
                </div>
                ';
            }
        } catch (PDOException $e) {
            echo '<div class="error">Erreur de connexion à la base de données: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
    </div>   
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/administrateur_script.js"></script>
</*?php include '../Composants/alert.php'; ?>

</body>
</html>-->









