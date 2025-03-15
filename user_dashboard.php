<?php
session_start();
include('database/db_connection.php');
//include('functions.php');  // Include the helper function for generating default profile picture
/*
// Ensure the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: user_login.php');  // Redirect to login page if the user is not logged in
    exit();
}
*/

$user_id = $_SESSION['user_id']; // Get user ID from the session

// Fetch the user information from the database
$sql = "SELECT username, email, profile_picture FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Error fetching user data.";
    exit();
}

// Fetch the questions posted by the user
$questions_sql = "SELECT id,question, created_at FROM questions WHERE user_id = $user_id ORDER BY created_at DESC";
$questions_result = $conn->query($questions_sql);

// Fetch the answers provided by the user
$answers_sql = "SELECT id, question_id,answer, created_at FROM answers WHERE user_id = $user_id ORDER BY created_at DESC";
$answers_result = $conn->query($answers_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="u_style.css">
</head>
<body>

    <!-- Header Section with Profile on the Right -->
    <header>
        <!-- Links Section -->
        <div class="dashboard-links">
            <a href="profile.php">Edit Profile</a>
            <a href="add-question.php">Ask a Question</a>
        </div>

        <!-- Profile Section on the Right -->
        <div class="profile-header-in-header">
            <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture">
            <p><?php echo $user['username']; ?></p>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <div class="dashboard-container">

        <!-- Questions Section -->
        <div class="questions-section">
            <h3>Your Questions</h3>
            <?php
            if ($questions_result->num_rows > 0) {
                while ($question = $questions_result->fetch_assoc()) {
                    echo '<div class="question">';
                    echo '<div class="question-title">' . htmlspecialchars($question['question']) . '</div>';
                    echo '<div class="question-details">Asked on: ' . $question['created_at'] . '</div>';
                    
                    echo '<a href="add-answer.php"> reply </a>';
                    echo '</div>';
                }
            } else {
                echo '<p>You haven\'t asked any questions yet.</p>';
            }
            ?>
        </div>

        <!-- Answers Section -->
        <div class="answers-section">
            <h3>Your Answers</h3>
            <?php
            if ($answers_result->num_rows > 0) {
                while ($answer = $answers_result->fetch_assoc()) {
                    echo '<div class="answer">';
                    echo '<div class="answer-text">' . htmlspecialchars($answer['answer']) . '</div>';
                    echo '<div class="answer-details">Answered on: ' . $answer['created_at'] . ' | Question ID: ' . $answer['question_id'] . '</div>';
                    echo '<a href="view_questions.php?id=' . $answer['question_id'] . '">View Question</a>';
                    
                    echo '</div>';
                }
            } else {
                echo '<p>You haven\'t answered any questions yet.</p>';
            }
            ?>
        </div>

    </div>

   
    <footer>
        <p>&copy; 2025. All rights reserved.</p>
    </footer>

</body>
</html>
