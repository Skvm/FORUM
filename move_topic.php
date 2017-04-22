<?php
include 'connect.php';
include 'header.php';

if(!isset($_SESSION['signed_in']))
{
	echo 'You must be signed in to move a topic.';
}

elseif($_SESSION['level'] == 1)
{
	$id = $_GET['id'];
	$newid = $_GET['newid'];
	$query = mysql_query("UPDATE topics SET cat = $newid WHERE id = $id");

	if(!$query)
	{
		echo "Unable to move topic.";
	}
	else
	{
		echo "Topic moved successfully.";
	}
}

else
{
	echo "You are not supposed to be here.";
}
?>