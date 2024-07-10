<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
     include 'Composants/connexion.php';

     if (isset($_COOKIE['id_utilisateur'])) {
      $user_id = $_COOKIE['id_utilisateur'];
  } else {

      $user_id = '';
      
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Fresh Tasty Bakery - Page d'accueil</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

    <body>
      
       

       
        <div class="slider-container">
        <?php include 'Composants/user_header.php'; ?>
           <div class="slider">
              <div class="slideBox active">
                  <div class="textBox">
                     <h1>Nous sommes fiers de nos <br> saveurs exceptionnelles</h1>
                     <a href="menu.php" class="btn">Acheter maintenant</a>
                    </div>
                    <div class="imgBox">
                       <img src="image/slider.jpg" alt="">
                    </div>
                </div>
              <div class="slideBox active">
                  <div class="textBox">
                       <h1>Les desserts sont ma sorte <br> de confort</h1>
                       <a href="menu.php" class="btn">Acheter maintenant</a>
                  </div>
                  <div class="imgBox">
                        <img src="image/sliderr.jpg" alt="">
                 </div>
               </div>
            </div>
           <ul class="controls">
                <li onclick="nextSlide();" class="next"><i class="bx bx-right-arrow-alt"></i></li>
                <li onclick="prevSlide();" class="prev"><i class="bx bx-left-arrow-alt"></i></li>
            </ul>
       </div>
        <div class="service">
        <div class="box-container">
           <div class="box">
              <div class="icon">
                <div class="icon-box">
                    <img src="image/services.png" class="img1">
                    <img src="image/services (1).png" class="img2">
                </div>
              </div>
              <div class="detail">
                <h4>Livraison</h4>
                <span>100% securisée</span>
              </div>
           </div>
           <div class="box">
              <div class="icon">
                <div class="icon-box">
                    <img src="image/services (2).png" class="img1">
                    <img src="image/services (3).png" class="img2">
                </div>
              </div>
              <div class="detail">
                <h4>Paiement</h4>
                <span>100% securisé</span>
              </div>
           </div>
        </div>
    </div>
    <div class="categories">
         <div class="heading">
            <h1>Categories</h1>
       </div>
         <div class="box-container">
                <div class="box">
                   <img src="image/categories.jfif" alt="">
                   <a href="menu.php" class="btn">Chocolat</a>
                  </div>
                 <div class="box">
                    <img src="image/categories1.jfif" alt="">
                    <a href="menu.php" class="btn">Fraisier</a>
                </div>
                <div class="box">
                   <img src="image/categories2.jfif" alt="">
                   <a href="menu.php" class="btn">Vanille</a>
                </div>
                <div class="box">
                   <img src="image/categories3.jfif" alt="">
                   <a href="menu.php" class="btn">Gateau de Mariage</a>
                 </div>
                <div class="box">
                     <img src="image/categories4.jfif" alt="">
                     <a href="menu.php" class="btn">Gateau d'anniversaire</a>
                 </div>
                <div class="box">
                     <img src="image/categories5.jfif" alt="">
                     <a href="menu.php" class="btn">Nos tartes</a>
                 </div>
              </div>
      </div>
      <img src="image/menu-banner.webp" class="menu-banner" alt="">
      <div class="taste">
      <div class="heading">
            <span>Pour les petites faims</span>
            <h1>Acheter trois gateaux et obtenez -50% de reduction</h1>
       </div>
       <div class="box-container">
         <div class="box">
            <img src="image/taste.webp" alt="">
            <div class="detail">
               <h2>Cupcakes</h2>
               <h1>Vanille</h1>
            </div>
         </div>
         <div class="box">
            <img src="image/taste1.jfif" alt="">
            <div class="detail">
               <h2>Cupcakes</h2>
               <h1>Caramel</h1>
            </div>
         </div>
         <div class="box">
            <img src="image/taste2.jfif" alt="">
            <div class="detail">
               <h2>Cupcakes</h2>
               <h1>Chocolat</h1>
            </div>
         </div>
       </div>
      </div>
      <div class="cake-container">
         <div class="overlay"></div>
            <div class="detail">
               <h1>Que des delicieux gateaux <br>fait Maison</h1><br><br><br><br>
               <a href="menu.php" class="btn">Achetez maintenant</a>  
         </div>
      </div>
      <div class="taste2">
         <div class="t-banner">
          <div class="overlay"></div>
               <div class="detail">
                  <h1>Trouvez votre bonheur ici</h1>
                  <p>Goutez nos delicieux et magnifiques gateau fait maison !</p>
                  <a href="menu.php" class="btn">Achetez maintenant</a>
           </div>
       </div>
         <div class="box-container">
            <div class="box">
               <div class="box-overlay">
                  <img src="image/type4.jfif" alt="">
                  <div class="box-details fadeIn-bottom">
                     <h1>Framboise</h1>
                     <p>Trouvez votre bonheur ici</p>
                     <a href="menu.php" class="btn">Decouvrir plus</a>
                  </div>
               </div>
            </div>
            <div class="box">
               <div class="box-overlay">
                  <img src="image/type5.jfif" alt="">
                  <div class="box-details fadeIn-bottom">
                     <h1>Framboise</h1>
                     <p>Trouvez votre bonheur ici</p>
                     <a href="menu.php" class="btn">Decouvrir plus</a>
                  </div>
               </div>
            </div>
            <div class="box">
               <div class="box-overlay">
                  <img src="image/type6.jfif" alt="">
                  <div class="box-details fadeIn-bottom">
                     <h1>Charlotte aux fraises</h1>
                     <p>Trouvez votre bonheur ici</p>
                     <a href="menu.php" class="btn">Decouvrir plus</a>
                  </div>
               </div>
            </div>
            <div class="box">
               <div class="box-overlay">
                  <img src="image/type7.jfif" alt="">
                  <div class="box-details fadeIn-bottom">
                     <h1>Gateau nutella</h1>
                     <p>Trouvez votre bonheur ici</p>
                     <a href="menu.php" class="btn">Decouvrir plus</a>
                  </div>
               </div>
            </div>
            
         </div>
      </div>
   </div>
   <br><br><br><br><br><br><br><br><br><br>
  <div class="pride">
   <div class="detail">
      <h1>Nous Sommes Fiers De Nos <br> faveurs Exceptionnelles</h1>
      <br>
      <a href="menu.php" class="btn">Achetez maintenant</a>
   </div>
  </div>
  <?php include 'Composants/footer.php'; ?>   
    

      


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/user_script.js"></script>
    <?php include 'Composants/alert.php'; ?>
    
</body>
</html>
