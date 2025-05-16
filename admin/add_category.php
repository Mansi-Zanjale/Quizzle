<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_category'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);


    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;


    $select_category = $conn->prepare("SELECT * FROM `category` WHERE name = ?");
   $select_category->execute([$name]);


   if($select_category->rowCount() > 0){
      // echo"<script> alert('category name already exist!'); </script>";
 }else{
    if($image_size > 2000000){
      echo"<script> alert('image size is too large!'); </script>";
    }else{
      //  move_uploaded_file($image_tmp_name, $image_folder);


       $insert_category = $conn->prepare("INSERT INTO `category`(name,image) VALUES(?,?)");
       $insert_category->execute([$name,$image]);

       echo"<script> alert('new category added!'); </script>";
    }
  }
}




if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];

   // Fetch category name before deletion
   $select_category = $conn->prepare("SELECT * FROM `category` WHERE id = ?");
   $select_category->execute([$delete_id]);
   $fetch_category = $select_category->fetch(PDO::FETCH_ASSOC);

   if ($fetch_category) {
       $category_name = $fetch_category['name'];

       // Delete related questions first
       $delete_questions = $conn->prepare("DELETE FROM `question` WHERE category = ?");
       $delete_questions->execute([$category_name]);

       // Delete category image
       unlink('../uploaded_img/'.$fetch_category['image']);

       // Delete category itself
       $delete_category = $conn->prepare("DELETE FROM `category` WHERE id = ?");
       $delete_category->execute([$delete_id]);

       header('location:add_category.php');
   }
}
 
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="../admin_style.css">

</head>
<body>
<?php include 'admin_header.php'; ?>    

<section class="add-category">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add category</h3>
      <input type="text" required placeholder="enter category name" name="name" maxlength="100" class="box">
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add category" name="add_category" class="btn">
   </form>

</section>




<section class="show-category">

   <div class="box-container">

   <?php
      $show_category = $conn->prepare("SELECT * FROM `category`");
      $show_category->execute();
      if($show_category->rowCount() > 0){
         while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../images/<?= $fetch_category['image']; ?>" alt="">
      <div class="name"><?= htmlspecialchars($fetch_category['name']); ?></div>
      <div class="flex-btn">
         <a href="add_question.php?category=<?= urlencode($fetch_category['name']); ?>" class="option-btn">questions</a>
         <!-- updated above -->
         <a href="add_category.php?delete=<?= $fetch_category['id']; ?>" class="delete-btn" onclick="return confirm('sure you want to delete this category?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no categories added yet!</p>';
      }
   ?>

   </div>

</section>

</body>
</html>