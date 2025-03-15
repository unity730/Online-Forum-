<?php
session_start();
include('database/db_connection.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Query to get the count of pending questions
$pending_questions_sql = "SELECT * FROM questions WHERE status='pending'";
$pending_questions_result = $conn->query($pending_questions_sql);

// Query to get the count of pending answers
$pending_answers_sql = "SELECT * FROM answers WHERE status='pending'";
$pending_answers_result = $conn->query($pending_answers_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
  <link rel="stylesheet" href="a_style.css">
</head>
<body>
    <div class="header">
        <nav>
            <a href="manage-subjects.php">Manage Subjects</a>
            <a href="manage-questions.php">Manage Questions</a>
            <a href="manage-users.php">Manage Users</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
    
    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>
        <div class="pending-section">
            <h3>Pending Questions</h3>
            <?php
                if ($pending_questions_result && $pending_questions_result->num_rows > 0) {
                    echo "<p>Total Pending Questions: " . $pending_questions_result->num_rows . "</p>";
                } else {
                    echo "<p>No pending questions.</p>";
                }
            ?>
        </div>
        
        <div class="pending-section">
            <h3>Pending Answers</h3>
            <?php
                if ($pending_answers_result && $pending_answers_result->num_rows > 0) {
                    echo "<p>Total Pending Answers: " . $pending_answers_result->num_rows . "</p>";
                } else {
                    echo "<p>No pending answers.</p>";
                }
            ?>
        </div>
    </div>
    
    <div class="footer">
        &copy; 2025. All Rights Reserved.
    </div>
</body>
</html>
