<?php 
include("auth.php"); //include auth.php file on all secure pages 
require("db.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Friends List</title>
<link rel='stylesheet' href='css/style.css'/>
</head>
<body>
<div class="form">
  <p><a href="dashboard.php">Home</a> | <a href="logout.php">Logout</a></p><br /><br />
</div>

<?php
  $username=$_GET['u'];
  $query = "select username1 u from relationship where username2='$username' union (select username2 u from relationship where username1='$username')";
  $getfriendlist = mysql_query($query) or die(mysql_error());
  
    while ( $row = mysql_fetch_assoc($getfriendlist)){
      $friend = $row['u'];
      echo "<li><a href='profile.php?u=$friend'>$friend</a></li>";
     }
?>

</body>
</html>    

