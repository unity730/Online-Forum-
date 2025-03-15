<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
}

include('database/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $request_id = $_GET['request_id'];
    $action = $_GET['action'];  // 'approve' or 'reject'

    if ($action == 'approve') {
        $sql = "UPDATE admin_requests SET status = 'approved' WHERE id = $request_id";
    } elseif ($action == 'reject') {
        $sql = "UPDATE admin_requests SET status = 'rejected' WHERE id = $request_id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Admin request status updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<a href="approve_admin_request.php?request_id=1&action=approve">Approve Request</a>
<a href="approve_admin_request.php?request_id=1&action=reject">Reject Request</a>
