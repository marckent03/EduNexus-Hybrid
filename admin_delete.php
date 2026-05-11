<?php
include 'connect.php';
$user_id = $_GET['id'];

mysqli_query($connection, "DELETE FROM tbladmin WHERE user_id=$user_id");
mysqli_query($connection, "DELETE FROM tbluser WHERE user_id=$user_id");

header("Location: admin_list.php");
?>