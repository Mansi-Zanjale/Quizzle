<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $select_name = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
      $select_name->execute([$name]);
      if($select_name->rowCount() > 0){
         echo"<script> alert('username already taken'); </script>";
      }else{
         $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
         $update_name->execute([$name, $admin_id]);
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
   $select_old_pass->execute([$admin_id]);
   $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         echo"<script> alert('old password not matched!'); </script>";
      }elseif($new_pass != $confirm_pass){
         echo"<script> alert('confirm password not matched!'); </script>";
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            echo"<script> alert('password updated successfully!'); </script>";
         }else{
            echo"<script> alert('please enter a new password'); </script>";
         }
      }
   }

}
   $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
   $select_profile->execute([$admin_id]);
   if($select_profile->rowCount() > 0){
      $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    }

?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Update Admin Profile | Quizzle</title>
      <meta name="robots" content="noindex, nofollow">

      <!-- font awesome cdn link  -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

      <!-- custom css file link  -->
      <link rel="stylesheet" href="../admin_style.css">
   </head>
   <body>

      <?php include 'admin_header.php'; ?>

      <!-- admin profile update section starts  -->

      <section class="form-container">

         <form action="" method="POST">
            <h3>update profile</h3>
            <input type="text" name="name" maxlength="20" placeholder="<?=htmlspecialchars($fetch_profile['name']);?>" class="box" oninput="this.value = this.value.replace(/\s/g, '')"readonly>
            <input type="text" name="name" maxlength="20" placeholder="Enter new username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="old_pass" maxlength="20" placeholder="enter old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" maxlength="20" placeholder="enter new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" maxlength="20" placeholder="confirm new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="update now" name="submit" class="btn">
         </form>
      </section>

      <!-- admin profile update section ends -->

      <!-- custom js file link  -->
      <script src="../js/admin_script.js"></script>

   </body>
</html>