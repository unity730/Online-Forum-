<?php
session_start();
include('database/db_connection.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}

// Fetch all questions
$sql = "SELECT * FROM questions";
$result = $conn->query($sql);
?>

<h1>Manage Questions</h1>
<table>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Subject</th>
        <th>Question</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['subject_id']; ?></td>
            <td><?php echo $row['question']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <a href="approve-question.php?id=<?php echo $row['id']; ?>">Approve</a> |
                <a href="block-question.php?id=<?php echo $row['id']; ?>">Block</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
