<?php
session_start();
include 'connect.php';

if(!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if($role == 'instructor' || $role == 'admin') {
    $sched = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM tblsession WHERE status='SCHEDULED'"));
    $live = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM tblsession WHERE status='LIVE'"));
    $issues = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM tbltechnical_issue WHERE status='OPEN'"));
}

$notifications = [];
if($role == 'student') {
    $sql = "SELECT * FROM tblnotification WHERE user_id = $user_id ORDER BY sent_at DESC LIMIT 10";
    $result = mysqli_query($connection, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<div style='background-color:#ffff00'>
    <center>
        <h2>Welcome, <?php echo $username; ?> (<?php echo ucfirst($role); ?>)</h2>
    </center>
</div>

<br>

<?php if($role == 'instructor' || $role == 'admin'): ?>
<table border="0" width="80%" align="center">
    <tr>
        <td align="center" style="border:1px solid #ccc; padding:10px">
            <strong>Scheduled Sessions</strong><br>
            <?php echo $sched['total']; ?>
        </td>
        <td align="center" style="border:1px solid #ccc; padding:10px">
            <strong>Live Sessions</strong><br>
            <?php echo $live['total']; ?>
          </td>
        <td align="center" style="border:1px solid #ccc; padding:10px">
            <strong>Open Issues</strong><br>
            <?php echo $issues['total']; ?>
          </td>
    </tr>
</table>
<br>
<?php endif; ?>

<?php if($role == 'student'): ?>
    <h3>Notifications</h3>
    <?php if(count($notifications) > 0): ?>
    <table border="1" cellpadding="8">
        <tr bgcolor="#f2f2f2">
            <th>Message</th><th>Type</th><th>Sent At</th><th>Status</th>
        </tr>
        <?php foreach($notifications as $notif): ?>
        <tr>
            <td><?php echo $notif['message']; ?></td>
            <td><?php echo $notif['type']; ?></td>
            <td><?php echo $notif['sent_at']; ?></td>
            <td><?php echo $notif['is_read'] ? 'Read' : 'Unread'; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>No notifications yet.</p>
    <?php endif; ?>
    <br>
    <div>
        <button><a href="issue_submit.php">Report an Issue</a></button>
        <button><a href="login.php">Logout</a></button>
    </div>
<?php endif; ?>

<?php if($role == 'instructor' || $role == 'admin'): ?>
    <div>
        <button><a href="session_list.php">Manage Sessions</a></button>
        <button><a href="issue_submit.php">Report an Issue</a></button>
        <?php if($role == 'admin'): ?>
            <button><a href="admin_list.php">Manage Users</a></button>
            <button><a href="notification_send.php">Send Notification</a></button>
        <?php endif; ?>
        <button><a href="login.php">Logout</a></button>
    </div>
<?php endif; ?>

<?php if($role == 'it_support'): ?>
    <div>
        <button><a href="issue_list.php">View & Manage Issues</a></button>
        <button><a href="issue_submit.php">Report New Issue</a></button>
        <button><a href="login.php">Logout</a></button>
    </div>
<?php endif; ?>

</body>
</html>