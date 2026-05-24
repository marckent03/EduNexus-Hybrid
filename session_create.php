<?php
session_start();
include 'connect.php';
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'instructor' && $_SESSION['role'] != 'admin')) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

if(isset($_POST['btnCreate'])) {
    $course = $_POST['course_code'];
    $title = $_POST['session_title'];
    $zoom = $_POST['zoom_meeting_id'];
    $mode = $_POST['session_mode'];
    $scheduled = $_POST['scheduled_at'];
    $status = 'SCHEDULED';
    
    $sql = "INSERT INTO tblsession (course_code, session_title, zoom_meeting_id, session_mode, scheduled_at, status)
            VALUES ('$course', '$title', '$zoom', '$mode', '$scheduled', '$status')";
    mysqli_query($connection, $sql);
    echo "<script>alert('Session created'); window.location='session_list.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Create Session</title></head>
<body>
<div style='background-color:#ffff00'><center><h2>Create New Session</h2></center></div>
<form method="post">
    <pre>
    Course Code:      <input type="text" name="course_code" required>
    Session Title:    <input type="text" name="session_title" required>
    Zoom Meeting ID:  <input type="text" name="zoom_meeting_id">
    Mode: 
        <select name="session_mode">
            <option value="ONLINE">ONLINE</option>
            <option value="HYBRID">HYBRID</option>
            <option value="FACE_TO_FACE">FACE_TO_FACE</option>
        </select>
    Scheduled Date/Time: <input type="datetime-local" name="scheduled_at" required>
    
    <input type="submit" name="btnCreate" value="Create Session">
    <a href="session_list.php">Cancel</a>
    </pre>
</form>
</body>
</html>