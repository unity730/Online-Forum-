<?php
session_start();
include('database/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

   
    if (isset($_POST['question_id']) && isset($_POST['answer'])) {
        $question_id = $_POST['question_id'];
        $answer = $_POST['answer'];

       
        if (!empty($question_id)) {
            $sql = "INSERT INTO answers (user_id, question_id, answer) VALUES ('$user_id', '$question_id', '$answer')";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success-message'>Answer added successfully!</p>";
                header('location:user_dashboard.php');
            } else {
                echo "<p class='error-message'>Error: " . $conn->error . "</p>";
            }
        } else {
            echo "<p class='error-message'>Please select a question.</p>";
        }
    } else {
        echo "<p class='error-message'>Please fill in all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Answer</title>
     <link rel="stylesheet" href="css/aq_style.css">
</head>
<body>

<div class="container">
    <h1>Add Your Answer</h1>
    <form method="post">
        <select name="question_id" required>
            <option value="">Select a question</option>
           
            <?php
            $result = $conn->query("SELECT * FROM questions WHERE status='approved'");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['question']}</option>";
                }
            } else {
                echo "<option value=''>No questions available</option>";
            }
            ?>
        </select>
        <textarea name="answer" placeholder="Write your answer here" required></textarea>
        <button type="submit">Add Answer</button>
    </form>
</div>

</body>
</html>

