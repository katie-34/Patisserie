<!-- Inclure Boxicons -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Page d'accueil</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>


    <header class="header">
        <section class="flex">
            <a href="home.php" class="logo"><img src="fichiers_téléchargés/logo.jpg" width="130px" alt="Logo"></a>
            <nav class="navbar">
                <a href="home.php">Accueil</a>
                <a href="menu.php">Menu</a>
                <a href="order.php">Commander</a>
                <!--<a href="contact.php">Contactez-nous</a>-->
            </nav>
            <form action="" method="post" class="search-form">
                <input type="text" name="search_product" placeholder="Rechercher des gâteau..." required maxlength="100">
                <button type="submit" class="bx bx-search-alt-2" id="search_product_btn"></button>
            </form>
            <div class="icons">
                <div class="bx bx-list-plus" id="menu-btn"></div>
                <div class="bx bx-search-alt-2" id="search-btn"></div>
                <a href="wishlist.php"><i class="bx bx-heart"></i><sup>0</sup></a>
                <a href="checkout.php"><i class="bx bx-cart"></i><sup>0</sup></a>
                <div class="bx bxs-user" id="user-btn"></div>
            </div>
            <div class="profile-detail">
            <?php
            /*ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(E_ALL);*/
            
            include '../Composants/connexion.php';
            
          

            $user_id = isset($_COOKIE['id_utilisateur']) ? $_COOKIE['id_utilisateur'] : null;
            
            $select_profile = $conn->prepare("SELECT * FROM `utilisateurs` WHERE id = ?");
            $select_profile->execute([$user_id]);


            $select_profile = $conn->prepare("SELECT * FROM `utilisateurs` WHERE id = ?");
            $select_profile->execute([$user_id]);

            if($select_profile->rowCount() > 0){
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <img src="fichiers_téléchargés/<?= htmlspecialchars($fetch_profile['image']); ?>" alt="Profile Image">
                <h3 style="margin-bottom: 1rem;"><?= htmlspecialchars($fetch_profile['Nom']); ?></h3>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">Voir le profil</a>
                    <a href="../user_logout.php" onclick="return confirm('Voulez-vous vraiment vous déconnecter de ce site ?');" class="btn">Se déconnecter</a>
                </div>
            <?php } else { ?>
                <h3 style="margin-bottom: 1rem;">Veuillez vous connecter ou vous inscrire</h3>
                <div class="flex-btn">
                    <a href="Panneau d'administrateur/formulaireconn.php" class="btn">Se connecter</a>
                    <a href="Panneau d'administrateur/formulaire.php" class="btn">S'inscrire</a>
                </div>
            <?php } ?>
            </div>
        </section>
    </header>

    <!-- Inclure Boxicons -->
            </body>
            </html>

