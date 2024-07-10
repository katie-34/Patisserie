
<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include 'Composants/connexion.php';

if (isset($_COOKIE['id_utilisateur'])) {
    $user_id = $_COOKIE['id_utilisateur'];
} else {
    $user_id = '';
    header('Location:login.php');
}
if(isset($_POST['place_order'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITAZE_STRING);

    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITAZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITAZE_STRING);

    $address = $_POST['flat'].','.$_POST['city'].','.$_POST['country'];
    $address = filter_var($address, FILTER_SANITAZE_STRING);

    $address_type = $_POST['address_type'];
    $address_type = filter_var($address_type, FILTER_SANITAZE_STRING);

    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITAZE_STRING);

    $verify_cart = $conn->prepare("SELECT * FROM `panier` WHERE id_utilisateur = ?");
    $verify_cart->execute([$user_id]);

    if (isset($_GET['get_id'] )){

        $get_product = $conn->prepare("SELECT * FROM `produits` WHERE id = ? LIMIT 1");
        $get_product->execute([$_GET['get_id']]);

        if($get_product->rowCount() > 0){
            while($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)){
                $id_administrateur = $fetch_p['id_administrateur'];

                $insert_order = $conn->prepare("INSERT INTO `commandes` (id, id_utilisateur, id_administrateur, Nom, Numero, Email, adresse, type_adresse, methode, id_produit, prix, quantite) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                $insert_order->execute([uniqid(),$user_id, $id_administrateur, $name, $number,$email, $address, $address_type, $method, $fetch['id'], $fetch_p['prix'], 1]);
                header('Location:order.php');
            }
        }else{
            $warning_msg[] = 'Remplissez tous les champs';
        }
    }
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Achats</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

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
                    <img src="image/slider.jpg" alt="">
                </div>
            </div>
        </div>
    </div>





</div>
<div class="checkout">
<div class="heading">
    <h1>Achats</h1>
</div>
<div class="row">
    <form action="" method="post" class="formulaire">
        <input type="hidden" name="p_id" value="<?= $get_id; ?>">
        <h3>Details</h3>
        <div class="flex">
            <div class="box">
                <div class="input-field">
                    <p>Votre nom <span>*</span>
                    </p>
                    <input type="text" name="name" required maxlength="50" placeholder="Entrez votre nom ici" class="input">
                </div>
                <div class="input-field">
                    <p>Votre numero de telephone<span>*</span>
                    </p>
                    <input type="number" name="number" required maxlength="10" placeholder="Entrez votre numero ici" class="input">
                </div>
                <div class="input-field">
                    <p>Votre email<span>*</span>
                    </p>
                    <input type="email" name="email" required maxlength="10" placeholder="Entrez votre email ici" class="input">
                </div>
                <div class="input-field">
                    <p>Mode de paiemant<span>*</span>
                    <select name="method" class="input">
                        <option value="cash on delivery">Payer cash a la livraison</option>
                        <option value="credit or debit card">Par carte de credit</option>
                        <option value="net banking">Paiement bancaire</option>
                        <option value="paytm">Wave ou Orange Money</option>
                    </select>
                </div>
                <div class="input-field">
                    <p>Type d'addresse<span>*</span>
                    <select name="address_type" class="input">
                        <option value="home">Maison</option>
                        <option value="Office">Fix</option>
                        
                </div>
            </div>
            <div class="input">
                <div class="input-field">
                    <p>adresse<span>*</span>
                    </p>
                    <input type="text" name="flat" required maxlength="50" placeholder="Votre quartier" class="input">
                </div>
                <div class="input-field">
                    <p>Ville<span>*</span>
                    </p>
                    <input type="text" name="city" required maxlength="50" placeholder="Votre ville" class="input">
                </div>
                <div class="input-field">
                    <p>Pays<span>*</span>
                    </p>
                    <input type="text" name="country" required maxlength="50" placeholder="Votre pays" class="input">
                </div>
                
            </div>
        </div>
        <button type="submit" name="place_order" class="btn">Commander</button>
    </form>

    <div class="summary">
        <h3>Mes achats</h3>
        <div class="box-container">
            <?php
            $grand_total = 0;
            if(isset($_GET['get_id'])){

                $select_get = $conn->prepare("SELECT * FROM `produits` WHERE id = ?").
                $select_get->execute([$_GET['get_id']]);

                while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
                    $sub_total = $fetch_get['prix'];
                    $grand_total+=$sub_total;



                    ?>
                    <div class="flex">
                        <img src="fichiers_téléchargés/<?= $fetch_get['image']; ?>" class="image" alt="">
                        <div>
                            <h3 class="name"><?= $fetch_get['Nom']; ?></h3>
                            <p class="price"><?= $fetch_get['prix']; ?>f</p>
                        </div>
                    </div>
                    <?php
                }
            }else{
                $select_cart = $conn->prepare("SELECT * FROM `panier` WHERE id_utilisateur = ? ");
                $select_cart->execute([$user_id]);

                if($select_cart->rowCount() > 0){
                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                        $select_products = $conn->prepare("SELECT * FROM `produits`
                        WHERE id = ?");
                        $select_products->execute([$fetch_cart['id_produit']]);
                        $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                        $sub_total = ($fetch_cart['quantite'] * $fetch_products['prix']);
                        $grand_total += $sub_total;


                        ?>
                        <div class="flex">
                            <img src="fichiers_téléchargés/<?= $fetch_products['image']; ?>" class="image"alt="">
                            <div>
                                <h3 class="name"><?= $fetch_products['Nom']; ?></h3>
                                <p class="price"><?= $fetch_products['prix']; ?>f X <?= $fetch_cart['quantite']; ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }else{
                    echo'<p class="empty">Votre panier est vide</p>';
                }
            }
            ?>
        </div>
        <div class="grand-total">

        </div>
    </div>
</div>
</div>




<?php include 'Composants/footer.php'; ?>   
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="js/user_script.js"></script>

<?php include 'Composants/alert.php';?>
    
</body>
</html>