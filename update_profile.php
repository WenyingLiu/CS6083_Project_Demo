<?php
require('db.php');
include("auth.php");
$username=$_REQUEST['id'];
$query = "select firstname, lastname, age from user_profile where username='$username'"; 
$result = mysql_query($query) or die ( mysql_error());
$row = mysql_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Update Record</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <div class="form">
  <p><a href="edit_profile.php">My Profile</a> | <a href="logout.php">Logout</a></p>
  <h1>Update Record</h1>
  <?php
    if (!ini_get('date.timezone')){
    date_default_timezone_set('America/New_York');
    }
    $status = "";
    if(isset($_POST['new']) && $_POST['new']==1) {
	$username=$_SESSION['username'];
	$update_date = date("Y-m-d H:i:s");
	$ufirstname =$_REQUEST['firstname'];
	$ulastname = $_REQUEST['lastname'];
	$uage =$_REQUEST['age'];
	$ucity = $_REQUEST['city'];
	$ustate = $_REQUEST['state'];
	$update="update user_profile set mostrecent_update='$update_date', firstname=lower('$ufirstname'), lastname=lower('$ulastname'), age='$uage', city='$ucity', state='$ustate' where username='$username'";
	mysql_query($update) or die(mysql_error());
	$status = "Record Updated Successfully. </br></br><a href='view_profile.php'>View Updated Record</a>";
	echo '<p style="color:#FF0000;">'.$status.'</p>';
    }else {
  ?>
  <div>
    <form name="form" method="post" action=""> 
      <input type="hidden" name="new" value="1" />
      <input name="id" type="hidden" value="<?php echo $row['username'];?>" />
      <p><input type="text" name="firstname" placeholder="Enter Firstname" required value="<?php echo $row['firstname'];?>" /></p>
      <p><input type="text" name="lastname" placeholder="Enter Lastname" required value="<?php echo $row['lastname'];?>" /></p>
      <p><input type="text" name="age" placeholder="Enter Age" required value="<?php echo $row['age'];?>" /></p>
      <p><input type="text" name="city" placeholder="Enter City" required value="<?php echo $row['city']?>"></p>
      <p><input type="text" name="state" placeholder="Enter State" required value="<?php echo $row['state']?>"></p>
      
      <p><input name="submit" type="submit" value="Update" /></p>
    </form>
  <?php } ?>
  </div>
</div>
</body>
</html>
