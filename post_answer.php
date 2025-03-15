<?php
session_start();
include('database/db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $question_id = $_POST['question_id'];
    $answer_text = $_POST['answer'];

    // Insert the answer into the database
    $sql = "INSERT INTO answers (question_id, user_id, answer, status) 
            VALUES ('$question_id', '$user_id', '$answer_text', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "Your answer has been posted and is awaiting approval!";
        header("Location: question.php?id=$question_id");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>