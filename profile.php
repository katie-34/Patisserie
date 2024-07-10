<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

include 'Composants/connexion.php';

if (isset($_COOKIE['id_utilisateur'])) {
    $user_id = $_COOKIE['id_utilisateur'];
} else {
    header('Location: login.php');
    exit;
}

$select_orders = $conn->prepare("SELECT * FROM `commandes` WHERE id_utilisateur = ?");
$select_orders->execute([$user_id]);
$total_orders = $select_orders->rowCount();

$select_profile = $conn->prepare("SELECT * FROM `utilisateurs` WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Profil utilisateur</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
<?php include 'Composants/user_header.php'; ?>

<section class="profile">
    <div class="heading">
        <h1>Profil utilisateur</h1>
    </div>
    <div class="details">
        <div class="user">
            <img src="fichiers_téléchargés/<?= htmlspecialchars($fetch_profile['image']); ?>" alt="Profile Image">
            <h3><?= htmlspecialchars($fetch_profile['Nom']); ?></h3>
            <p>Utilisateur</p>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="flex">
                    <i class="bx bxs-folder-minus"></i>
                    <h3><?= $total_orders; ?></h3>
                </div>
                <a href="order.php" class="btn">Voir mes commandes</a>
            </div>
            <div class="box">
                <div class="flex">
                    <i class="bx bxs-log-out"></i>
                </div>
                <a href="user_logout.php" class="btn">Se déconnecter</a>
            </div>
        </div>
    </div>
</section>

<?php include 'Composants/footer.php'; ?>   

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include 'Composants/alert.php'; ?>
</body>
</html>
