<?php
include 'components/connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
   header("Location: login.php");
   exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_user->execute([$user_id]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

if (!$user) {
   session_destroy();
   header("Location: login.php");
   exit();
}

$profile_pic = $user['profile_pic'] ?? 'avatar1.png';

if (isset($_POST['update'])) {
   $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $new_profile_pic = $_POST['profile_pic'];

   $update_user = $conn->prepare("UPDATE `users` SET username = ?, email = ?, profile_pic = ? WHERE id = ?");
   $update_user->execute([$username, $email, $new_profile_pic, $user_id]);

   echo "<script> alert('profile updated successfully!'); </script>";
   header("Location: profile.php");
   exit();
}

$available_pictures = ["avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png", "avatar5.png", "avatar6.png", "avatar7.png"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Profile | Quizzle</title>
   <meta name="robots" content="noindex, nofollow">

   <link rel="stylesheet" href="style.css">

</head>

<body>
   <h1 class="h">Edit Profile</h1>

   <section class="edit-profile-container">



      <form action="" method="post">

         <div class="e">
            Username: &nbsp;&nbsp;
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required class="box"><br>
            Email:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="box">
         </div>



         <div class="profile-options">
            <h2>Profile Picture:</h2>
            <?php foreach ($available_pictures as $pic): ?>
               <img src="images/<?php echo $pic; ?>" class="profile-img-option <?php echo ($profile_pic == $pic) ? 'selected' : ''; ?>" data-pic="<?php echo $pic; ?>">
            <?php endforeach; ?>
         </div>

         <input type="hidden" name="profile_pic" id="selected-pic" value="<?php echo $profile_pic; ?>">

         <button type="submit" name="update" class="btn">Update Profile</button>


         <a href="profile.php" class="back">Back to Profile</a>

      </form>

      <script src="js/script.js"></script>

</body>

</html>