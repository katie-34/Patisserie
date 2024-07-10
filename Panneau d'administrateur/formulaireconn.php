
<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include '../Composants/connexion.php';

if (isset($_POST['envoi'])) {
    

    
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $pass = sha1($_POST['mot']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);


    $select_seller = $conn->prepare("SELECT * FROM administrateurs WHERE email = ? AND mot_de_passe = ?");
    $select_seller->execute([$email,$pass]);
    $row = $select_seller->fetch(PDO::FETCH_ASSOC);


    if ($select_seller->rowCount() > 0) {
       setcookie('id_administrateur', $row['id'], time() + 60*60*24*30, '/');
       header('Location:dashboard.php');
       exit;
    }else{
        $warning_msg[] = 'email incorrect ou mot de passe incorrect';
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
    <form action="" method="post" enctype="multipart/form-data" class="connexion">
        <h3>Se connectez maintenant</h3>

        
            
                <div class="input-field">
                    <p>Votre Email:<span>*</span></p>
                    <input type="text" name="email" placeholder="Entrez votre email" maxlength="50" required class="box">
                </div>

                <div class="input-field">
                    <p>Votre Mot de passe:<span>*</span></p>
                    <input type="password" name="mot" placeholder="Entrez votre mot de passe" maxlength="50" required class="box">
                </div>
               
                
                <p class="link">Vous n'avez pas de compte ?<a href="formulaire.php">Inscrivez-vous maintenant</a></p>
                <input type="submit" name="envoi" value="Se connecter maintenant" class="btn">
        </div>        
    </form>

</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="../js/script.js"></script>

<?php include '../Composants/alert.php';?>
    
</body>
</html>