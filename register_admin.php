<?php    
include 'connect.php';    
?>

<div style='background-color:#ff6600'>
    <center>
        <p style="color:white"><h2>Admin Registration (One-Time Setup)</h2></p>
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
            Clearance Level:<input type="number" name="txtclearance" value="5">
            Office:         <input type="text" name="txtoffice">
            
            <input type="submit" name="btnRegister" value="Create Admin Account"> 
        </pre>
    </form>
    
    <button><a href="login.php">Back to Login</a></button>
</div>

<?php    
if(isset($_POST['btnRegister'])){        
    $email = $_POST['txtemail'];
    $password = $_POST['txtpassword'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $firstname = $_POST['txtfirstname'];        
    $lastname = $_POST['txtlastname'];
    $admin_number = $_POST['txtadminnumber'];
    $clearance = $_POST['txtclearance'];
    $office = $_POST['txtoffice'];
    
    $sql1 = "INSERT INTO tbluser(email, password, first_name, last_name, role) 
             VALUES('".$email."','".$hashed_password."','".$firstname."','".$lastname."','admin')";
    mysqli_query($connection, $sql1);
    
    $user_id = mysqli_insert_id($connection);
    
    $sql2 = "INSERT INTO tbladmin(user_id, admin_number, clearance_level, office) 
             VALUES(".$user_id.", '".$admin_number."', ".$clearance.", '".$office."')";
    mysqli_query($connection, $sql2);
    
    echo "<script language='javascript'>
            alert('Admin account created. You can now login.');
            window.location='login.php';
          </script>";
}
?>

 