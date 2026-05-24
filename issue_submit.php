<?php
session_start();
include 'connect.php';
if(!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

if(isset($_POST['btnSubmit'])) {
    $category = $_POST['category'];
    $desc = $_POST['description'];
    $session_id = $_POST['session_id'] ? $_POST['session_id'] : 'NULL';
    $reported_by = $_SESSION['user_id'];
    $sql = "INSERT INTO tbltechnical_issue (category, description, status, priority, reported_by, session_id)
            VALUES ('$category', '$desc', 'OPEN', 'MEDIUM', $reported_by, $session_id)";
    mysqli_query($connection, $sql);
    echo "<script>alert('Issue reported'); window.location='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head><title>Report Issue</title></head>
<body>
<div style='background-color:#ffff00'><center><h2>Report Technical Issue</h2></center></div>
<form method="post">
    <pre>
    Category:
        <select name="category">
            <option>AUDIO</option><option>VIDEO</option><option>CONNECTIVITY</option>
            <option>LOGIN</option><option>RECORDING</option>
        </select>
    Description: <textarea name="description" rows="4" cols="40"></textarea>
    Session ID (optional): <input type="number" name="session_id">
    
    <input type="submit" name="btnSubmit" value="Submit Issue">
    <a href="dashboard.php">Cancel</a>
    </pre>
</form>
</body>
</html>