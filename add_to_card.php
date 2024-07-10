<?php

 include 'Composants/connexion.php';

if (isset($_COOKIE['id_utilisateur'])) {
    $user_id = $_COOKIE['id_utilisateur'];
} else {
    
    header('Location:login.php');
    exit();
}

if (isset($_POST['add_to_card'])) { 
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $quantity = filter_var($_POST['qty'], FILTER_SANITIZE_NUMBER_INT);


    $check_cart = $conn->prepare("SELECT * FROM panier WHERE id_utilisateur = ? AND id_produit = ?");
    $check_cart->execute([$user_id, $product_id]);

    if ($check_cart->rowCount() > 0) {
        $warning_msg[] = 'Ce gateau est déjà dans votre panier';
    } else {
        
        $select_product = $conn->prepare("SELECT * FROM produits WHERE id = ? LIMIT 1");
        $select_product->execute([$product_id]);
        $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

        if ($fetch_product) {
            // Ajouter le produit au panier
            $insert_cart = $conn->prepare("INSERT INTO panier (id, id_utilisateur, id_produit, prix, quantite) VALUES(?,?,?,?,?)");
            $insert_cart->execute([uniqid(), $user_id, $product_id, $fetch_product['prix'], $quantity]);

            $success_msg[] = 'Gateau ajouté au panier';
        } else {
            $warning_msg[] = 'Gateau non trouvé';
        }
    }

    header('Location:cart.php');
    exit();
}
?>
<?php include 'Composants/alert.php';?>



