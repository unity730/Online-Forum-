<?php
include('database/db_connection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $sql = "INSERT INTO subjects (name) VALUES ('$name')";
    if ($conn->query($sql) === TRUE) {
        echo "Subject added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


<form method="POST" action="add_subject.php">
    <input type="text" name="name" placeholder="Subject Name" required><br>
    <button type="submit">Add Subject</button>
</form>