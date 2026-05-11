<?php 
	$connection = new mysqli('localhost', 'root','','edunexus_db');
	
	if (!$connection){
		die (mysqli_error($mysqli));
	}
		
?>