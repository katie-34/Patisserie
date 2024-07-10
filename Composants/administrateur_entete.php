<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>
<body>
<header>
    <div class="logo">
       <img src="../fichiers_téléchargés/logo.jpg" width="82">
    </div>
    <div class="right">
        <div class="bx bxs-user" id="user-btn"></div>
        <div class="toggle-btn"><i class="bx bx-menu"></i></div>
    </div>
    <div class="profile-detail">
        <?php
        
            $select_profile = $conn->prepare("SELECT * FROM `administrateurs` WHERE id = ? ");
            $select_profile->execute([$id_administrateur]);

            if($select_profile->rowCount() > 0){
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            
        ?>
            <div class="profile">
                <img src="../fichiers_téléchargés/<?= $fetch_profile['image']; ?>" class="logo-img" width="100" alt="Profile Image">
                <p><?= $fetch_profile['Nom']; ?></p>
                <div class="flex-btn">
                    <a href="profile.php" class="btn">Profile</a>
                    <a href="../Composants/admin_logout.php" onclick="return confirm('Voulez-vous vous déconnecter ?');" class="btn">Déconnexion</a>
                </div>
            </div>
        <?php } ?>
    </div>
</header>
<div class="sidebar-container">
    <div class="sidebar">
    <?php
        
        $select_profile = $conn->prepare("SELECT * FROM `administrateurs` WHERE id = ? ");
        $select_profile->execute([$id_administrateur]);

        if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        
    ?>
        <div class="profile">
            <img src="../fichiers_téléchargés/<?= $fetch_profile['image']; ?>" class="logo-img" width="100" alt="Profile Image">
            <p><?= $fetch_profile['Nom']; ?></p>
            
        </div>
    <?php } ?>
    <h5>menu</h5>
    <div class="navbar">
        <ul>
            <li>
                <a href="dashboard.php"><i class="bx bxs-home-smile"></i>dashboard</a>
            </li>
            <li>
                <a href="add_product.php"><i class="bx bxs-shopping-bags"></i>ajouter des gateaux</a>
            </li>
            <li>
                <a href="view_product.php"><i class="bx bxs-food-menu"></i>Voir mes gateaux</a>
            </li>
            <li>
                <a href="user_accounts.php"><i class="bx bxs-user-detail"></i>Comptes utilisateurs</a>
            </li>
            <li>
                <a href="../Composants/admin_logout.php" onclick="return confirm('Voulez-vous vraiment vous deconnectez de ce site ?');"><i class="bx bx-log-out"></i>déconnexion</a>
            </li>
        </ul>
    </div>
       <h5>Contacter nous</h5>
       <div class="social-links">
        <i class="bx bxl-facebook"></i>
        <i class="bx bxl-instagram-alt"></i>
        <i class="bx bxl-linkedin"></i>
        <i class="bx bxl-twitter"></i>
        <i class="bx bxl-pinterest-alt"></i>
       </div>

    </div>
</div>
</body>
</html>



























































