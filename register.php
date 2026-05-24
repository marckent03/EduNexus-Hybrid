<?php    
include 'connect.php';    
?>

<div style='background-color:#ffff00'>
    <center>
        <p style="color:white"><h2>Student Registration Page</h2></p>
    </center>
</div>  

<div>
    <form method="post">
        <pre>
            Email:      <input type="email" name="txtemail" required>
            Password:   <input type="password" name="txtpassword" required>
            Firstname:  <input type="text" name="txtfirstname" required>
            Lastname:   <input type="text" name="txtlastname" required>         
            Program:
            <select name="txtprogram" required>
                <option value="">----</option>
                <option value="BSCS">BSCS</option>
                <option value="BSIT">BSIT</option>
                <option value="BSIS">BSIS</option>
            </select>
            
            Year Level:
            <select name="txtyearlevel" required>
                <option value="">----</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            
            <input type="submit" name="btnRegister" value="Register"> 
        </pre>
    </form>
    
    <br>
    <center>
        <button><a href="login.php">Back to Login</a></button>
    </center>
</div>

<?php    
if(isset($_POST['btnRegister'])){        
    $email = $_POST['txtemail'];
    $password = $_POST['txtpassword'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $firstname = $_POST['txtfirstname'];        
    $lastname = $_POST['txtlastname'];
    $program = $_POST['txtprogram'];
    $yearlevel = $_POST['txtyearlevel'];
    
    $check_sql = "SELECT * FROM tbluser WHERE email='".$email."'";
    $check_result = mysqli_query($connection, $check_sql);
    $check_count = mysqli_num_rows($check_result);
    
    if($check_count > 0){
        echo "<script language='javascript'>
                alert('Email already registered. Please use another email.');
              </script>";
    } else {
        $sql1 = "INSERT INTO tbluser(email, password, first_name, last_name, role) 
             VALUES('".$email."','".$hashed_password."','".$firstname."','".$lastname."','student')";
        mysqli_query($connection, $sql1);
        
        $user_id = mysqli_insert_id($connection);
        
        $sql2 = "INSERT INTO tblstudent(user_id, student_number, year_level, program) 
             VALUES(".$user_id.", 'STU".$user_id."', ".$yearlevel.", '".$program."')";
        mysqli_query($connection, $sql2);
        
        echo "<script language='javascript'>
                alert('New student record saved. You can now login.');
                window.location='login.php';
              </script>";
    }
}
?>

 