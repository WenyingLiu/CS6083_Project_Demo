<?php include("auth.php"); //include auth.php file on all secure pages ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome Home</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<h1>Welcome <?php echo $_SESSION['username']; ?>!</h1>
<p><a href='edit_profile.php'>My Profile</p>
<p><a href='dashboard.php'>Dashboard</a></p>
<p><a href='friend_request.php'>Friend Request</a></p>
<a href="logout.php">Logout</a>
</div>
<?php
  $idletime=1800;
    if (time() - $_SESSION['timestamp'] > $idletime){
      session_destroy();
      session_unset();
      } else {
	  $_SESSION['timestamp'] = time();
      }
?>
</body>
</html>
