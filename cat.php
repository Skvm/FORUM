<?php
include 'connect.php';
include 'header.php';

$sql = "SELECT
		id,
		name,
		descr
		FROM
		categories
		WHERE
		id = " . mysql_real_escape_string($_GET['id']);

$result = mysql_query($sql);

if(!$result)
{
	echo 'Something went wrong.';
	//mysql_error();
}
else
{
	if(mysql_num_rows($result) == 0)
	{
		echo 'This category doesn\'t exist.';
	}
	else
	{
		while($row = mysql_fetch_assoc($result))
		{
			echo '<a class="item" href="newtopic.php">Create new topic</a><br />';
			echo 'All topics in ' .$row['name'].':';
		}

		$wid = mysql_real_escape_string($_GET['id']);
		$sql = "SELECT
				id,
				sticky,
				subject,
				date,
				cat
				FROM
				topics
				WHERE
				cat = $wid
				ORDER BY
				(sticky=1) DESC,
				date DESC";
		$result = mysql_query($sql);

		if(!$result)
		{
			echo 'Something went wrong.';
			//mysql_error();
		}
		else
		{
			if(mysql_num_rows($result) == 0)
			{
				echo 'No topics.';
			}

			else
			{
				echo '<div id="head">';
				echo '<div id="left">Topic</div>';
				echo '<div id="right">Created at</div>';
				echo '</div>';

				while($row = mysql_fetch_assoc($result))
				{
					if($row['sticky'] == 1)
					{
						echo '<div id="topics">';
						echo '<b><a href="topic.php?id=' . $row['id'] . '">' . $row['subject'] . '</a> [STICKY]</b>';
						echo '<div id="right">';
						echo date('d-m-Y', strtotime($row['date']));
						echo '</div>';
						echo '</div>';
					}
					else
					{
						echo '<div id="topics">';
						echo '<b><a href="topic.php?id=' . $row['id'] . '">' . $row['subject'] . '</a></b>';
						echo '<div id="right">';
						echo date('d-m-Y', strtotime($row['date']));
						echo '</div>';
						echo '</div>';
					}
				}
			}
		}
	}
}

include 'footer.php';
?>