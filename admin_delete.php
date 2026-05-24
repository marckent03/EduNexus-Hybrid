<?php
include 'connect.php';

$user_id = $_GET['id'];

$sql1 = "DELETE FROM tbladmin WHERE user_id=".$user_id;
mysqli_query($connection, $sql1);

$sql2 = "DELETE FROM tbluser WHERE user_id=".$user_id;
mysqli_query($connection, $sql2);

echo "<script language='javascript'>
        alert('Admin record deleted.');
      </script>";
header("location: admin_list.php");
?>