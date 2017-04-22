<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title>FORUM</title>
	<link rel="stylesheet" type="text/css" href="instyle.css">
</head>

<body>

<div id="header">
<h1>FORUM</h1>
</div>

<div id="main">

<div id="nav">
	<ul>
		<li><a class="item" href="index.php">Home</a></li>
		<li><a class="item" href="stats.php">Stats</a></li>
		<li><a class="item" href="rules.php">Rules</a></li>

	<?php
	
	//Detect user ID
	$uid = (isset($_SESSION['id']));
	
	//Read user info from database
	$query = "SELECT
		users.color,
		users.id,
		users.name,
		users.level
	FROM
		users
	WHERE
	users.id = $uid";

	$result = mysql_query($query);

	//If user is an admin, allow them to create a new category
	if(isset($_SESSION['signed_in']) && ($_SESSION['level'] == 1 ))
	{
		echo '<li><a class="item" href="newcategory.php">New Category</a></li>';
	}
	else
	{

	}

	echo '</ul> <div id="infob">';


	if(isset($_SESSION['signed_in']))
	{
		while($variable = mysql_fetch_assoc($result));
		{
			//If the user is currently signed in, this will display their name (with their chosen color, if they have a color in the database) and will link directly to their user profile
			echo $variable['color'];
			echo $variable['name'];
			echo 'Hello, <a href="member.php?id='. ($_SESSION['id']) .'"><font style="color: '. $variable['color'] .';"><b> '. htmlentities($_SESSION['name']) .'</b></font></a>! Not you? <a class="item" href="signout.php">Sign out</a>.';
		}
	}
	else
	{
		echo '<a class="item" href="signin.php">Sign in</a> - <a class="item" href="register.php">Create Account</a>';
	}
	?>
	</div>

</div>
<div id="forum">	