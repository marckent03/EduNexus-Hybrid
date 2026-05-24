<?php
include 'connect.php';

$user_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT u.user_id, u.email, u.first_name, u.last_name, 
               a.admin_number, a.clearance_level, a.office 
        FROM tbluser u 
        JOIN tbladmin a ON u.user_id = a.user_id 
        WHERE u.user_id = " . $user_id;
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);

if(!$row){
    echo "<script language='javascript'>
            alert('Admin record not found.');
            window.location='admin_list.php';
          </script>";
    exit;
}

if(isset($_POST['btnUpdate'])){
    $firstname = $_POST['txtfirstname'];
    $lastname = $_POST['txtlastname'];
    $admin_number = $_POST['txtadminnumber'];
    $clearance_level = $_POST['txtclearance'];
    $office = $_POST['txtoffice'];
    
    $sql1 = "UPDATE tbluser SET first_name='".$firstname."', last_name='".$lastname."' WHERE user_id=".$user_id;
    mysqli_query($connection, $sql1);
    
    $sql2 = "UPDATE tbladmin SET admin_number='".$admin_number."', clearance_level=".$clearance_level.", office='".$office."' WHERE user_id=".$user_id;
    mysqli_query($connection, $sql2);
    
    echo "<script language='javascript'>
            alert('Admin record updated.');
            window.location='admin_list.php';
          </script>";
}
?>

<div style='background-color:#ffff00'>
    <center>
        <h2 style="color:white">Edit Admin</h2>
    </center>
</div>

<div>
    <form method="post">
        <pre>
            Email:        <input type="email" name="txtemail" value="<?php echo $row['email']; ?>" readonly disabled>
            First Name:   <input type="text" name="txtfirstname" value="<?php echo $row['first_name']; ?>" required>
            Last Name:    <input type="text" name="txtlastname" value="<?php echo $row['last_name']; ?>" required>
            Admin Number: <input type="text" name="txtadminnumber" value="<?php echo $row['admin_number']; ?>" required>
            Clearance:    <input type="number" name="txtclearance" value="<?php echo $row['clearance_level']; ?>">
            Office:       <input type="text" name="txtoffice" value="<?php echo $row['office']; ?>">
            
            <input type="submit" name="btnUpdate" value="Update Admin">
        </pre>
    </form>
    <button><a href="admin_list.php">Cancel</a></button>
</div>

 