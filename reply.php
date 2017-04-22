<?php
include 'connect.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	echo 'ERROR';
}
else
{
	if(!$_SESSION['signed_in'])
	{
		echo 'You must be signed in to reply.';
	}
	else
	{
		$sql = "INSERT INTO
				posts
				(content,
				date,
				topic,
				author)
				VALUES
				('" . nl2br(htmlspecialchars($_POST['content'])) ."',
				NOW(),
				" . mysql_real_escape_string($_GET['id']) . ",
				" . $_SESSION['id'] . ")";
		
		$result = mysql_query($sql);

		if(!$result)
		{
			echo 'Something went wrong. Please try again later.';
		}
		else
		{
			echo 'Post successful! Link: <a href="topic.php?id=' . htmlentities($_GET['id']) . '">here</a>.';
		}

	}
}

include 'footer.php';
?>