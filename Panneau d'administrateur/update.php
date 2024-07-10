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
if(isset($_POST['submit'])){

    $select_seller = $conn->prepare("SELECT * FROM `administrateurs` WHERE id = ? LIMIT 1");
    $select_seller->execute([$id_administrateur]);
    $fetch_seller = $select_seller->fetch(PDO::FETCH_ASSOC);

    $prev_pass = $fetch_seller['mot_de_passe'];
    $prev_image = $fetch_seller['image'];

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $seller_id = $fetch_seller['id']; // Assurez-vous d'avoir défini $seller_id correctement

    $success_msg = array();
    $warning_msg = array();

    if (!empty($name)){
        $update_name = $conn->prepare("UPDATE `administrateurs` SET Nom = ? WHERE id = ?");
        $update_name->execute([$name, $seller_id]);
        $success_msg[] = 'Votre nom a été modifié avec succès';
    }

    if(!empty($email)){
        $select_email = $conn->prepare("SELECT * FROM `administrateurs` WHERE id != ? AND email = ?");
        $select_email->execute([$seller_id, $email]);

        if($select_email->rowCount() > 0){
            $warning_msg[] = 'Cet email existe déjà';
        }else{
            $update_email = $conn->prepare("UPDATE `administrateurs` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $seller_id]);
            $success_msg[] = 'Votre email a été modifié avec succès';
        }
    }

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../fichiers_téléchargés/'.$rename;

    if(!empty($image)){
        if($image_size > 2000000){
            $warning_msg[] = 'Veuillez mettre une image plus petite';
        }else{
            $update_image = $conn->prepare("UPDATE `administrateurs` SET image = ? WHERE id = ?");
            if ($update_image->execute([$rename, $seller_id])) {
                if (move_uploaded_file($image_tmp_name, $image_folder)) {
                    if ($prev_image != '' && $prev_image != $rename){
                        unlink('../fichiers_téléchargés/'.$prev_image);
                    }
                    $success_msg[] = 'Image mise à jour avec succès';
                } else {
                    $warning_msg[] = 'Erreur lors du déplacement du fichier téléchargé';
                }
            } else {
                $warning_msg[] = 'Erreur lors de la mise à jour de l\'image dans la base de données';
            }
        }
    }
    
    
    

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);

    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

    $cpass = sha1($_POST['c_pass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    if($old_pass != $empty_pass){
        if($old_pass != $prev_pass){
            $warning_msg[] = 'Votre mot de passe actuel n\'est pas valide';
        }elseif($new_pass != $cpass){
            $warning_msg[] = 'Votre nouveau mot de passe ne correspond pas à la confirmation';
        }else{
            if($new_pass != $empty_pass){
                $update_pass = $conn->prepare("UPDATE `administrateurs` SET mot_de_passe = ? WHERE id = ?");
                $update_pass->execute([$new_pass, $seller_id]);
                $success_msg[] = 'Mot de passe mis à jour avec succès';
            }else{
                $warning_msg[] = 'Veuillez entrer un nouveau mot de passe';
            }
        }
    }






    
}


















?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Mise du profile</title>
    <link rel="stylesheet" type="text/css" href="../css/administrateur.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="main-container">
    <?php include '../Composants/administrateur_entete.php'; ?>
    
    <section class="form-container">
    <div class="heading">
        <h1>Mettre a jour le profile</h1>
    </div>
     <br>
   <form action="" method="post" enctype="multipart/form-data" class="formulaire">
    <div class="img-box">
        <img src="../fichiers_téléchargés/<?= $fetch_profile['image']; ?>" alt="">
    </div>
    <!--<h3>Mettre a jour le profile</h3>-->
    <div class="flex">
        <div class="col">
            <div class="input-field">
                <p>Votre nom <span>*</span> </p>
                <input type="text" name="name" placeholder="<?= $fetch_profile['Nom']; ?>" class="box">
            </div>
        <div class="input-field">
            <p>Votre email <span>*</span> </p>
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box">
        </div>
        <div class="input-field">
            <p>Selection une photo <span>*</span> </p>
            <input type="file" name="image" accept="image/*" class="box">
        </div>
        </div>

        <div class="col">
             <div class="input-field">
                <p>Votre mot de passe actuel <span>*</span> </p>
                <input type="password" name="old_pass" placeholder="Entrez votre mot de passe actuel" class="box">
            </div>
            <div class="input-field">
                <p>Votre nouveau mot de passe <span>*</span> </p>
                <input type="password" name="new_pass" placeholder="Entrez votre nouveau mot de passe" class="box">
            </div>
            <div class="input-field">
                <p>Confirmez votre mot de passe<span>*</span> </p>
                <input type="password" name="c_pass" placholder="Confirmez votre mot de passe" class="box">
            </div>
        </div>
  </div>
  <input type="submit" name="submit" value="Mettre a jour le profile" class="btn">
   </form>

 </section>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="../js/administrateur_script.js"></script>
<?php include '../Composants/alert.php'; ?>

</body>
</html>













