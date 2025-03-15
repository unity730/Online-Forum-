<?php
session_start();
include('database/db_connection.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}

// Fetch all subjects
$sql = "SELECT * FROM subjects";
$result = $conn->query($sql);
?>

<h1>Manage Subjects</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <a href="block-subject.php?id=<?php echo $row['id']; ?>">Block</a> |
                <a href="delete-subject.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Add New Subject</h2>
<form method="post" action="add-subject.php">
    <input type="text" name="name" placeholder="Subject Name" required>
    <button type="submit">Add Subject</button>
</form>
