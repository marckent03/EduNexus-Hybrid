<?php
session_start();
include 'connect.php';

if(!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

$where = "1=1";
if(isset($_GET['status']) && $_GET['status'] != '') {
    $status = $_GET['status'];
    $where .= " AND status='$status'";
}
if(isset($_GET['course']) && $_GET['course'] != '') {
    $course = $_GET['course'];
    $where .= " AND course_code LIKE '%$course%'";
}

$sql = "SELECT * FROM tblsession WHERE $where ORDER BY scheduled_at DESC";
$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html>
<head><title>Session List</title></head>
<body>
<div style='background-color:#ffff00'><center><h2>Sessions Management</h2></center></div>

<form method="get">
    Status: 
    <select name="status">
        <option value="">All</option>
        <option value="SCHEDULED">Scheduled</option>
        <option value="LIVE">Live</option>
        <option value="ENDED">Ended</option>
        <option value="CANCELLED">Cancelled</option>
    </select>
    Course Code: <input type="text" name="course">
    <input type="submit" value="Filter">
    <a href="session_create.php"><button type="button">+ New Session</button></a>
    <a href="dashboard.php"><button type="button">Back</button></a>
</form>
<br>

<table border="1" cellpadding="8">
    <tr bgcolor="#ddd">
        <th>ID</th><th>Course</th><th>Title</th><th>Mode</th><th>Scheduled</th><th>Status</th><th>Actions</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['session_id'] ?></td>
        <td><?= $row['course_code'] ?></td>
        <td><?= $row['session_title'] ?></td>
        <td><?= $row['session_mode'] ?></td>
        <td><?= $row['scheduled_at'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <a href="session_edit.php?id=<?= $row['session_id'] ?>">Edit</a> |
            <a href="session_delete.php?id=<?= $row['session_id'] ?>" onclick="return confirm('Delete session?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>