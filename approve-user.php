<?php
session_start();
include('database/db_connection.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit;
}


$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<h1>Manage Users</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <a href="approve-user.php?id=<?php echo $row['id']; ?>">Approve</a> |
                <a href="block-user.php?id=<?php echo $row['id']; ?>">Block</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
