<?php 
include("auth.php"); //include auth.php file on all secure pages 
require("db.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Search Posts</title>
<link rel='stylesheet' href='css/style.css'/>
</head>
<body>
<div class="form">
  <p><a href="dashboard.php">Back</a> | <a href="logout.php">Logout</a></p>
</div>
<div class='newsFeed'>
  <h2>Search Results</h2>
  <form action='search_posts.php' method='GET' id='search_posts' style="margin: 0px; padding: 0px;">
    <input type='text' name='search_posts_key' size='60' placeholder='Search Posts' />
  </form>
</div>

<?php
  $username=$_SESSION['username'];
  $search_key=$_GET['search_posts_key'];
  $query = "select post_id, username, title, body, image, location_id, post_timestamp 
	  from posts where title like '%$search_key%' or body like '%$search_key%' and (visible=0 
	  or (visible=1 and username in (select g.* from (select @susername:='$username' p) parm , get_friends g))
	  Or (visible=2 and username in (select username2 username from RELATIONSHIP
	  where username1 in 
	  (select g.* from (select @username:='$username' p) parm , get_friends g)
	  and username2 not in 
	  (select g.* from (select @username:='$username' p) parm , get_friends g)
	  union 
	  select username1 username from RELATIONSHIP 
	  where username2 in 
	  (select g.* from (select @username:='$username' p) parm , get_friends g) and username1 not in 
          (select g.* from (select @username:='$username' p) parm , get_friends g)))) order by post_timestamp desc";
  $getposts = mysql_query($query) or die(mysql_error());
  $count = mysql_num_rows($getposts);
  if ($count === 0) {echo "<br><br>No Post to display"; die(); }
  while ( $row = mysql_fetch_assoc($getposts)){
    $post_id = $row['post_id'];
    $pusername = $row['username'];
    $ptitle = $row['title'];
    $plocation = $row['location_id'];
    $post_time = $row['post_timestamp'];
    $post_likecount = $row['like_counts'];
?>   

<?php
  echo "
  <p />
  <div class='newsFeedPost'>
    <div class='newsFeedPostOptions'>
    </div>
    <div class='posted_by'>Posted by <a style='color:black; font-weight:bold' href='profile.php?u=$pusername'>$pusername</a> at $post_time : </div>
    <div style='max-width: 600px;'>
      <a href='fullpost.php?post_id=$post_id'>$ptitle</a> <br />
    </div>
  </div>
  ";
  }?>
</body>
</html>
