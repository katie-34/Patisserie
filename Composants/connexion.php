<?php
   $db_name='mysql:host=localhost;dbname=creme_glacée';
   $utilisateur = 'root';
   $password= '';

   $conn = new PDO($db_name, $utilisateur, $password);

   if(!$conn){
    echo "Connecté";
   }

   function unique_id(){
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($chars);
    $randomString = '';
    for ($i=0; $i < 20; $i++){
        $randomString.=$chars[mt_rand(0, $charLength - 1)];
    }
    return $randomString;
   }

?>