<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:users_accounts.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../admin_style.css">
  

</head>
<body>

<?php include 'admin_header.php'; ?>


<section class="show">

<h2>Showing All the users: </h2>

    <div class="box-container">
    

        <table>
            <thead>
                <tr>
                    <th>User id</th>
                    <th>Username</th>
                    <th>Email id</th>
                    <th>Score</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php
      $select_account = $conn->prepare("SELECT * FROM `users`");
      $select_account->execute();
      if($select_account->rowCount() > 0){
         while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
   ?>
                <tr>
                    <td><?= htmlspecialchars($fetch_accounts['id']); ?></td>
                    <td><?= htmlspecialchars($fetch_accounts['username']); ?></td>
                    <td><?= htmlspecialchars($fetch_accounts['email']); ?></td>
                    <td><?= htmlspecialchars($fetch_accounts['score']); ?></td>
                    <td>
                    <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">delete</a>
                    </td>
                </tr>
                <?php
      }
   }else{
      echo '<p class="empty">no accounts available</p>';
   }
   ?>
            </tbody>
        </table>
    </div>
</section>





<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>