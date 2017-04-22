<?php
include 'connect.php';
include 'header.php';

echo '<h2>New Category</h2>';
if($_SESSION['signed_in'] == false | $_SESSION['level'] != 1)
{
	echo 'You are not supposed to be here.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		echo '<form method="post" action="">';
		echo 'Name: <input type="text" name="name" /><br />';
		echo 'Description: <textarea type="text" name="description"></textarea><br />';
		echo '<input type="submit" value="Create" />';
		echo '</form>';
	}
	else
	{
		$sql = "INSERT INTO
				categories(
				name,
				descr)
				VALUES(
				'" . mysql_real_escape_string($_POST['name']) ."',
				'" . mysql_real_escape_string($_POST['descr']) ."')";
		$result = mysql_query($sql);

		if(!$result)
		{
			echo 'Something went wrong.';
			mysql_error();
		}
		else
		{
			echo 'Created new category.';
		}
	}
}

include 'footer.php';
?>