<?php
include 'connect.php';
require_once 'includes/header.php';

$user_id = $_GET['id'];

$sql = "SELECT u.*, a.admin_number, a.clearance_level, a.office 
        FROM tbluser u JOIN tbladmin a ON u.user_id = a.user_id 
        WHERE u.user_id = $user_id";
$result = mysqli_query($connection, $sql);
$admin = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $admin_number = $_POST['admin_number'];
    $clearance_level = $_POST['clearance_level'];
    $office = $_POST['office'];

    $update_user = "UPDATE tbluser SET first_name='$first_name', last_name='$last_name' WHERE user_id=$user_id";
    $update_admin = "UPDATE tbladmin SET admin_number='$admin_number', clearance_level=$clearance_level, office='$office' WHERE user_id=$user_id";

    mysqli_query($connection, $update_user);
    mysqli_query($connection, $update_admin);
    echo "<script>alert('Updated'); window.location='admin_list.php';</script>";
}
?>

<form method="post">
    First Name: <input type="text" name="first_name" value="<?= $admin['first_name'] ?>" required><br>
    Last Name: <input type="text" name="last_name" value="<?= $admin['last_name'] ?>" required><br>
    Admin Number: <input type="text" name="admin_number" value="<?= $admin['admin_number'] ?>" required><br>
    Clearance Level: <input type="number" name="clearance_level" value="<?= $admin['clearance_level'] ?>"><br>
    Office: <input type="text" name="office" value="<?= $admin['office'] ?>"><br>
    <input type="submit" value="Update">
</form>

<?php require_once 'includes/footer.php'; ?>