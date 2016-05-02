<?php 
include("auth.php"); //include auth.php file on all secure pages 
require("db.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Full Post</title>
  <link rel='stylesheet' href='css/style.css'/>
</head>
<body>
  <div class="form">
    <p><a href="dashboard.php">Back</a> | <a href="logout.php">Logout</a></p>
  </div>
  <?
    $post_id = $_GET['post_id'];
    $query = "select * from posts p left join locations l on p.location_id=l.location_id where post_id='$post_id'";
    $fullpost = mysql_query($query) or die(mysql_error());
    while ($fullpostdetail = mysql_fetch_assoc($fullpost)){
      $username = $fullpostdetail['username'];
      $title = $fullpostdetail['title'];
      $body = $fullpostdetail['body'];
      $image = $fullpostdetail['image'];
      $latitude = $fullpostdetail['latitude'];
      $longitude = $fullpostdetail['longitude'];
      $post_timestamp = $fullpostdetail['post_timestamp'];
      echo "<center><strong><h2>" . $title . "</h2></strong>";
      echo "By " . "<a href=profile.php?u=$username style='color:black; font-weight:bold'>$username</a>" . " at $post_timestamp. </center><br />";
      if ($image!=''){
	      echo '<center><img src="data:image/jpeg;base64,'.base64_encode($image).'"/></center>'; }      
      echo "</center><p style='padding-left: 15%; padding-right: 15%'>" . $body . "</p>";		      
      if ($latitude!='' and $longitude!=''){
        echo "<center><img src=\"http://maps.google.com/maps/api/staticmap?center=$latitude,$longitude&zoom=15&size=400x300&sensor=false&markers=color:red%7Clabel:%7C$latitude,$longitude\" style='width: 400px; height: 300px;' />";
      } else {
       // Do nothing
        }
     }
        echo '<h3>Comments</h3>';
	$comment_query = "select post_id, username, comment_text, comment_timestamp from comments where post_id='$post_id' order by comment_timestamp desc";
        $comment_result = mysql_query($comment_query) or die(mysql_error());
	if (mysql_num_rows($comment_result) != 0) {
	  while ($crow = mysql_fetch_assoc($comment_result)) {
	    $comment_username = $crow['username'];
	    $comment_text = $crow['comment_text'];
	    $comment_time = $crow['comment_timestamp'];
            echo "Commented by <b><a href='profile.php?u=$comment_username'>$comment_username</a></b> at $comment_time:  <br />".$comment_text."<hr /><br>";
          }
	} else { echo "No comments yet!"; }
        
	echo "<h3>Enter Your Comments</h3>
	      <form method='POST' name='postComment<?php echo $post_id; ?>'>
		 <textarea rols='50' cols='75' style='height: 100px' name='post_comment_text'></textarea>
		 <br />
                 <input type='submit' name='postComment<?php echo $post_id; ?>' value='Post Comment'>
	      </form>";

	if (isset($_POST['postComment' . $post_id . ''])) {
	          $post_comment_text = $_POST['post_comment_text'];
		  $posted_by = $username;
		  $comment_timestamp = date('Y-m-d H:i:s');
		  mysql_query("INSERT INTO comments (post_id, username, comment_text, comment_timestamp) 
			       VALUES ('$post_id', '$username', '$post_comment_text', '$comment_timestamp')");
	          echo "Comment Posted!<p />";
                  
		      }
    
  ?>
</body>
</html>
