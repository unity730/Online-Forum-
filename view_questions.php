<?php
session_start();
include('database/db_connection.php'); // Include database connection


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// Fetch approved questions from the database
$sql = "SELECT questions.id, questions.question, questions.created_at, users.username 
        FROM questions 
        INNER JOIN users ON questions.user_id = users.id 
        WHERE questions.status = 'approved'"; // Only show approved questions

$result = $conn->query($sql);
?>

<h1>Questions</h1>

<?php
if ($result->num_rows > 0) {
    // Loop through and display questions
    while ($row = $result->fetch_assoc()) {
        echo "<div class='question'>";
        echo "<p><strong>Asked by:</strong> " . $row['username'] . "</p>";
        echo "<p><strong>Question:</strong> " . $row['question'] . "</p>";
        echo "<p><strong>Posted on:</strong> " . $row['created_at'] . "</p>";

        // Display the answer form for logged-in users
        echo "<form method='POST' action='post-answer.php'>";
        echo "<input type='hidden' name='question_id' value='" . $row['id'] . "'>";
        echo "<textarea name='answer' placeholder='Write your answer here' required></textarea><br>";
        echo "<button type='submit'>Post Answer</button>";
        echo "</form>";

        // Fetch and display answers for this question
        $question_id = $row['id'];
        $answers_sql = "SELECT answers.id, answers.answer, answers.created_at, users.username FROM answers
                        INNER JOIN users ON answers.user_id = users.id
                        WHERE answers.question_id = '$question_id' AND answers.status = 'approved'"; // Approved answers only
        $answers_result = $conn->query($answers_sql);

        if ($answers_result->num_rows > 0) {
            echo "<h3>Answers:</h3>";
            while ($answer_row = $answers_result->fetch_assoc()) {
                echo "<div class='answer'>";
                echo "<p><strong>Answered by:</strong> " . $answer_row['username'] . "</p>";
                echo "<p><strong>Answer:</strong> " . $answer_row['answer'] . "</p>";
                echo "<p><strong>Posted on:</strong> " . $answer_row['created_at'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No answers yet for this question.</p>";
        }

        echo "</div><hr>"; // Closing the question block
    }
} else {
    echo "<p>No questions available.</p>";
}
?>
