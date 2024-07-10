<?php

// Désactiver l'affichage des erreurs
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Inclure le fichier de connexion
include '../Composants/connexion.php';

// Vérifier si l'administrateur est connecté
if (isset($_COOKIE['id_administrateur'])) {
    $id_administrateur = $_COOKIE['id_administrateur'];
} else {
    header('Location: formulaireconn.php');
    exit;
}

// Si le formulaire est soumis
if (isset($_POST['update'])) {
    // Récupérer et assainir les données du formulaire
    $product_id = filter_var($_POST['id_produit'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $stock = filter_var($_POST['stock'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Mettre à jour le produit dans la base de données
    $update_product = $conn->prepare("UPDATE `produits` SET Nom = ?, prix = ?, detail_produit = ?, stock = ?, status = ? WHERE id = ?");
    $update_product->execute([$name, $price, $description, $stock, $status, $product_id]);

    $success_msg[] = 'Gateau modifié';

    // Gérer l'image
    $old_image = $_POST['old_image'];
    $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../fichiers_téléchargés/'.$image;

    // Vérifier si une image a été téléchargée
    if (!empty($image)) {
        $select_image = $conn->prepare("SELECT * FROM `produits` WHERE image = ? AND id_administrateur = ?");
        $select_image->execute([$image, $id_administrateur]);

        // Vérifier la taille de l'image
        if ($image_size > 2000000) {
            $warning_msg[] = 'La taille de cette image est trop grande';
        } elseif ($select_image->rowCount() > 0) {
            $warning_msg[] = 'Veuillez renommer cette image';
        } else {
            // Mettre à jour l'image du produit
            $update_image = $conn->prepare("UPDATE `produits` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $product_id]);

            // Déplacer l'image téléchargée
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                // Supprimer l'ancienne image si nécessaire
                if ($old_image != $image && !empty($old_image)) {
                    unlink('../fichiers_téléchargés/'.$old_image);
                }
                $success_msg[] = 'Image modifiée';
            } else {
                $error_msg[] = 'Échec du téléchargement de l\'image';
            }
        }
    }
}

if (isset($_POST['delete_image'])) {
    $empty_image = '';
    $product_id = filter_var($_POST['id_produit'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Préparer et exécuter la requête pour obtenir les informations du produit
    $delete_image = $conn->prepare("SELECT * FROM `produits` WHERE id = ?");
    $delete_image->execute([$product_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    // Vérifier si une image existe et la supprimer
    if ($fetch_delete_image['image'] != '') {
        $image_path = '../fichiers_téléchargés/' . $fetch_delete_image['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        } else {
            $error_msg[] = 'L\'image n\'existe pas sur le serveur.';
        }
    }

    // Mettre à jour la colonne image du produit
    $unset_image = $conn->prepare("UPDATE `produits` SET image = ? WHERE id = ?");
    $result = $unset_image->execute([$empty_image, $product_id]);

    if ($result) {
        $success_msg[] = 'Image supprimée avec succès';
    } else {
        $error_msg[] = 'Une erreur est survenue lors de la mise à jour de l\'image du produit.';
    }
}


if (isset($_POST['delete_post'])) {
    $product_id = $_POST['id_produit'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Préparer et exécuter la requête pour obtenir les informations du produit
    $delete_image = $conn->prepare("SELECT * FROM `produits` WHERE id = ?");
    $delete_image->execute([$product_id]);
    $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);

    // Vérifier si une image existe et la supprimer
    if ($fetch_delete_image['image'] != '') {
        $image_path = '../fichiers_téléchargés/' . $fetch_delete_image['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        } else {
            $error_msg[] = 'L\'image n\'existe pas sur le serveur.';
        }
    }

    // Supprimer le produit de la base de données
    $delete_product = $conn->prepare("DELETE FROM `produits` WHERE id = ?");
    $delete_product->execute([$product_id]);
    
    $success_msg[] = 'Gateau supprimé avec succès';
    header('Location: view_product.php');
    exit;
}














?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sweet Fresh Tasty Bakery - Page d'administration</title>
    <link rel="stylesheet" type="text/css" href="../css/administrateur.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../Composants/administrateur_entete.php'; ?>
    <section class="post-editor">
    <div class="heading">
        <!--<h1>Tableau de bord</h1>-->
    </div>
<div class="box-container">
<?php
    $product_id = $_GET['id'];
    $select_product = $conn->prepare("SELECT * FROM `produits` WHERE id = ? AND id_administrateur = ?");
    $select_product->execute([$product_id, $id_administrateur]);
    if($select_product->rowCount() > 0){
        while($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data" class="formulaire">
                    <input type="hidden" name="old_image" value="<?= $fetch_product['image']; ?>">
                    <input type="hidden" name="id_produit" value="<?= $fetch_product['id']; ?>">
                    <div class="input-field">
                        <p>Etat du gateau<span>*</span></p>
                        <select name="status" class="box">
                            <option value="<?= $fetch_product['status']; ?>" ><?= $fetch_product['status']; ?></option>
                            <option value="disponible">disponible</option>
                            <option value="non disponible">Non disponible</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <p>Nom du gateau<span>*</span></p>
                        <input type="text" name="name" value="<?= $fetch_product['Nom']; ?>"
                        class="box">
                    </div>
                    <div class="input-field">
                        <p>Prix du gateau<span>*</span></p>
                        <input type="number" name="price" value="<?= $fetch_product['prix']; ?>"
                        class="box">
                    </div>
                    <div class="input-field">
                        <p>Description du gateau<span>*</span></p>
                        <textarea class="box" name="description" ><?= $fetch_product['detail_produit']; ?></textarea>
                    </div>
                    <div class="input-field">
                        <p>Stock du gateau<span>*</span></p>
                        <input type="number" name="stock" value="<?= $fetch_product['stock']; ?>"
                        class="box" min="0" max="9999999999" maxlength="10">
                    </div>
                    <div class="input-field">   
                        <p>Image du gateau<span>*</span></p>
                        <input type="file" name="image" accept="image/*" class="box">
                        <?php if($fetch_product['image'] != ''){ ?>
                            <img src="../fichiers_téléchargés/<?= $fetch_product['image']; ?>" class="image" alt="">
                            <div class="flex-btn">
                                <input type="submit" name="delete_image" value="supprimer l'image" class="btn">
                                <a href="view_product.php"  style="width:49%; text-align: center; height: 3rem; margin-top: .7rem;" class="btn">Retour</a>
                            </div>
                        <?php } ?>
                    </div>
                    <br><br>
                     <div class="flex-btn">
                       <input type="submit" name="update" value="enregistrer" class="btn">
                       <input type="submit" name="delete_post" value="supprimer" class="btn">
                     </div>
                </form>
            </div>
            <?php   
        }
    } else {
        echo ' 
        <div class="empty">
            <p>Pas encore de gateau ajouté ?</p>
        </div>
        ';
    }
?>
<br><br>
<div class="flex-btn">
    <a href="view_product.php" class="btn">Voir mes gateaux</a>
    <a href="add_product.php" class="btn">Ajouter des gateaux</a>
</div>
</div>
 </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/administrateur_script.js"></script>
<?php include '../Composants/alert.php'; ?>

</body>
</html>

















































