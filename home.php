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
      <title>Quizzle - Test Your Knowledge with Fun Quizzes</title>
      <meta name="description" content="Welcome to Quizzle! Play quizzes, earn points, and climb the leaderboard. Fun and educational for everyone." />
      <link rel="canonical" href="https://mansi-zanjale.github.io/home.php" />

      <link rel="stylesheet" href="style.css">
    </head>
    <body>

        <header class="header">
            <section class="flex">

               <strong><a class="logo">QUIZZLE</a></strong>
               <div class="hamburger" onclick="toggleMenu()">≣</div>
               <nav class="navbar">
                   <a href="home.php">Home</a>
                   <a href="login.php">Play</a>
                   <a href="#footer">About Us</a>
               </nav>
            </section>
        </header>


        <div class="home">
            <div class="first">
                <div class="ff">
                 <p>
                  We're thrilled to have you on board, ready to embark on a journey of knowledge, fun, and challenges. Get ready to test your wits and discover fascinating facts across various topics. Quizess and tests aren't just for education and learning. Our quiz games aslo include fun and unique questions. Our quiz game put the fun into learning. With our quiz game, you can improve your knowledge. 
                 </p>
                </div>

                <div class="start">
                   <button id="lp"> <a href="login.php"> Lets play</a></button>
                </div>
            </div>

            <div class="second">
             <p>NOTE: After clicking play you have to register or login to play the quiz </p>
            </div>
        </div>

        <footer id="footer">

            <a href="home.php"> <h1>Back To Home</h1></a>
            <section class="flex">

                <div class="box">
                  <h3>Help</h3>
                  <a href="privacy.html">Privacy</a>
                  <a href="terms.html">Terms & Conditions</a>
                  <a href="#">Policy</a>
                </div>

                <div class="box">
                  <h3>Contact Us</h3>
                  <a href="tel:1234567890">123-456-7890</a>
                  <a href="tel:1112223333">111-222-3333</a>
                  <a href="mailto:quizzle@gmail.com">quizzle@gmail.com</a>
                  <a href="Quizzle_Game"><b>Instagram :</b> official_quizzle</a>
                </div>

                <div class="box">
                  <img src="images\logo1.jpeg" alt="QUIZZLE LOGO">
                </div>

            </section>
        </footer>
        <script src="js/script.js"></script>
    </body>
</html>
