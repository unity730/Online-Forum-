<?php
include('database/db_connection.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE subjects SET status='blocked' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage-subjects.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
