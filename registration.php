<? ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
  <p><a href="login.php">Back</a></p>
</div>
<?php
require('db.php');
if( !ini_get('date.timezone') ){
	date_default_timezone_set('America/New_York');
}
  // If form submitted, insert values into the database.
if (isset($_POST['username'])){
	  $username = $_POST['username'];
	  $password = $_POST['password'];
	  $username = stripslashes($username);
	  $username = mysql_real_escape_string($username);
	  $password = stripslashes($password);
	  $password = mysql_real_escape_string($password);
	  $reg_time = date("Y-m-d H:i:s");
	  // check if the username has already been taken.
	  $check_query = "select username from user_login where username='$username'";
	  $check_result = mysql_query($check_query);
	  if (mysql_num_rows($check_result)!=0){
	    echo "<div class='form'><center>
                    <h3>Username has been taken!</h3>
		    <p><a href='registration.php'>Back</a></p></center>
		  </div>";
	  } else {
	    $query = "INSERT into user_login (username, password, register_time) VALUES ('$username', '$password', '$reg_time')";
	    $result = mysql_query($query);
	    mysql_query("insert into user_profile(username) values ('$username')");
	    if($result){
	      echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
	    }
	  }  
}else{
?>
<div class="form">
<h1>Registration</h1>
<form name="registration" action="" method="post">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input type="submit" name="submit" value="Register" />
</form>
</div>
<?php } ?>
</body>
</html>
