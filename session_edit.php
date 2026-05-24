<?php
session_start();
include 'connect.php';
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'instructor' && $_SESSION['role'] != 'admin')) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}
$id = $_GET['id'];
if(isset($_POST['btnUpdate'])) {
    $course = $_POST['course_code'];
    $title = $_POST['session_title'];
    $zoom = $_POST['zoom_meeting_id'];
    $mode = $_POST['session_mode'];
    $scheduled = $_POST['scheduled_at'];
    $status = $_POST['status'];
    $sql = "UPDATE tblsession SET course_code='$course', session_title='$title', zoom_meeting_id='$zoom', 
            session_mode='$mode', scheduled_at='$scheduled', status='$status' WHERE session_id=$id";
    mysqli_query($connection, $sql);
    echo "<script>alert('Updated'); window.location='session_list.php';</script>";
}
$res = mysqli_query($connection, "SELECT * FROM tblsession WHERE session_id=$id");
$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html>
<head><title>Edit Session</title></head>
<body>
<div style='background-color:#ffff00'><center><h2>Edit Session</h2></center></div>
<form method="post">
    <pre>
    Course Code:      <input type="text" name="course_code" value="<?= $row['course_code'] ?>">
    Session Title:    <input type="text" name="session_title" value="<?= $row['session_title'] ?>">
    Zoom Meeting ID:  <input type="text" name="zoom_meeting_id" value="<?= $row['zoom_meeting_id'] ?>">
    Mode: <select name="session_mode">
            <option <?= $row['session_mode']=='ONLINE'?'selected':'' ?>>ONLINE</option>
            <option <?= $row['session_mode']=='HYBRID'?'selected':'' ?>>HYBRID</option>
            <option <?= $row['session_mode']=='FACE_TO_FACE'?'selected':'' ?>>FACE_TO_FACE</option>
          </select>
    Scheduled: <input type="datetime-local" name="scheduled_at" value="<?= date('Y-m-d\TH:i', strtotime($row['scheduled_at'])) ?>">
    Status: <select name="status">
            <option <?= $row['status']=='SCHEDULED'?'selected':'' ?>>SCHEDULED</option>
            <option <?= $row['status']=='LIVE'?'selected':'' ?>>LIVE</option>
            <option <?= $row['status']=='ENDED'?'selected':'' ?>>ENDED</option>
            <option <?= $row['status']=='CANCELLED'?'selected':'' ?>>CANCELLED</option>
          </select>
    <input type="submit" name="btnUpdate" value="Update">
    <a href="session_list.php">Cancel</a>
    </pre>
</form>
</body>
</html>