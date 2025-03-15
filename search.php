<?php
include('database/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $search_term = $_GET['search_term'];

    $sql = "SELECT questions.id, questions.question_text, subjects.name as subject_name 
            FROM questions
            JOIN subjects ON questions.subject_id = subjects.id
            WHERE questions.question_text LIKE '%$search_term%' OR subjects.name LIKE '%$search_term%'";

    $result = $conn->query($sql);
    echo "<h2>Search Results</h2>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div><a href='question.php?id=" . $row['id'] . "'>" . $row['question_text'] . "</a> - Subject: " . $row['subject_name'] . "</div>";
        }
    } else {
        echo "No results found.";
    }
}
?>

<form method="GET" action="search.php">
    <input type="text" name="search_term" placeholder="Search for questions or subjects" required>
    <button type="submit">Search</button>
</form>
