<?php
session_start();
$username = $_SESSION['username'];
?>
<style>
*  {
   font-size: 12px;
   font-family: Arial, Helvetica, Sans-serif;
   }
   hr {
   	background-color: #DCE5EE;
        height: 1px;
   	border: 0px;
      }
</style>

<?php
  include("db.php");
  $getid = $_GET['id'];
?>
<script language="javascript">
  function toggle() {
      var ele = document.getElementById("toggleComment");
      var text = document.getElementById("displayComment");
      if (ele.style.display == "block") {
        ele.style.display = "none";   			                                                                   }
      else {ele.style.display = "block";}
  }
</script>  

<?php
if ( !ini_get('date.timezone')){
  date_default_timezone_set('America/New_York');
}
if (isset($_POST['postComment' . $getid . ''])) {
  $post_comment_text = $_POST['post_comment_text'];
  $posted_by = $username;
  $comment_timestamp = date('Y-m-d H:i:s');
  mysql_query("INSERT INTO comments (post_id, username, comment_text, comment_timestamp) VALUES ('$getid', '$posted_by', '$post_comment_text', '$comment_timestamp')") or die(mysql_error());
  echo "Comment Posted!<p />";
  }
?>

<a href='javascript:;' onClick="javascript:toggle()"><div style='float: right; display: inline;'>Post Comment</div></a>
<div id='toggleComment'  style='display: none;'>
<form action="comment_frame.php?id=<?php echo $getid; ?>" method="POST" name="postComment<?php echo $getid; ?>">
Enter your comment below:<p />
<textarea rols="50" cols="50" style="height: 100px;" name="post_comment_text"></textarea>
<input type="submit" name="postComment<?php echo $getid; ?>" value="Post Comment">
</form>
</div>

<?php
$get_comments = mysql_query("SELECT username, comment_text, comment_timestamp FROM comments WHERE post_id='$getid' ORDER BY comment_timestamp DESC");
$count = mysql_num_rows($get_comments);
if ($count != 0) {
  while ($comment = mysql_fetch_assoc($get_comments)) {
    $comment_text = $comment['comment_text'];
    $cusername = $comment['username'];
    $post_timestamp = $comment['comment_timestamp'];
    echo "<b>$cusername </b><b>$post_timestamp: </b> <br />".$comment_text."<hr /><br>";
    }
}
else 
  { echo "<center><br><br><br>No comments to display!</center>";}
