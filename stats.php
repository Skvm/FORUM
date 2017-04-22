<?php
include 'connect.php';
include 'header.php';

$q = 'SELECT COUNT(author) AS total FROM posts';
$r = mysql_query($q);
$v = mysql_fetch_assoc($r);
$num = $v['total'];

$cats = 'SELECT COUNT(id) AS totalcats FROM categories';
$catr = mysql_query($cats);
$catv = mysql_fetch_assoc($catr);
$catrows = $catv['totalcats'];

$users = 'SELECT COUNT(id) AS totaluser FROM users';
$userr = mysql_query($users);
$userval = mysql_fetch_assoc($userr);
$userrows = $userval['totaluser'];

echo '<div id="stats">';
echo '<table style="margin:0 auto; width:100%; ">';
echo '<caption>Stats</caption>';
echo '<tr>';
echo '<th>';
echo 'Total Posts:';
echo '</th>';
echo '<td>';
echo ' '.$num.'';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Total Categories:';
echo '</th>';
echo '<td>';
echo ' '.$catrows.'';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<th>';
echo 'Total Users:';
echo '</th>';
echo '<td>';
echo ' '.$userrows.'';
echo '</td>';
echo '</tr>';


echo '</table>';

echo '</div>';

include "footer.php";
?>