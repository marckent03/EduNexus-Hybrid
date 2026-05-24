<?php
include 'connect.php';

if(isset($_POST['btnCreate'])){
    $email = $_POST['txtemail'];
    $password = $_POST['txtpassword'];
    $firstname = $_POST['txtfirstname'];
    $lastname = $_POST['txtlastname'];
    $admin_number = $_POST['txtadminnumber'];
    $clearance_level = $_POST['txtclearance'];
    $office = $_POST['txtoffice'];
    
    $check_email = "SELECT * FROM tbluser WHERE email='".$email."'";
    $result_email = mysqli_query($connection, $check_email);
    $count_email = mysqli_num_rows($result_email);
    
    $check_adminnum = "SELECT * FROM tbladmin WHERE admin_number='".$admin_number."'";
    $result_adminnum = mysqli_query($connection, $check_adminnum);
    $count_adminnum = mysqli_num_rows($result_adminnum);
    
    if($count_email > 0){
        echo "<script language='javascript'>
                alert('Email already exists. Please use a different email.');
              </script>";
    } else if($count_adminnum > 0){
        echo "<script language='javascript'>
                alert('Admin Number already exists. Please use a different Admin Number.');
              </script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql1 = "INSERT INTO tbluser(email, password, first_name, last_name, role) 
                 VALUES('".$email."','".$hashed_password."','".$firstname."','".$lastname."','admin')";
        mysqli_query($connection, $sql1);
        
        $user_id = mysqli_insert_id($connection);
        
        $sql2 = "INSERT INTO tbladmin(user_id, admin_number, clearance_level, office) 
                 VALUES(".$user_id.", '".$admin_number."', ".$clearance_level.", '".$office."')";
        mysqli_query($connection, $sql2);
        
        echo "<script language='javascript'>
                alert('New admin record saved.');
                window.location='admin_list.php';
              </script>";
    }
}
?>

<div style='background-color:#ffff00'>
    <center>
        <h2 style="color:white">Create New Admin</h2>
    </center>
</div>

<div>
    <form method="post">
        <pre>
            Email:          <input type="email" name="txtemail" required>
            Password:       <input type="password" name="txtpassword" required>
            Firstname:      <input type="text" name="txtfirstname" required>
            Lastname:       <input type="text" name="txtlastname" required>
            Admin Number:   <input type="text" name="txtadminnumber" required>
            Clearance Level:<input type="number" name="txtclearance" value="1">
            Office:         <input type="text" name="txtoffice">
            
            <input type="submit" name="btnCreate" value="Create Admin">
        </pre>
    </form>
    <button><a href="admin_list.php">Cancel</a></button>
</div>

 