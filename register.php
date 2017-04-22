<?php
include 'connect.php';
include 'header.php';

echo '<h2>Register</h2> <br />';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	echo '<form method="post" action="">';
	echo 'Username: <input type="text" name="name" /><br />';
	echo 'Password: <input type="password" name="password" /><br />';
	echo 'Password Again: <input type="password" name="pw_check" /><br />';
	echo 'Email: <input type="email" name="email" /><br />';
	echo '<input type="submit" value="Register" />';
	echo '</form>';
}
else
{
	$errors = array();

	if(isset($_POST['name']))
	{
		if(!ctype_alnum($_POST['name']))
		{
			$errors[] = 'The username can only contain letters and numbers.';
		}
		if(strlen($_POST['name']) > 20)
		{
			$errors[] = 'The username cannot be longer than 20 characters.';
		}
	}
	else
	{
		$errors[] = 'You must enter a username!';
	}

	if(isset($_POST['password']))
	{
		if($_POST['password'] != $_POST['pw_check'])
		{
			$errors = 'The two passwords did not match.';
		}
	}
	else
	{
		$errors[] = 'You must enter a password.';
	}

	$ipcheck = mysql_query("SELECT * FROM banned WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "'");

	if(mysql_num_rows($ipcheck) == 1)
	{
		$errors[] = 'You are banned.';
	}

	$ip2 = mysql_query("SELECT * FROM users WHERE ip = '" . $_SERVER['REMOTE_ADDR'] ."'");

	if(mysql_num_rows($ip2) == 1)
	{
		$errors[] = 'You already have an account.';
	}

	if(!empty($errors))
	{
		echo 'Something went wrong.. <br />';
		echo '<ul>';
		foreach($errors as $key => $value)
		{
			echo '<li>' . $value . '</li>';
		}
		echo '</ul>';
	}
	else
	{
		$sql = "INSERT INTO
				users(
				name,
				pw,
				email,
				ip,
				joindate,
				level)
				VALUES
				('" . mysql_real_escape_string($_POST['name']) ."',
				 '" . sha1($_POST['password']) . "',
				 '" . mysql_real_escape_string($_POST['email']) . "',
				 '" . mysql_real_escape_string($_SERVER['REMOTE_ADDR']) . "',
				 NOW(),
				 0)";
		$result = mysql_query($sql);
		if (!$result)
		{
			echo 'Something went wrong.';
		}
		else
		{
			'Your account has been created. <a href="signin.php">Sign in</a>?';
		}
	}
}

include 'footer.php';
?>