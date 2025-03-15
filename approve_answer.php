<?php
session_start();
include('database/db_connection.php');// Database connection


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$answer_id = $_GET['id'];

// Update the answer status to 'approved'
$sql = "UPDATE answers SET status = 'approved' WHERE id = '$answer_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: admin-dashboard.php"); // Redirect to admin dashboard after approval
    exit;
} else {
    echo "Error: " . $conn->error;
}
?>
