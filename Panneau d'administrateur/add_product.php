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
if (isset($_POST['publish'])){

    $id = unique_id();
$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);

$price = $_POST['price'];
$price = filter_var($price, FILTER_SANITIZE_STRING);

$description = $_POST['description'];
$description = filter_var($description, FILTER_SANITIZE_STRING);

$stock = $_POST['stock'];
$stock = filter_var($stock, FILTER_SANITIZE_STRING);
$status = 'disponible';

$image = $_FILES['image']['name'];
$image = filter_var($image, FILTER_SANITIZE_STRING);
$image_size = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = '../fichiers_téléchargés/'.$image;

$select_image = $conn->prepare("SELECT * FROM `produits` WHERE image = ? AND id_administrateur = ?");

$select_image->execute([$image,$id_administrateur]);

if(isset($image)){
    if($select_image->rowCount() > 0){
        $warning_msg[] = 'Veuillez changez le nom de cette image';
    }elseif($image_size > 2000000){
       $warning_msg[] = 'Taille trop grande';
    }else{
        move_uploaded_file($image_tmp_name, $image_folder);
    }
}else {
    $image = '';
}
if ($select_image->rowCount() > 0 AND $image != ''){
    $warning_msg[] = 'Veuillez renommer cette image';
} else{
    $insert_product = $conn->prepare("INSERT INTO `produits`(id,id_administrateur,Nom,prix, image, stock,detail_produit,status) VALUES(?,?,?,?,?,?,?,?)");
    $insert_product->execute([$id,$id_administrateur,$name,$price,$image,$stock,$description,$status]);
    $success_msg[] = 'Gateau ajouté avec success';
    }

}



if (isset($_POST['draft'])){

    $id = unique_id();
$name = $_POST['name'];
$name = filter_var($name, FILTER_SANITIZE_STRING);

$price = $_POST['price'];
$price = filter_var($price, FILTER_SANITIZE_STRING);

$description = $_POST['description'];
$description = filter_var($description, FILTER_SANITIZE_STRING);

$stock = $_POST['stock'];
$stock = filter_var($stock, FILTER_SANITIZE_STRING);
$status = 'non disponible';

$image = $_FILES['image']['name'];
$image = filter_var($image, FILTER_SANITIZE_STRING);
$image_size = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = '../fichiers_téléchargés/'.$image;

$select_image = $conn->prepare("SELECT * FROM `produits` WHERE image = ? AND id_administrateur = ?");

$select_image->execute([$image,$id_administrateur]);

if(isset($image)){
    if($select_image->rowCount() > 0){
        $warning_msg[] = 'Veuillez changez cette image';
    }elseif($image_size > 2000000){
       $warning_msg[] = 'La taille de cette image est trop grande';
    }else{
        move_uploaded_file($image_tmp_name, $image_folder);
    }
}else {
    $image = '';
}
if ($select_image->rowCount() > 0 AND $image != ''){
    $warning_msg[] = 'Veuillez renommer cette image';
} else{
    $insert_product = $conn->prepare("INSERT INTO `produits`(id,id_administrateur,Nom,prix, image, stock,detail_produit,status) VALUES(?,?,?,?,?,?,?,?)");
    $insert_product->execute([$id,$id_administrateur,$name,$price,$image,$stock,$description,$status]);
    $success_msg[] = 'Gateau enregistrer comme brouillon avec succes';
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Page d'ajout de gateaux</title>
    <link rel="stylesheet" type="text/css" href="../css/administrateur.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../Composants/administrateur_entete.php'; ?>
    <section class="post-editor">
    <div class="heading">
        <h1>Ajouter des gateaux</h1>
    </div>
<div class="form-container">
<form action="" method="post" enctype="multipart/form-data"  class="formulaire">
    <div class="input-field">
        <p>Nom du gateau<span>*</span></p>
        <input type="text" name="name" maxlength="100" placeholder="Ajouter le nom du gateau ici" required class="box">
    </div>
    <div class="input-field">
        <p>Prix du gateau<span>*</span></p>
        <input type="text" name="price" maxlength="100" placeholder="Ajouter le prix du gateau ici" required class="box">
    </div>
    <div class="input-field">
        <p>Description du gateau<span>*</span></p>
        <textarea name="description" id="" required maxlength="1000" placeholder = "Decrivez le gateau" class="box"></textarea>
    </div>
    <div class="input-field">
        <p>Stock du gateau<span>*</span></p>
        <input type="text" name="stock" maxlength="10" min="0" max="9999999999" placeholder="Ajouter le stock du gateau ici" required class="box">
    </div>
    <div class="input-field">
        <p>Image du gateau<span>*</span></p>
        <input type="file" name="image" accept = "image/*" maxlength="10" min="0" max="9999999999" placeholder="Ajouter le stock du gateau ici" required class="box">
    </div>
    <div class="flex-btn">
        <input type="submit" name="publish" value =" ajouter un gateau" class="btn">
        <input type="submit" name="draft" value ="Enregistrer comme brouillon" class="btn">
    </div>

</form>
</div>
 </section>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/administrateur_script.js"></script>
<?php include '../Composants/alert.php'; ?>

</body>
</html>













