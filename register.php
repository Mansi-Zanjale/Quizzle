<?php
include 'components/connect.php';
session_start();

$message = []; // Initialize message array

if (isset($_POST['submit'])) {
    $username = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $age = filter_var($_POST['age'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 16, 'max_range' => 100]]);
    $contact=$_POST['contact'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['cpass'];

    // Validate age
    if ($age === false) {
        $message[] = 'Invalid age. Age must be between 16 and 100.';
    }
    //valid contact number
    if(!preg_match('/^[789]\d{9}$/',$contact)||preg_match('/^0{10}$/',$contact))
    {
      $message[]='Invalid contact number.';
    }


    // Validate password match
    if ($password !== $confirm_password) {
        $message[] = 'Passwords do not match!';
    }

    // Check if email already exists
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);

    if ($select_user->rowCount() > 0) {
        $message[] = 'Email already exists!';
    }

    // If no errors, insert user into the database
    if (empty($message)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Secure password hashing

        $insert_user = $conn->prepare("INSERT INTO `users` (username, email, age, contact, password) VALUES (?, ?, ?, ?, ?)");
        $insert_user->execute([$username, $email, $age, $contact, $hashed_password]);

        // Auto-login the user after registration
        $user_id = $conn->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        
        header("Location: category.php"); // Redirect to category selection
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link -->
   <link rel="stylesheet" href="style.css">
</head>
<body class="limg">

<section class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>

      <!-- Display error messages -->
      <?php if (!empty($message)): ?>
         <div class="error-messages">
            <?php foreach ($message as $msg): ?>
               <p class="error"><?php echo $msg; ?></p>
            <?php endforeach; ?>
         </div>
      <?php endif; ?>

      <input type="text" name="name" required placeholder="Enter your name" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="Enter your email" class="box" maxlength="50">
      <input type="number" name="age" required placeholder="Enter your age" class="box" min="16" max="100">
      <input type="text" name="contact" required placeholder="Enter your contact number" class="box"  maxlength="10">
      <input type="password" name="pass" required placeholder="Enter your password" class="box" maxlength="50">
      <input type="password" name="cpass" required placeholder="Confirm your password" class="box" maxlength="50">
      <input type="submit" value="Register Now" name="submit" class="bbtn">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</section>

<script src="js/script.js"></script>
</body>
</html>