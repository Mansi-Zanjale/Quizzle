function validAge()
{
    const ageInput=document.getElementById("age").value;
    if(!ageInput || ageInput<16)
    {
        alert("you'r age is not valid for playing this game");
        return false;
    }
    return true;
}

document.querySelectorAll('.profile-img-option').forEach(img => {
    img.addEventListener('click', function() {
       document.querySelectorAll('.profile-img-option').forEach(el => el.classList.remove('selected'));
       this.classList.add('selected');
       document.getElementById('selected-pic').value = this.getAttribute('data-pic');
    });
 });





//  let userScore = 0;

// // Function to check answer and update score
// function checkAnswer(button, correctAnswer) {
//     let selectedAnswer = button.getAttribute("data-value");

//     // Disable other options after selecting one
//     let options = button.parentElement.getElementsByClassName("option");
//     for (let i = 0; i < options.length; i++) {
//         options[i].disabled = true;
//     }

//     // Highlight correct or wrong answer
//     if (selectedAnswer === correctAnswer) {
//         button.style.backgroundColor = "green";
//         userScore++;
//     } else {
//         button.style.backgroundColor = "red";
//     }

//     // Show the next or submit button
//     let nextButton = button.closest(".question-box").querySelector(".next-btn");
//     if (nextButton) {
//         nextButton.style.display = "block";
//     }
// }

// // Function to go to the next question
// function nextQuestion(index) {
//     document.getElementById("question_" + (index)).style.display = "none";
//     document.getElementById("question_" + (index + 1)).style.display = "block";
// }

// // Function to submit the quiz
// function submitQuiz() {
//     document.getElementById("score-input").value = userScore; // Update hidden input
//     console.log("submitting quiz with score: ",userScore);
//     document.getElementById("quiz-form").submit(); // Submit form
// }