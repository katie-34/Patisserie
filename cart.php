<?php

include 'Composants/connexion.php';

if (isset($_COOKIE['id_utilisateur'])) {
    $user_id = $_COOKIE['id_utilisateur'];
} else {
    header('Location:login.php');
    exit();
}

// Supprimer un article du panier
if (isset($_POST['remove_item'])) {
    $cart_item_id = filter_var($_POST['cart_item_id'], FILTER_SANITIZE_STRING);
    $delete_item = $conn->prepare("DELETE FROM panier WHERE id = ? AND id_utilisateur = ?");
    $delete_item->execute([$cart_item_id, $user_id]);
    $_SESSION['success_msg'] = 'Produit retiré du panier';
}

// Mettre à jour la quantité d'un article
if (isset($_POST['update_qty'])) {
    $cart_item_id = filter_var($_POST['cart_item_id'], FILTER_SANITIZE_STRING);
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);
    $update_qty = $conn->prepare("UPDATE panier SET quantite = ? WHERE id = ? AND id_utilisateur = ?");
    $update_qty->execute([$qty, $cart_item_id, $user_id]);
    $_SESSION['success_msg'] = 'Quantité mise à jour';
}

// Récupérer les articles du panier
$get_cart_items = $conn->prepare("SELECT panier.*, produits.Nom, produits.image FROM panier INNER JOIN produits ON panier.id_produit = produits.id WHERE panier.id_utilisateur = ?");
$get_cart_items->execute([$user_id]);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
</head>
<body>
    <?php include 'Composants/user_header.php'; ?>
   

    <div class="cart-container">
        <h1>Votre Panier</h1>

        <?php
        if ($get_cart_items->rowCount() > 0) {
            while ($cart_item = $get_cart_items->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="cart-item">
                    <img src="fichiers_téléchargés/<?= htmlspecialchars($cart_item['image']); ?>" alt="<?= htmlspecialchars($cart_item['Nom']); ?>">
                    <div class="cart-item-details">
                        <h3><?= htmlspecialchars($cart_item['Nom']); ?></h3>
                        <p>Prix : <?= htmlspecialchars($cart_item['prix']); ?>f</p>
                        <form action="" method="post" class="update-qty-form">
                            <input type="hidden" name="cart_item_id" value="<?= htmlspecialchars($cart_item['id']); ?>">
                            <input type="number" name="qty" value="<?= htmlspecialchars($cart_item['quantite']); ?>" min="1" max="99">
                            <button type="submit" name="update_qty">Mettre à jour</button>
                        </form>
                        <form action="" method="post" class="remove-item-form">
                            <input type="hidden" name="cart_item_id" value="<?= htmlspecialchars($cart_item['id']); ?>">
                            <button type="submit" name="remove_item">Retirer</button>
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<p>Votre panier est vide.</p>';
        }
        ?>
    </div>

    <?php include 'Composants/footer.php'; ?>
</body>
</html>
