<?php
include 'connect.php';
include 'header.php';

if(!isset($_SESSION['signed_in']))
{
	echo 'You must be signed in to delete a topic.';
}

elseif($_SESSION['level'] == 1)
{
	$id = $_GET['id'];
	$query = mysql_query("DELETE FROM topics WHERE topic_id = $id");

	if(!$query)
	{
		echo "Unable to delete topic.";
	}
	else
	{
		echo "Topic deleted successfully.";
	}
}

else
{
	echo "You are not supposed to be here.";
}
?>