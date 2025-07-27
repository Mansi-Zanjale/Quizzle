<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

$selected_category = isset($_GET['category']) ? $_GET['category'] : '' ;


if(isset($_POST['add_question'])){

    $question = $_POST['question'];

    $o1 = $_POST['o1'];
   
    $o2 = $_POST['o2'];
   
    $o3 = $_POST['o3'];

    $o4 = $_POST['o4'];
   
    $correct = $_POST['correct'];
   
    $category = $_POST['category'];
  


   $check_question = $conn->prepare("SELECT COUNT(*) FROM `question` WHERE question = ? AND category = ?");
   $check_question->execute([$question,$category]);
   $exist = $check_question->fetchColumn();

    if($exist > 0){
      echo"<script> alert('question already exists in this category!'); </script>";
 }else{
      
       $insert_question = $conn->prepare("INSERT INTO `question`(question, o1, o2, o3, o4, correct, category) VALUES(?,?,?,?,?,?,?)");
       $insert_question->execute([$question, $o1, $o2, $o3, $o4, $correct, $category]);

       echo"<script> alert('new question is added!'); </script>";
    }
}

$show_question = $conn->prepare("SELECT * FROM `question` WHERE category =?");
$show_question->execute([$selected_category]);

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    
    $delete_question = $conn->prepare("DELETE FROM `question` WHERE id = ?");
    $delete_question->execute([$delete_id]);
    header('location:add_question.php?category='.urlencode($selected_category));
 
}
 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Add Question | Admin Panel - Quizzle</title>
      <meta name="robots" content="noindex, nofollow">

      <link rel="stylesheet" href="../admin_style.css">
    </head>
    <body>

        <?php include 'admin_header.php'; ?>
    
        <section class="add-question">

            <?php 
                if(isset($message))
                {
                    foreach($message as $msg)
                    {
                      echo '<div class="message">'.$msg.'</div>';
                    }
                }
            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <h3>add Question</h3>
                <input type="text" name="category" class="box" value="<?=htmlspecialchars($selected_category);?>"readonly>
                <input type="text" required placeholder="enter question" name="question" maxlength="100" class="box">
                <input type="text" required placeholder="enter option 1" name="o1" maxlength="100" class="box">
                <input type="text" required placeholder="enter option 2" name="o2" maxlength="100" class="box">
                <input type="text" required placeholder="enter option 3" name="o3" maxlength="100" class="box">
                <input type="text" required placeholder="enter option 4" name="o4" maxlength="100" class="box">
                <input type="text" required placeholder="correct option" name="correct" maxlength="100" class="box">
                <input type="submit" value="add question" name="add_question" class="btn">
            </form>

        </section>

        <section class="show">

            <h2>Showing Questions for Category: <?=htmlspecialchars($selected_category);?></h2>
            <div class="box-container">
    
                <table>
                    <thead>
                        <tr>
                          <th>Question</th>
                          <th>Option 1</th>
                          <th>Option 2</th>
                          <th>Option 3</th>
                          <th>Option 4</th>
                          <th>Correct</th>
                          <th>Category</th>
                          <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          while ($fetch_question = $show_question->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                           <td class="q"><?= html_entity_decode($fetch_question['question']); ?></td>
                           <td><?= html_entity_decode($fetch_question['o1']); ?></td>
                           <td><?= html_entity_decode($fetch_question['o2']); ?></td>
                           <td><?= html_entity_decode($fetch_question['o3']); ?></td>
                           <td><?= html_entity_decode($fetch_question['o4']); ?></td>
                           <td><?= html_entity_decode($fetch_question['correct']); ?></td>
                           <td><?= html_entity_decode($fetch_question['category']); ?></td>
                           <td>
                             <a href="add_question.php?delete=<?= $fetch_question['id']; ?>&category=<?=urlencode($selected_category);?>" class="delete-btn" onclick="return confirm('Delete this question?');">Delete</a>
                           </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </body>
</html>