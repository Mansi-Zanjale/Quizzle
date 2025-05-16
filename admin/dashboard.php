<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

   <div class="box">
      <h3>welcome!</h3>
      <!-- <p>Admin</p> -->
      <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
               echo '<p class"name">'. htmlspecialchars($fetch_profile['name']).'</p>';
            }
         ?>
      <a href="update_profile.php" class="btn">update profile</a>
   </div>


   <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         $numbers_of_users = $select_users->rowCount();
      ?>
      <h3>users accounts</h3>
      <p><?= $numbers_of_users; ?></p>
      <a href="users_accounts.php" class="btn">see users</a>
   </div>


   <div class="box">
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `admin`");
         $select_admins->execute();
         $numbers_of_admins = $select_admins->rowCount();
      ?>
      <h3>admins</h3>
      <p><?= $numbers_of_admins; ?></p>
      <a href="admin_accounts.php" class="btn">see admins</a>
   </div>



   <div class="box">
      <?php
         $select_category = $conn->prepare("SELECT * FROM `category`");
         $select_category->execute();
         $numbers_of_category = $select_category->rowCount();
      ?>
      <h3>category Added</h3>
      <p><?= $numbers_of_category; ?></p>
      <a href="add_category.php" class="btn">see categories</a>
   </div>
   

   </div>
</section>