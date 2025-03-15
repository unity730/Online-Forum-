<?php
session_start();
include('database/db_connection.php');

// Check if a question ID is provided in the URL
if (isset($_GET['id'])) {
    $question_id = $_GET['id'];

    // Fetch the question details
    $sql = "SELECT q.id as question_id, q.question,q.created_at, u.username, s.name as subject_name 
            FROM questions q 
            JOIN users u ON q.user_id = u.id 
            JOIN subjects s ON q.subject_id = s.id 
            WHERE q.id = $question_id";
    
    $result = $conn->query($sql);
    $question = $result->fetch_assoc();

    // Fetch the answers to the question
    $answer_sql = "SELECT a.id as answer_id, a.answer, u.username as answerer, a.created_at 
                   FROM answers a 
                   JOIN users u ON a.user_id = u.id 
                   WHERE a.question_id = $question_id AND a.status = 'approved' 
                   ORDER BY a.created_at ASC";
    $answer_result = $conn->query($answer_sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Details</title>
    <style>
        .question-container {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .answer-container {
            margin-left: 20px;
            border-left: 2px solid #ddd;
            padding-left: 20px;
            margin-top: 10px;
        }
        .answer {
            background-color: #e9f7f9;
            padding: 10px;
            margin-bottom: 10px;
        }
        .answerer {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="question-container">
        <h2>Question: <?php echo $question['question']; ?></h2>
        <p><strong>Subject:</strong> <?php echo $question['subject_name']; ?></p>
        <p><strong>Asked by:</strong> <?php echo $question['username']; ?></p>
        <p><strong>Posted on:</strong> <?php echo $question['created_at']; ?></p>
    </div>

    <div class="answer-container">
        <h3>Answers:</h3>

        <?php
        // Display the answers
        if ($answer_result->num_rows > 0) {
            while ($answer = $answer_result->fetch_assoc()) {
                echo "<div class='answer'>";
                echo "<p class='answerer'>" . $answer['answerer'] . ":</p>";
                echo "<p>" . $answer['answers'] . "</p>";
                echo "<p><small>Answered on: " . $answer['created_at'] . "</small></p>";
                echo "</div>";
            }
        } else {
            echo "<p>No answers yet. Be the first to answer!</p>";
        }
        ?>

        <!-- Answer Submission Form -->
        <?php if (isset($_SESSION['user_id'])): ?>
        <h4>Post an Answer:</h4>
        <form method="POST" action="post_answer.php">
            <textarea name="answer_text" placeholder="Your answer..." required></textarea><br>
            <input type="hidden" name="question_id" value="<?php echo $question['question_id']; ?>">
            <button type="submit">Submit Answer</button>
        </form>
        <?php else: ?>
        <p><a href="login.php">Login</a> to post an answer.</p>
        <?php endif; ?>
    </div>

</body>
</html>