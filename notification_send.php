<?php
session_start();
include 'connect.php';

if($_SESSION['role'] != 'admin') {
    echo "<script>alert('Access denied'); window.location='dashboard.php';</script>";
    exit;
}

$students = mysqli_query($connection, "SELECT user_id, first_name, last_name FROM tbluser WHERE role='student' ORDER BY last_name");

if(isset($_POST['btnSendToOne'])) {
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];
    $type = $_POST['type'];
    
    $sql = "INSERT INTO tblnotification (user_id, message, type, is_read, sent_at) 
            VALUES ($user_id, '$message', '$type', 0, NOW())";
    mysqli_query($connection, $sql);
    
    echo "<script>alert('Notification sent to selected student.'); window.location='dashboard.php';</script>";
}

if(isset($_POST['btnSendToAll'])) {
    $message = $_POST['message'];
    $type = $_POST['type'];
    
    $all_students = mysqli_query($connection, "SELECT user_id FROM tbluser WHERE role='student'");
    
    while($student = mysqli_fetch_assoc($all_students)) {
        $sql = "INSERT INTO tblnotification (user_id, message, type, is_read, sent_at) 
                VALUES ({$student['user_id']}, '$message', '$type', 0, NOW())";
        mysqli_query($connection, $sql);
    }
    
    echo "<script>alert('Notification sent to ALL students.'); window.location='dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Notification</title>
</head>
<body>

<div style='background-color:#ffff00'>
    <center>
        <h2>Send Notification to Students</h2>
    </center>
</div>

<br>

<form method="post">
    <table border="0" align="left" cellpadding="8">
        <tr>
            <td><strong>Notification Type:</strong></td>
            <td>
                <select name="type">
                    <option value="SESSION_REMINDER">Session Reminder</option>
                    <option value="ACTIVITY_LAUNCHED">Activity Launched</option>
                    <option value="RECORDING_READY">Recording Ready</option>
                    <option value="SESSION_CANCELLED">Session Cancelled</option>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top"><strong>Message:</strong></td>
            <td><textarea name="message" rows="4" cols="50" required></textarea></td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <hr>
                <strong>Choose recipient:</strong>
                <br><br>
                <input type="submit" name="btnSendToOne" value="Send to Selected Student">
                &nbsp;&nbsp;&nbsp;
                <input type="submit" name="btnSendToAll" value="Send to ALL Students">
                <br><br>
                <select name="user_id">
                    <option value="">-- Select a student (for single send) --</option>
                    <?php while($s = mysqli_fetch_assoc($students)): ?>
                        <option value="<?= $s['user_id'] ?>">
                            <?= $s['first_name'] . ' ' . $s['last_name'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left">
                <br>
                <a href="dashboard.php"><button type="button">Cancel</button></a>
            </td>
        </tr>
    </table>
</form>

</body>
</html>