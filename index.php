<?php
include 'connect.php';
include 'header.php';

//Read category information from database
$sql = "SELECT
			categories.id,
			categories.name,
			categories.descr,
			COUNT(topics.id) AS topics
		FROM
			categories
		LEFT JOIN
			topics
		ON
			topics.id = categories.id
		GROUP BY
			categories.name, categories.descr, categories.id
		ORDER BY
		categories.id ASC";

$result = mysql_query($sql);

if(!$result)
{	
	echo 'The categories could not be displayed. Please contact an administrator.';
	//mysql_error();
}
else{

	if(mysql_num_rows($result) == 0)
	{
		echo 'No categories have been added yet.';
	}

	else
	{
		echo '<div id="head">Categories</div>';

		while($row = mysql_fetch_assoc($result))
		{
			echo '<div id="topics">';
			echo '<h2><a href="cat.php?id=' . $row['id'] .'">' .$row['name'] .'</a></h2>' . $row['descr'];
			echo '<div id="right">';

			$topics = "SELECT
							id,
							subject,
							date,
							cat
						FROM
							topics
						WHERE
							cat = " . $row['id'] . "
						ORDER BY
						date 
						DESC
						LIMIT 1";
			$topicresult = mysql_query($topics);

			if(!$topicresult)
			{
				echo 'Last topic could not be displayed.';
			}
			else
			{
				while ($trow = mysql_fetch_assoc($topicresult))
				{
					echo 'Last topic: <a href="topic.php?id=' . $trow['id'] .'">' . $trow['subject'] .'</a> at ' . date('d-m-Y', strtotime($trow['date']));
				}
			}
		}

		echo '</div>';
		echo '</div>';
	}
}

include 'footer.php';
?>