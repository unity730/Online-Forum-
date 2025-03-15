<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit;
}

include('database/db_connection.php');
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $subject_id = $_POST['subject_id'];
    $question = $_POST['question'];

    $sql = "INSERT INTO questions (user_id, subject_id, question) VALUES ('$user_id', '$subject_id', '$question')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Question added successfully!</p>";
        header("location: user_dashboard.php");
    } else {
        echo "<p class='error'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
        }
        select, textarea, button {
            width: 100%;
            margin: 10px 10px 10px 0; /* Added margin on the right side */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .success {
            color: green;
            text-align: center;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add a Question</h2>
        <form method="post">
            <select name="subject_id" required>
                <option value="">Select a subject</option>
                <?php
                $result = $conn->query("SELECT * FROM subjects WHERE status='active'");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
            <textarea name="question" placeholder="Write your question here" required></textarea>
            <button type="submit">Add Question</button>
        </form>
    </div>
</body>
</html>