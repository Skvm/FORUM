<?php
include 'connect.php';
include 'header.php';

echo '<h2>Sign In</h2> <br />';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	echo 'You are already signed in.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		echo '<form method="post" action="">';
		echo 'Username: <input type="text" name="name" /><br />';
		echo 'Password: <input type="password" name="password" /><br />';
		echo '<input type="submit" value="Login" />';
		echo '</form>';
	}
	else
	{
		$errors = array();

		if(!isset($_POST['name']))
		{
			$errors[] = 'You must enter your username.';
		}

		if(!isset($_POST['password']))
		{
			$errors[] = "You must enter your password.";
		}

		if(!empty($errors))
		{
			echo 'Something went wrong.';
			echo '<ul>';
			foreach($errors as $key => $value)
			{
				echo '<li>' . $value . '</li>';
			}
			echo '</ul>';
		}
		else
		{
			$sql = "SELECT
						id,
						name,
						level
					FROM
						users
					WHERE
						name = '" . mysql_real_escape_string($_POST['name']) . "'
					AND
						pw = '" . sha1($_POST['password']) . "'";

			$result = mysql_query($sql);
			if(!$result)
			{
				echo 'Something went wrong. Please try again later.';
			}
			else
			{
				if(mysql_num_rows($result) == 0)
				{
					echo 'Wrong username/password.';
				}
				else
				{
					$_SESSION['signed_in'] = true;

					while($row = mysql_fetch_assoc($result))
					{
						$_SESSION['id'] = $row['id'];
						$_SESSION['name'] = $row['name'];
						$_SESSION['level'] = $row['level'];
					}

					echo 'Welcome, ' . $_SESSION['name'] . '. <br /><a href="index.php>Home</a><br />.';
				}
			}
		}
	}
}

include 'footer.php';
?>