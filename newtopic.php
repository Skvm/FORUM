<?php
include 'connect.php';
include 'header.php';

echo '<h2>New Topic</h2>';
if(!isset($_SESSION['signed_in']))
{
	echo 'You must be signed in to create a new topic.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		$sql = 'SELECT
				id,
				name,
				descr
				FROM
				categories';
		$result = mysql_query($sql);

		if(!$result)
		{
			echo 'Something went wrong.';
		}
		else
		{
			if(mysql_num_rows($result) == 0)
			{
					echo 'No categories have been created yet.';
			}
			else
			{
				echo '<form method="post" action="">';
				echo 'Subject: <input type="text name="subject" /><br />';
				echo 'Category: ';
				echo '<select name="tcat">';
					while($row = mysql_fetch_assoc($result))
					{
						echo '<option value="' .$row['id'] .'">' .$row['name'] .'</option>';
					}
				echo '</select><br />';

				echo 'Content: <br />';
				echo '<textarea name="content" /></textarea>';
				echo '<br /><br />';
				echo '<input type="submit" value="Post!" />';
				echo '</form>';
			}
		}
	}
	else
	{
		$query = "BEGIN WORK;";
		$result = mysql_query($query);

		if(!$result)
		{
			echo 'Something went wrong.';
			//echo mysql_error();
		}
		else
		{
			$sql = "INSERT INTO
					topics(
						subject,
						date,
						cat,
						author)
					VALUES
					('" . mysql_real_escape_string($_POST['subject']) . "',
					NOW(),
					" . mysql_real_escape_string($_POST['cat']) .",
					" . $_SESSION['id'] ."
					)";

			$result = mysql_query($sql);
			if(!$result)
			{
				echo 'Something went wrong.';
				echo mysql_error();
				$sql = "ROLLBACK;";
				$result = mysql_query($sql);
			}
			else
			{
				$topicid = mysql_insert_id();
				$sql = "INSERT INTO
						posts(content,
							date,
							topic,
							author)
						VALUES
						('" . mysql_real_escape_string($_POST['content']) . "',
							NOW(),
							" . $topicid . ",
							" . $_SESSION['id'] . "
						)";
				$result = mysql_query($sql);

				if(!$result)
				{
					echo 'Something went wrong.';
					echo mysql_error();
					$sql = "ROLLBACK;";
					$result = mysql_query($sql);
				}
				else
				{
					$sql = "COMMIT;";
					$result = mysql_query($sql);
					echo 'Post successful! <a href="topic.php?id='.$topicid.'">Link.</a>';
				}
			}
		}
	}
}

include 'footer.php';
?>