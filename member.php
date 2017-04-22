<?php 
//HUGE props to Vysmo for this entire page. I completely choked on member.php. Signature editing and user reputation is all him.
include 'connect.php';
include 'header.php';

//$query = 'SELECT * FROM users WHERE name = "skam"';
$query = 'SELECT * 
		FROM users
		WHERE id= '.$_GET["id"].'';
$result = mysql_query($query);


while($row = mysql_fetch_array($result))
{

if($row['level'] == 1){
echo '<div id="cbox">';
echo '<div id="usrbox">';

echo '<img src="./avatars/'.$row['id'].'.jpg"></img><br />';

echo '<b><font style="color: '. $row['color'] .'">  '. $row['name'] .'</font></b> ';
echo '<br />Admin';

echo '</div>';

echo '<div id="fpcontent">';

$query2 = 'SELECT COUNT(authir) AS total FROM posts WHERE author = '.$_GET["id"].''; 
$result2 = mysql_query($query2); 
$values = mysql_fetch_assoc($result2); 
$num_rows = $values['total']; 
echo 'Total Posts: '.$num_rows.'<br />';
echo 'Join Date: '.$row["joindate"].'';
echo "<br /><br />";
echo "Signature: <br />";
echo $row['signature'];
echo "<br /><br />";


//edit signature start
if(isset($_SESSION['id'])  && isset($_GET['id'])){
	   if($_SESSION['id'] === $_GET['id']){
	   if($_SERVER["REQUEST_METHOD"] != "POST")
		{
      echo "Change Signature: <br />";
		  echo "<form method='post' action=''>\n";
		  echo "<textarea rows='4' cols='50' name='signature'></textarea>\n";
		  echo "<input type='submit' value='Submit'>\n";
		  echo "</form>\n";
		}
else
{
  $errors = array();

  if(!isset($_POST["signature"]))
  {
    $errors[] = "Please fill in the fucking field.";
  }

  if(!empty($errors))
  {
    foreach($errors as $key => $value)
    {
      echo "The following error occurred: " . $value . ".";
    }
  }
  else
  {
    $signature = mysql_real_escape_string(htmlentities($_POST["signature"]));
    $id = $_SESSION["id"];
    $query = mysql_query("UPDATE users SET signature = '$signature' WHERE id = '$id'");

    if($query)
    {
      echo "Signature updated successfully!";
    }
    else
    {
      echo "Error updating query.";
    }
  }
}
	   }
	   else{

	   }

}
else{

}

//end edit signature
$id = $_GET["id"];

$query = mysql_query("SELECT name, user_reputation, reputation_limit FROM users WHERE id = '$id'");

while($row = mysql_fetch_assoc($query))
{
  $u = $row["name"];
  $r = $row["user_reputation"];
  $l = $row["reputation_limit"];

  echo "User " . $u . " has a total reputation of " . $r . " and can receive a maximum of " . $l . " additional reputation today.\n<br>\n<br>\n";

  function increaseReputation()
  {
    global $id;

    $increase_reputation = mysql_query("UPDATE users SET user_reputation = user_reputation + 1 WHERE id = '$id'");
    $decrease_limit = mysql_query("UPDATE users SET reputation_limit = reputation_limit - 1 WHERE id = '$id'");

    if(!$increase_reputation || !$decrease_limit)
    {
      echo "Failed to update reputation. Please try again later.";
    }
  }

  function decreaseReputation()
  {
    global $id;

    $decrease_reputation = mysql_query("UPDATE users SET user_reputation = user_reputation - 1 WHERE id = '$id'");
    $decrease_limit = mysql_query("UPDATE users SET reputation_limit = reputation_limit - 1 WHERE id = '$id'");

    if(!$decrease_reputation || !$decrease_limit)
    {
      echo "Failed to update reputation. Please try again later.";
    }
  }

  if((isset($_GET["increase"])) && ($l >= 1))
  {
    increaseReputation();
  }
  else if((isset($_GET["decrease"])) && ($l >= 1))
  {
    decreaseReputation();
  }
  else if((isset($_GET["increase"]) || isset($_GET["decrease"])) && ($l <= 0))
  {
    echo "<script>alert('This user cannot receive any more reputation changes today!')</script>";
  }
}

echo "<a href='", $_SERVER["REQUEST_URI"], "&increase=true'>Add Reputation</a>\n<br>\n";
echo "<a href='", $_SERVER["REQUEST_URI"], "&decrease=true'>Remove Reputation</a>\n<br>\n";
echo '</div>';
echo '</div>';
}

else{
echo '<div id="cbox">';
echo '<div id="usrbox">';
echo '<img src="./avatars/'.$row['id'].'.jpg"></img><br />';
echo '<font style="color: '. $row['color'] .'">  '. $row['name'] .'</font>';
echo '</div>';
echo '<div id="fpcontent">';

$query3 = 'SELECT COUNT(author) AS total FROM posts WHERE author = '.$_GET["id"].''; 
$result3 = mysql_query($query3);
$values2 = mysql_fetch_assoc($result3); 
$num_rows = $values2['total']; 
echo 'Total Posts: '.$num_rows.'<br />';
echo 'Join Date: '.$row["joindate"].'';



echo "<br /><br />";
echo "Signature: <br />";
echo $row['signature'];
echo "<br /><br />";

//edit signature start
if(isset($_SESSION['id'])  && isset($_GET['id'])){
	   if($_SESSION['id'] === $_GET['id']){
	   if($_SERVER["REQUEST_METHOD"] != "POST")
		{
      echo "Change Signature: <br />";
		  echo "<form method='post' action=''>\n";
		  echo "<textarea rows='4' cols='50' name='signature'></textarea>\n";
		  echo "<input type='submit' value='Submit'>\n";
		  echo "</form>\n";
		}
else
{
  $errors = array();

  if(!isset($_POST["signature"]))
  {
    $errors[] = "Please fill in the fucking field.";
  }

  if(!empty($errors))
  {
    foreach($errors as $key => $value)
    {
      echo "The following error occurred: " . $value . ".";
    }
  }
  else
  {
    $signature = mysql_real_escape_string(htmlentities($_POST["signature"]));
    $id = $_SESSION["id"];
    $query = mysql_query("UPDATE users SET signature = '$signature' WHERE id = '$id'");

    if($query)
    {
      echo "Signature updated successfully!";
    }
    else
    {
      echo "Error updating query.";
    }
  }
}
	   }
	   else{

	   }

}
else{

}
$id = $_GET["id"];

$query = mysql_query("SELECT name, user_reputation, reputation_limit FROM users WHERE id = '$id'");

while($row = mysql_fetch_assoc($query))
{
  $u = $row["name"];
  $r = $row["user_reputation"];
  $l = $row["reputation_limit"];

  echo "User " . $u . " has a total reputation of " . $r . " and can receive a maximum of " . $l . " additional reputation today.\n<br>\n<br>\n";

  function increaseReputation()
  {
    global $id;

    $increase_reputation = mysql_query("UPDATE users SET user_reputation = user_reputation + 1 WHERE id = '$id'");
    $decrease_limit = mysql_query("UPDATE users SET reputation_limit = reputation_limit - 1 WHERE id = '$id'");

    if(!$increase_reputation || !$decrease_limit)
    {
      echo "Failed to update reputation. Please try again later.";
    }
  }

  function decreaseReputation()
  {
    global $id;

    $decrease_reputation = mysql_query("UPDATE users SET user_reputation = user_reputation - 1 WHERE id = '$id'");
    $decrease_limit = mysql_query("UPDATE users SET reputation_limit = reputation_limit - 1 WHERE id = '$id'");

    if(!$decrease_reputation || !$decrease_limit)
    {
      echo "Failed to update reputation. Please try again later.";
    }
  }

  if((isset($_GET["increase"])) && ($l >= 1))
  {
    increaseReputation();
  }
  else if((isset($_GET["decrease"])) && ($l >= 1))
  {
    decreaseReputation();
  }
  else if((isset($_GET["increase"]) || isset($_GET["decrease"])) && ($l <= 0))
  {
    echo "<script>alert('This user cannot receive any more reputation changes today!')</script>";
  }
}

echo "<a href='", $_SERVER["REQUEST_URI"], "&increase=true'>Add Reputation</a>\n<br>\n";
echo "<a href='", $_SERVER["REQUEST_URI"], "&decrease=true'>Remove Reputation</a>\n<br>\n";

echo '</div>';
echo '</div>';
}
include "footer.php";
}
?>