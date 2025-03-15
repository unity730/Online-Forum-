<?php
include('database/db_connection.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE questions SET status='approved' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage-questions.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
