<?php



if(isset($_POST['add_to_wishlist'])){
    if($id_utilisateur != ''){
        $id = unique_id();
        $product_id = $_POST['product_id'];

        $verify_wishlist = $conn->prepare("SELECT * FROM souhaits WHERE id_utilisateur = ? AND id_produit = ?");
        $verify_wishlist->execute([$id_utilisateur, $id_produit]);


         $cart_num = $conn->prepare("SELECT * FROM `panier` WHERE id_utilisateur = ? AND id_produit = ?");
         $cart_num->execute([$id_utilisateur, $product_id]);



        if($verify_wishlist->rowCount() > 0){
            $warning_msg[] = 'Ce gateau existe deja dans vos favoris';
        }else if($cart_num->rowCount() > 0){
            $warning_msg[] = 'Ce gateau existe deja dans votre panier';
        }else if($id_utilisateur != ''){
            $select_price = $conn->prepare("SELECT * FROM produits WHERE id = ? LIMIT 1");
            $select_price->execute([$product_id]);
            $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

            $insert_wishlist = $conn->prepare("INSERT INTO souhaits (id, id_utilisateur, id_produit, prix) VALUES(?,?,?,?)");
            $insert_wishlist->execute([$id, $id_utilisateur, $id_produit, $fetch_price['prix']]);

            $success_msg[] = 'Gateau ajouté aux favoris';
        }
    }else{
        $warning_msg[] = 'Connectez-vous d\'abord';
    }
}
?>






