<?session_start();
  ob_start();
  include ("db.php"); ?>
<?
//Find Friend Requests
if (!ini_get('date.timezone')){
   date_default_timezone_set('America/New_York');
}
echo '<link rel="stylesheet" href="css/style.css" />';
$rusername = $_SESSION['username'];
$friendRequests = mysql_query("SELECT * FROM friend_req WHERE rusername='$rusername'");
$numrows = mysql_num_rows($friendRequests);
if ($numrows == 0) {
 echo "<br><br><center><strong>You have no friend Requests at this time.</strong></center>";
 echo "<center><p><a href='index.php'>Back</a></p></center>";
 $susername = "";
}
else
{
  while ($get_row = mysql_fetch_assoc($friendRequests)) {
  $rusername = $get_row['rusername'];
  $susername = $get_row['susername'];
  
  echo '<br> ' . $susername . ' wants to be friends'.'<br />';

?>
<?
if (isset($_POST['acceptrequest'.$susername])) {
  //Get friend array for logged-in user
  $add_friend_query = mysql_query("insert into relationship values ('$susername', '$rusername', now(), 1)");
  $delete_request = mysql_query("DELETE FROM friend_req WHERE susername='$susername' and rusername='$rusername'");
  echo "You are now friends!";
  header("Location: friend_request.php");

}
if (isset($_POST['ignorerequest'.$susername])) {
$ignore_request = mysql_query("DELETE FROM friend_req WHERE susername='$susername' and rusername='$rusername'");
  echo "Request Ignored!";
  header("Location: friend_request.php");
}
?>
<form action="friend_request.php" method="POST">
<input type="submit" name="acceptrequest<? echo $susername; ?>" value="Accept" style="font-size:8pt;color:white;background-color:#88cc00; border:2px solid #99cc00; padding:4px; margin-top: 3px">
<input type="submit" name="ignorerequest<? echo $susername; ?>" value="Ignore" style="font-size:8pt;color:white;background-color:#a6a6a6; border:2px solid #999999;padding:4px; margin-top: 3px">
</form>
<?
  }
}
?>
