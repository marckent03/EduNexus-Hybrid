<?php
session_start();
include 'connect.php';
if($_SESSION['role'] != 'it_support' && $_SESSION['role'] != 'admin') {
    echo "<script>alert('Access denied'); window.location='dashboard.php';</script>";
    exit;
}

if(isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $newstatus = $_GET['action'];
    mysqli_query($connection, "UPDATE tbltechnical_issue SET status='$newstatus' WHERE issue_id=$id");
    echo "<script>alert('Status updated'); window.location='issue_list.php';</script>";
}

$sql = "SELECT i.*, u.first_name, u.last_name FROM tbltechnical_issue i 
        JOIN tbluser u ON i.reported_by = u.user_id ORDER BY i.reported_at DESC";
$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html>
<head><title>Issue Tracker</title></head>
<body>
<div style='background-color:#ffff00'><center><h2>Technical Issues</h2></center></div>
<table border="1" cellpadding="8">
    <tr bgcolor="#ddd">
        <th>ID</th><th>Category</th><th>Description</th><th>Reported By</th><th>Status</th><th>Priority</th><th>Action</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['issue_id'] ?></td>
        <td><?= $row['category'] ?></td>
        <td><?= $row['description'] ?></td>
        <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
        <td><?= $row['status'] ?></td>
        <td><?= $row['priority'] ?></td>
        <td>
            <?php if($row['status'] == 'OPEN'): ?>
                <a href="issue_list.php?action=IN_PROGRESS&id=<?= $row['issue_id'] ?>">Mark In Progress</a>
            <?php elseif($row['status'] == 'IN_PROGRESS'): ?>
                <a href="issue_list.php?action=RESOLVED&id=<?= $row['issue_id'] ?>">Resolve</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="dashboard.php">Back</a>
</body>
</html>