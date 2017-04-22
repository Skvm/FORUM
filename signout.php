<?php
include 'connect.php';
include 'header.php';

echo '<h2>Sign Out</h2><br />';

if(isset($_SESSION['signed_in']))
{
	$_SESSION['signed_in'] = NULL;
	$_SESSION['name'] = NULL;
	$_SESSION['id'] = NULL;
	session_destroy();

	echo 'Signed out.';
}
else
{
	echo 'You are not signed in.';
}

include 'footer.php';
?>