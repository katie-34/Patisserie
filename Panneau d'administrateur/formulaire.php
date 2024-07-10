<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include '../Composants/connexion.php';

if (isset($_POST['envoi'])) {
    

    $id = unique_id();
    $name = $_POST['nom'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $pass = sha1($_POST['mot']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $cpass = sha1($_POST['cmot']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../fichiers_téléchargés/' . $rename;

    $select_seller = $conn->prepare("SELECT * FROM administrateurs WHERE email = ?");
    $select_seller->execute([$email]);

    if ($select_seller->rowCount() > 0) {
        $warning_msg[] = 'Cet email est déjà utilisé';
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = 'Votre mot de passe est incorrect';
        } else {
            if ($image_size > 2000000) { 
                $warning_msg[] = 'La taille de l\'image est trop grande';
            } else {
                $insert_seller = $conn->prepare("INSERT INTO administrateurs (id, nom, email, mot_de_passe, image) VALUES (?, ?, ?, ?, ?)");
                $insert_seller->execute([$id, $name, $email, $cpass, $rename]);
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'Enregistrement réussi. Connectez-vous maintenant.';
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
    <title>Sweet Fresh Tasty Bakery - Formulaire page d'administration</title>
    <link rel="stylesheet" type="text/css" href="../css/administrateur.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<body>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="formulaire">
        <h3>S'inscrire maintenant</h3>
        <div class="flex">
            <div class="col">
                <div class="input-field">
                    <p>Votre Nom:<span>*</span></p>
                    <input type="text" name="nom" placeholder="Entrez votre nom" maxlength="50" required class="box">
                </div>
                <div class="input-field">
                    <p>Votre Email:<span>*</span></p>
                    <input type="text" name="email" placeholder="Entrez votre email" maxlength="50" required class="box">
                </div>
            </div>
            <div class="col">
                <div class="input-field">
                    <p>Votre Mot de passe:<span>*</span></p>
                    <input type="password" name="mot" placeholder="Entrez votre mot de passe" maxlength="50" required class="box">
                </div>
                <div class="input-field">
                    <p>Confirmez votre Mot de passe:<span>*</span></p>
                    <input type="password" name="cmot" placeholder="Confirmez votre mot de passe" maxlength="50" required class="box">
                </div>
                
            </div>
        </div>
        <div class="input-field">
                    <p>Votre profil:<span>*</span></p>
                    <input type="file" name="image" accept="image/*" maxlength="50" required class="box">
                </div>
                <p class="link">Vous avez deja un compte ?<a href="formulaireconn.php">Connectez-vous maintenant</a></p>
                <input type="submit" name="envoi" value="S'inscrire maintenant" class="btn">
        </div>        
    </form>

</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="../js/script.js"></script>

<?php include '../Composants/alert.php';?>
    
</body>
</html>