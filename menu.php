<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include 'Composants/connexion.php';

if (isset($_COOKIE['id_utilisateur'])) {
    $user_id = $_COOKIE['id_utilisateur'];
} else {

    $user_id = '';
    
}
include 'Composants/add_to_wishlist.php';
include '../add_to_card.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Menu</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'Composants/user_header.php'; ?>
    <div class="slider-container">
        <div class="slider">
            <div class="slideBox active">
                <div class="textBox">
                    <h1>Nos Gâteaux</h1>
                    <a href="menu.php" class="btn">Acheter maintenant</a>
                </div>
                <div class="imgBox">
                    <img src="image/slider3.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="products">
        <div class="heading">
            <h1>Nos saveurs</h1>
        </div>
        <div class="box-container">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `produits` WHERE status = ?");
            $select_products->execute(['disponible']);

            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <form action="add_to_card.php" method="post" class="box <?php if ($fetch_products['stock'] == 0) { echo 'indisponible'; } ?>">
                        <img src="fichiers_téléchargés/<?= htmlspecialchars($fetch_products['image']); ?>"  class="image"alt="">
                        <?php if($fetch_products['stock'] > 9){ ?>
                            <span class="stock" style="color: green">En stock</span>
                        <?php } elseif($fetch_products['stock'] == 0) { ?>
                            <span class="stock" style="color: red;">Pas en stock</span>
                        <?php } else { ?>
                            <span class="stock" style="color: red;">Seulement sur commande (<?= $fetch_products['stock']; ?> en stock)</span>
                        <?php } ?>
                        <div class="content">
                           <div class="button">
                            <div><h3 class="name"><?= $fetch_products['Nom']; ?></h3></div>
                            <div>
                                <button type="submit" name="add_to_card"><i class="bx bx-cart"></i></button>
                                <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                <a href="view_page.php?pid=<?= $fetch_products['id'] ?>" class="bx bx-show"></a>

                            </div>
                           </div>
                           <p class="price">prix <?= $fetch_products['prix'] ?>f</p>
                           <input type="hidden" name="product_id" value="<? $fetch_products['id']; ?>">
                           <div class="flex-btn">
                            <a href="checkout.php?get_id=<?= $fetch_products['id'] ?>" class="btn">Acheter</a>
                            <input type="number" name="qty" required min ="1" value="1" max="99" maxlength="2" class="qty box">
                           </div>
                        </div>
                    </form>
            <?php
                }
            } else {
            ?>
                <div class="empty">
                    <p>Les gâteaux ne sont pas encore au four !</p>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    
    <?php include 'Composants/footer.php'; ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>
    <?php include 'Composants/alert.php';?>
</body>
</html>





