<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){   
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">

        <section class="flex">

        <h1 class="user">  Welcome &nbsp;
       
        <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
               echo '<p class"name">'. htmlspecialchars($fetch_profile['username']).'</p>';
            }
         ?>


            </h1>  


            <nav class="navbar">
                <a href="home.php">Home</a>
                <a href="profile.php">Profile</a>
                <a href="leaderboard.php">Leaderboard</a>
            </nav>

        </section>
    </header>

    <div class="c">
    <div class="start">
        <h1 class="s m">Lets get Started!!!</h1>
    </div>




<section class="show-category">

   <div class="box-container">

      <?php
         $select_category = $conn->prepare("SELECT * FROM `category`");
         $select_category->execute();
         if($select_category->rowCount() > 0){
            while($fetch_category = $select_category->fetch(PDO::FETCH_ASSOC)){
      ?>


         <div class="box">
           <form action="" method="post">
           <input type="hidden" name="image" value="<?= $fetch_category['image']; ?>">
           <img src="images/<?= $fetch_category['image']; ?>" alt="">
           <h1><div class="name"><?= $fetch_category['name']; ?></div></h1>


            <div class="flex">
               <a href="play.php?category=<?=urlencode($fetch_category['name']);?>" class="p">  play   </a>
            </div>
       </div>
          <?php
           }
            }else{
            echo '<p class="empty">no categories added yet!</p>';
           }
          ?>

   </div>

   <audio id="resultAudio" autoplay>
      <source src="audio/register_login.mpeg" type="audio/mpeg">
      <!-- Your browser does not support the audio tag. -->
   </audio>


</section>

</div>

<script>
      // Play audio when the page loads
      window.onload = function() {
         let audio = document.getElementById("resultAudio");
         audio.play();
      };
   </script>
    
</body>
</html>