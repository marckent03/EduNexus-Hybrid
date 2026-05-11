<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $admin_number = $_POST['admin_number'];
    $clearance_level = $_POST['clearance_level'];
    $office = $_POST['office'];

    $sql_user = "INSERT INTO tbluser (email, password, first_name, last_name, role) 
                 VALUES ('$email', '$password', '$first_name', '$last_name', 'admin')";
    if (mysqli_query($connection, $sql_user)) {
        $user_id = mysqli_insert_id($connection);
        $sql_admin = "INSERT INTO tbladmin (user_id, admin_number, clearance_level, office) 
                      VALUES ($user_id, '$admin_number', $clearance_level, '$office')";
        if (mysqli_query($connection, $sql_admin)) {
            echo "<script>alert('Admin created successfully'); window.location='admin_list.php';</script>";
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>

<form method="post">
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    First Name: <input type="text" name="first_name" required><br>
    Last Name: <input type="text" name="last_name" required><br>
    Admin Number: <input type="text" name="admin_number" required><br>
    Clearance Level: <input type="number" name="clearance_level" value="1"><br>
    Office: <input type="text" name="office"><br>
    <input type="submit" value="Create Admin">
</form>

<?php?>