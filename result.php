<?php 
session_start();
include 'components/connect.php';

// Check if score is received
$score = $_POST['score'] ?? $_GET['score'] ?? 0;

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$selected_category = isset($_GET['category']) ? $_GET['category'] : ''; 

$category = $_GET['category'] ?? 'default';

// Fetch previous score
$fetch_old_score = $conn->prepare("SELECT score FROM `users` WHERE id = ?");
$fetch_old_score->execute([$user_id]);
$old_score = $fetch_old_score->fetchColumn();

// Update score in database
$update_score = $conn->prepare("UPDATE `users` SET score = score + ? WHERE id = ?");
$update_score->execute([$score, $user_id]);

// Fetch updated score
$fetch_new_score = $conn->prepare("SELECT score FROM `users` WHERE id = ?");
$fetch_new_score->execute([$user_id]);
$new_score = $fetch_new_score->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <link rel="stylesheet" href="style.css">  
</head>
<body>

<section class="result-section">
    <h2>Quiz Completed!</h2>
    <h1>Quiz: <?= htmlspecialchars($selected_category); ?></h1> 
    <p>Your Score: <strong><?= htmlspecialchars($score); ?>/10</strong></p>
    <p >Total Score:<br> <strong class="total"><?= htmlspecialchars($new_score); ?></strong></p><br><br>
     
    <?php 
    function getStars($score){
       if($score>=10) return 5;
       if($score>=8) return 4;
       if($score>=6) return 3;
       if($score>=4) return 2;
       if($score>=2) return 1;
       return 0;
    }
    $stars=getStars($score);

    $update_stars = $conn->prepare("UPDATE `users` SET stars= stars+? WHERE id=?");
    $update_stars->execute([$stars,$user_id]);

    $fetch_new_stars = $conn->prepare("SELECT stars from `users` WHERE id=?");
    $fetch_new_stars->execute([$user_id]);
    $fetch_new_stars->fetchColumn();
    ?>
 
     <!-- <p class="star">⭐</p> -->
     <p class="star"><?php for($i = 0; $i < $stars; $i++):?> ⭐ <?php endfor; ?></p><br>

    <a href="play.php?category=<?=urlencode($category);?>" class="btn again">Play Again</a>
    <a href="category.php" class="btn again">Category</a>

   <audio id="resultAudio" autoplay>
      <source src="audio/result.mpeg" type="audio/mpeg">
   </audio>

</section>

<script>
      // Play audio when the page loads
      window.onload = function() {
         let audio = document.getElementById("resultAudio");
         audio.play();
      };

   </script>
  
     


</body>
</html>