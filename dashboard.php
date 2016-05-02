<?php 
include("auth.php"); //include auth.php file on all secure pages 
require("db.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard</title>
<link rel='stylesheet' href='css/style.css'/>
</head>
<body>
<div class="form">
  <p><a href="index.php">Welcome</a> | <a href="logout.php">Logout</a></p>
</div>
<div class='newsFeed'>
  <h2>Your Newsfeed</h2>
  <form action='search_posts.php' method='GET' id='search_posts' style="margin: 0px; padding: 0px;">
    <input type='text' name='search_posts_key' size='60' placeholder='Search Posts' />
  </form>
</div>

<?php
  $username=$_SESSION['username'];
  $getposts = mysql_query("call fetch_frd_news('$username')") or die(mysql_error());
  while ( $row = mysql_fetch_assoc($getposts)){
    $post_id = $row['post_id'];
    $pusername = $row['username'];
    $ptitle = $row['title'];
    $plocation = $row['location_id'];
    $post_time = $row['post_timestamp'];
    $post_likecount = $row['like_counts'];
    $liked_by =  $row['liked_by'];
?>    

<script language="javascript">
  function toggle<? echo $post_id; ?>() {
      var ele = document.getElementById("toggleComment<? echo $post_id; ?>");
      var text = document.getElementById("displayComment<? echo $post_id; ?>");
      if (ele.style.display == "block") {
        ele.style.display = "none";
      } else
	{ele.style.display = "block";}
  }
</script>

<?php
  echo "
  <p />
  <div class='newsFeedPost'>
    <div class='newsFeedPostOptions'>
      <a href='#' onClick='javascript:toggle$post_id()'>Show Comments</a>
    </div>
    <div class='posted_by'>Posted by <a href='profile.php?u=$pusername' style='color: black; font-weight: bold'>$pusername</a> at $post_time : </div><br />
    <div style='max-width: 600px;'>
      <a href='fullpost.php?post_id=$post_id' style='color:black; font-weight:bold'>$ptitle <br />
    </div>
    <div>
      <a href='like_frame.php?id=$post_id'; ?>Like</a>
      <p style='display: inline; color:grey'>$post_likecount people like this.</p>
      <li>$liked_by</li>
    </div>
    <div id='toggleComment$post_id' style='display: none;'>
      <br />
      <iframe src='comment_frame.php?id=$post_id' frameborder='0' style='max-height: 150px; width: 100%; min-height: 10px;'></iframe>
    </div>
  </div>
  ";
  }?>
<div class='search_friends';>
  <form action='search_friends.php' method='GET' id='search'>
    <input type='text' name='search_key' size='60' placeholder='Search Friends' />
  </form>
</div>
</body>
</html>
