<?php 
session_start();

$server	    = 'localhost';
$username	= 'root';
$password	= '';
$database	= '';

if(!mysql_connect($server, $username, $password))
{
 	exit('Error: could not establish db connection');
}
if(!mysql_select_db($database))
{
 	exit('Error: could not select the db');
}
?>