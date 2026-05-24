<?php    
session_start();
include 'connect.php'; 

if(isset($_POST['btnUserLogin'])){
    $email = $_POST['txtemail'];
    $pwd = $_POST['txtpassword'];
    
    $sql = "SELECT * FROM tbluser WHERE email='".$email."' AND (role='student' OR role='instructor')";
    $result = mysqli_query($connection, $sql);    
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    
    if($count == 0){
        echo "<script>alert('Student email not found.');</script>";
    }else if(!password_verify($pwd, $row['password'])){
        echo "<script>alert('Incorrect password');</script>";
    }else {        
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['first_name'] . ' ' . $row['last_name'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['email'] = $row['email'];
        echo "<script>window.location.href='dashboard.php';</script>";
        exit();
    }
}

if(isset($_POST['btnITLogin'])){
    $email = $_POST['txtitemail'];
    $pwd = $_POST['txtitpassword'];
    
    $sql = "SELECT * FROM tbluser WHERE email='".$email."' AND role='it_support'";
    $result = mysqli_query($connection, $sql);    
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    
    if($count == 0){
        echo "<script>alert('IT Support email not found.');</script>";
    }else if(!password_verify($pwd, $row['password'])){
        echo "<script>alert('Incorrect password');</script>";
    }else {        
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['first_name'] . ' ' . $row['last_name'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['email'] = $row['email'];
        echo "<script>window.location.href='dashboard.php';</script>";
        exit();
    }
}

if(isset($_POST['btnAdminLogin'])){
    $email = $_POST['txtadminemail'];
    $pwd = $_POST['txtadminpassword'];
    
    $sql = "SELECT * FROM tbluser WHERE email='".$email."' AND role='admin'";
    $result = mysqli_query($connection, $sql);    
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);
    
    if($count == 0){
        echo "<script>alert('Admin email not found.');</script>";
    }else if(!password_verify($pwd, $row['password'])){
        echo "<script>alert('Incorrect admin password');</script>";
    }else {        
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['first_name'] . ' ' . $row['last_name'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['email'] = $row['email'];
        echo "<script>window.location.href='dashboard.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>EduNexus Login</title>
</head>
<body>

<div style='background-color:#ffff00'>
    <center><h2>EduNexus Hybrid Learning Platform</h2></center>
</div>

<br>

<table border="0" width="80%" align="center" cellpadding="15">
    <tr bgcolor="#f2f2f2">
        <td align="center" width="33%">
            <h3>Student</h3>
            <form method="post">
                <pre>
Email:    <input type="email" name="txtemail" required>
Password: <input type="password" name="txtpassword" required>
<input type="submit" name="btnUserLogin" value="Login as User">
                </pre>
            </form>
            <a href="register.php">Register as Student</a>
        </td>

        <td align="center" width="33%" style="border-left:1px solid #ccc; border-right:1px solid #ccc;">
            <h3>IT Support Login</h3>
            <form method="post">
                <pre>
Email:    <input type="email" name="txtitemail" required>
Password: <input type="password" name="txtitpassword" required>
<input type="submit" name="btnITLogin" value="Login as IT Support">
                </pre>
            </form>
            <p><small>For technical support staff only</small></p>
         </td>

        <td align="center" width="33%">
            <h3>Administrator Login</h3>
            <form method="post">
                <pre>
Email:    <input type="email" name="txtadminemail" required>
Password: <input type="password" name="txtadminpassword" required>
<input type="submit" name="btnAdminLogin" value="Login as Admin">
                </pre>
            </form>
         </td>
    </tr>
</table>

</body>
</html>