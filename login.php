<?php
include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
   header("Location: category.php"); // Redirect if already logged in
   exit();
}

$message = ''; // To store login error message

if (isset($_POST['submit'])) {
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $password = $_POST['pass'];

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if ($row && password_verify($password, $row['password'])) {
      $_SESSION['user_id'] = $row['id'];
      header("Location: category.php"); // Redirect after successful login
      exit();
   } else {
      echo "<script> alert('incorrect email or password!'); </script>";
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login | Quizzle</title>
   <meta name="robots" content="noindex, nofollow">


   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">
   <style>
      body {
         height: 100vh;
      }
   </style>
</head>

<body class="limg">
   <section class="form-container">
      <form action="" method="post">
         <h3>Login To Play</h3>

         <?php if (!empty($message)): ?>
            <p class="error"><?php echo $message; ?></p>
         <?php endif; ?>

         <input type="email" name="email" required placeholder="Enter your email" class="box" maxlength="50">
         <input type="password" name="pass" required placeholder="Enter your password" class="box" maxlength="50">
         <input type="submit" value="Login Now" name="submit" class="bbtn">
         <p>Don't have an account? <a href="register.php">Register now</a></p>
      </form>
   </section>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>