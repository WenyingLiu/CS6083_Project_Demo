<?php
ob_start();
session_start();
$_SESSION['timestamp']=time();

echo '<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>';
require('db.php');
// If form submitted, check values within the database.
if (isset($_POST['username'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $username = stripslashes($username);
  $username = mysql_real_escape_string($username);
  $password = stripslashes($password);
  $password = mysql_real_escape_string($password);
 //Checking is user existing in the database or not
  $query = "SELECT * FROM user_login WHERE username='$username' and password='$password'";
  $result = mysql_query($query) or die(mysql_error());
  $rows = mysql_num_rows($result);
  if($rows==1){
    $_SESSION['username'] = $username;
    header("Location: index.php"); // Redirect user to index.php
    ob_end_flush();
    }else{
         echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
         }
}else{
 ?>
  <div class="form">
  <h1>Log In</h1>
  <form action="" method="post" name="login">
  <input type="text" name="username" placeholder="Username" required />
  <input type="password" name="password" placeholder="Password" required />
  <input name="submit" type="submit" value="Login" />
  </form>
  <p>Not registered yet? <a href='registration.php'>Register Here</a></p>
  </div>
<?php } ?>
<?php 
  $idletime=1800;
  if (time() - $_SESSION['timestamp']>$idletime){
    session_destroy();
    session_unset();
    header('Location: logout.php');
  } else{ $_SESSION['timestamp']=time();}
 
?>
</body>
</html>
