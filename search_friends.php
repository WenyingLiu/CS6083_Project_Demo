<?php 
include("auth.php"); //include auth.php file on all secure pages 
require("db.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Search Friends</title>
<link rel='stylesheet' href='css/style.css'/>
</head>
<body>
<div class="form">
  <p><a href="dashboard.php">Back</a> | <a href="logout.php">Logout</a></p>
</div>
<div class='newsFeed'>
  <h2>Search Results</h2>
  <form action='search_friends.php' method='GET' id='search_friends' style="margin: 0px; padding: 0px;">
    <input type='text' name='search_key' size='60' placeholder='Search Friends' />
  </form>
</div>

<?php
  $username=$_SESSION['username'];
  $search_key=$_GET['search_key'];
  $query = "select username, job_title from user_profile where username like '%$search_key%' or job_title like '%$search_key%'";
  $getfriends = mysql_query($query) or die(mysql_error());
  while ( $row = mysql_fetch_assoc($getfriends)){
    $username = $row['username'];
    $job_title = $row['job_title'];
?>    

<?php
  echo "
  <p />
  <div class='newsFeedPost'>
    <div class='newsFeedPostOptions'>
</div>
<li><a href='profile.php?u=$username'>$username</a> as $job_title</li>
  </div>
  ";
  }?>
</body>
</html>
