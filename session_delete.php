<?php
session_start();
include 'connect.php';
$id = $_GET['id'];
mysqli_query($connection, "DELETE FROM tblsession WHERE session_id=$id");
echo "<script>alert('Deleted'); window.location='session_list.php';</script>";
?>