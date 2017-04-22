<?php
include 'connect.php';
include 'header.php';

$sql = 'SELECT
			topics.id AS topic_id,
			topics.cat,
			topics.subject,
			topics.locked,
			categories.name,
			categories.id AS cat_id
		FROM
			topics
		LEFT JOIN
			categories
		ON
			categories.id=topics.cat 
		WHERE 
			topics.id = ' . mysql_real_escape_string($_GET['id']);

$result = mysql_query($sql);

if(!$result)
{
	echo 'The topic could not be displayed.';
}
else
{
	if(mysql_num_rows($result) == 0)
	{
		echo 'This topic doesn\'t exist.';
	}
	else
	{
		while($row = mysql_fetch_assoc($result))
		{
			echo '<div id="head">';
			echo '<b>' . $row['subject'] .'</b>';
			echo '  <a href="cat.php?id=' .$row["cat_id"].'"> <span style="position:absolute; left:60px; font-size:15px; color:blue;"> <-- ' .$row["name"] .' </span></a> </div>';

			$posid = mysql_real_escape_string($_GET['id']);

			$psql = "SELECT
					posts.topic,
					posts.content,
					posts.date,
					posts.author,
					users.id,
					users.name,
					users.color,
					users.signature,
					users.level
					FROM
					posts
					LEFT JOIN
					users
					ON
					posts.author = users.id
					WHERE
					posts.topic = $posid
					ORDER BY
					posts.date ASC ";

			$postres = mysql_query($psql);
			if(!$postres)
			{
				echo 'Something went <b>really</b> wrong.';
			}
			else
			{

				while($posts_row = mysql_fetch_assoc($postres))
				{
					if($posts_row['level'] == 1)
					{
						echo '<div id="cbox">';
						echo '<div id="usrbox">';
						echo '<b> <a href="member.php?id='.$posts_row['id'].'">';
						echo '<font style="color: '.$posts_row['color'].'">';
						echo $posts_row['name'];
						echo '</font></a></b>';
						echo '[Admin] <br />';
						echo '<img src="./avatars/'.$posts_row['id'].'.jpg"></img>';
						echo '<br /> </div>';
						echo '<div id="fpcontent">';
						echo stripslashes($posts_row['content']);
						echo '<br /> </div>';
						echo '<div id="sig"> <hr />';
						echo '<p id="sigtext">';
						echo $posts_row['signature'];
						echo '</p>';
						echo '</div> </div><br /><hr class="styled" />';
					}
					else
					{
						echo '<div id="cbox">';
						echo '<div id="usrbox">';
						echo '<a href="member.php?id='.$posts_row['id'].'">';
						echo '<font style="color: '.$posts_row['color'].'">';
						echo $posts_row['name'];
						echo '</font></a>';
						echo '<br />';
						echo '<img src="./avatars/'.$posts_row['id'].'.jpg"></img>';
						echo '<br /> </div>';
						echo '<div id="fpcontent">';
						echo stripslashes($posts_row['content']);
						echo '<br /> </div>';
						echo '<div id="sig"> <hr />';
						echo '<p id="sigtext">';
						echo $posts_row['signature'];
						echo '</p>';
						echo '</div> </div><br /><hr class="styled" />';
					}
				}

			}

			if(!isset($_SESSION['signed_in']))
			{
				echo '<br /> You must be signed in to reply.';
			}
			else
			{
				if($row['locked'] == 0)
				{
					echo '<h2>Reply:</h2>';
					echo '<form method="post" action="reply.php?id=' . $row['topic_id'] .'">';
					echo '<textarea name="content" style="width:100%; height:100px;"></textarea><br /><br />';
					echo '<input type="submit" value="Reply" />';
					echo '</form>';
				}
				else
				{
					echo 'Topic locked. Replies are blocked.';
					echo '<br /> That rhymed. Cool. <br />';
				}


				if($_SESSION['level'] == 1)
				{
					echo 'ADMIN TOOLS: <br />';
					$tid = $_GET['id'];
					echo '<a href="delete_topic.php?id='.$tid.'">DELETE TOPIC</a><br />';
					echo '<form action="move_topic.php" method="get">';
					echo '<input type="hidden" name="id" value='.$tid.'">';
					echo 'Category to move topic to: <input type="text" name="newid">';
					echo '<input type="submit">';
					echo '</form>';
				}
				else
				{}
			}
		}
	}
}

include 'footer.php';
?>