<?php

include 'Composants/connexion.php';

if (isset($_COOKIE['id_utilisateur'])) {
    $user_id = $_COOKIE['id_utilisateur'];
} else {
    header('Location:login.php');
    exit();
}

$orders = $conn->prepare("SELECT * FROM commandes WHERE id_utilisateur = ? ORDER BY date DESC");
$orders->execute([$user_id]);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos Commandes</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
</head>
<body>
<?php include 'Composants/user_header.php'; ?>

<div class="order-container">
    <h1>Vos Commandes</h1>

    <?php
    if ($orders->rowCount() > 0) {
        while ($order = $orders->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="order-box">
                <h3>Commande ID: <?= htmlspecialchars($order['id']); ?></h3>
                <p>Nom: <?= htmlspecialchars($order['Nom']); ?></p>
                <p>Numéro: <?= htmlspecialchars($order['Numero']); ?></p>
                <p>Email: <?= htmlspecialchars($order['Email']); ?></p>
                <p>Adresse: <?= htmlspecialchars($order['adresse']); ?></p>
                <p>Type d'adresse: <?= htmlspecialchars($order['type_adresse']); ?></p>
                <p>Mode de paiement: <?= htmlspecialchars($order['methode']); ?></p>
                <p>Produit ID: <?= htmlspecialchars($order['id_produit']); ?></p>
                <p class="price">Prix: <?= htmlspecialchars($order['prix']); ?>f</p>
                <p>Quantité: <?= htmlspecialchars($order['quantite']); ?></p>
                <p>Date de commande: <?= htmlspecialchars($order['date_commande']); ?></p>
            </div>
            <?php
        }
    } else {
        echo '<p class="empty">Vous n\'avez pas encore passé de commande.</p>';
    }
    ?>

</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/user_script.js"></script>
<?php include 'Composants/footer.php'; ?>
<?php include 'Composants/alert.php'; ?>

</body>
</html>
