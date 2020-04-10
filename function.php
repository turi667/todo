<?php

function get_total_all_records()
{
include_once 'resource/session.php';
	include ('resource/Database.php'); // Selecting tasks from Database of Current logged in user with corresponding Session Id 

	$statement = $db->prepare("select * from task WHERE user_id= '".$_SESSION['id']."'");
	$statement->execute();
	$result = $statement->fetchAll();
	return $statement->rowCount();
}

?>
