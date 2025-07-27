<?php  
include 'components/connect.php';  
session_start();  

if(!isset($_SESSION['score'])) {  
    $_SESSION['score'] = 0;  
}  

$selected_category = isset($_GET['category']) ? $_GET['category'] : '';  

if ($selected_category == '') {  
    header('location: category.php');  
    exit();  
}  

// Fetch 10 random questions for the selected category  
$fetch_questions = $conn->prepare("SELECT * FROM `question` WHERE category = ? ORDER BY RAND() LIMIT 10");  
$fetch_questions->execute([$selected_category]);  
$questions = $fetch_questions->fetchAll(PDO::FETCH_ASSOC);  
?>  

<!DOCTYPE html>  
<html lang="en">  
    <head>  
      <meta charset="UTF-8">  
      <meta name="viewport" content="width=device-width, initial-scale=1.0">  
      <title>Play Quiz | Quizzle</title>
      <meta name="description" content="Answer timed questions and score points! Play quizzes based on your selected category." />
      <link rel="canonical" href="https://mansi-zanjale.github.io/play.php" />
 
      <link rel="stylesheet" href="style.css">  
    </head>  
    <body>  

      <header class="header">  
          <section class="flex">  
               <h1 class="user">Enjoy The Game</h1>  
               <div class="hamburger" onclick="toggleMenu()">≣</div>
                <nav class="navbar">  
                    <a href="category.php">Home</a>  
                    <a href="category.php">Category</a>  
                    <a href="profile.php">Profile</a>  
                </nav>  
           </section>  
       </header>  

       <section class="quiz-section">  
           <h2>Quiz: <?= htmlspecialchars($selected_category); ?></h2>  
           <div class="box">  
               <div id="quiz-container">  
                   <?php foreach ($questions as $index => $question) { ?>  
                       <div class="question-box" id="question_<?= $index + 1; ?>" <?= $index > 0 ? 'style="display:none;"' : ''; ?>>  
                          <p><strong>Q<?= $index + 1; ?>:</strong> <?= htmlspecialchars($question['question']); ?></p>  

                            <div class="options">  
                               <button class="option" onclick="checkAnswer(this, '<?= htmlspecialchars($question['correct']); ?>')" data-value="<?= htmlspecialchars($question['o1']); ?>"><?= htmlspecialchars($question['o1']); ?></button>  
                               <button class="option" onclick="checkAnswer(this, '<?= htmlspecialchars($question['correct']); ?>')" data-value="<?= htmlspecialchars($question['o2']); ?>"><?= htmlspecialchars($question['o2']); ?></button>  
                               <button class="option" onclick="checkAnswer(this, '<?= htmlspecialchars($question['correct']); ?>')" data-value="<?= htmlspecialchars($question['o3']); ?>"><?= htmlspecialchars($question['o3']); ?></button>  
                               <button class="option" onclick="checkAnswer(this, '<?= htmlspecialchars($question['correct']); ?>')" data-value="<?= htmlspecialchars($question['o4']); ?>"><?= htmlspecialchars($question['o4']); ?></button>  
                            </div>  

                            <!-- Next or Submit Button -->
                            <?php if ($index + 1 == count($questions)) { ?>
                               <button id="submit-btn" onclick="submitQuiz()" class="next-btn" style="display:none;">Submit</button>
                            <?php } else { ?>
                               <button onclick="nextQuestion(<?= $index + 1; ?>)" class="next-btn" style="display:none;">Next</button>
                            <?php } ?>
                        </div>  
                    <?php } ?>  

                    <!-- Hidden Form for Score Submission (Not Used Anymore) -->
                    <input type="hidden" name="score" id="score-input">
                </div>  
            </div>  
        </section>  


       <script src="js/script.js"></script>
       <script>
          let userScore = 0;

          // Function to check answer and update score
          function checkAnswer(button, correctAnswer) {
              let selectedAnswer = button.getAttribute("data-value");

              // Disable other options after selecting one
              let options = button.parentElement.getElementsByClassName("option");
              for (let i = 0; i < options.length; i++) {
                  options[i].disabled = true;
                }

               // Highlight correct or wrong answer
               if (selectedAnswer === correctAnswer) {
                   button.style.backgroundColor = "green";
                   userScore++;
               } 
               else {
                 button.style.backgroundColor = "red";
    
                    //Find and heighlight the right answer if user is wrong
                    for(let i=0 ;i<options.length; i++){
                        if(options[i].getAttribute("data-value")===correctAnswer){
                            options[i].style.backgroundColor="green";
                            break;
                        }
                    }
                }

                // Show the next or submit button
                let nextButton = button.closest(".question-box").querySelector(".next-btn");
                if (nextButton) {
                    nextButton.style.display = "block";
                }
            }

            // Function to go to the next question
            function nextQuestion(index) {
               document.getElementById("question_" + index).style.display = "none";
               document.getElementById("question_" + (index + 1)).style.display = "block";
            }

            // Function to submit the quiz
            function submitQuiz() {
              let finalScore = userScore; // Get final score
              let category = "<?= urlencode($selected_category); ?>"; // Get category from PHP

              console.log("Redirecting to result.php with score:", finalScore, "and category:", category);
              // Redirect to result.php with score and category
              window.location.href = "result.php?score=" + finalScore + "&category=" + encodeURIComponent(category);
            }
        </script>

    </body>  
</html>