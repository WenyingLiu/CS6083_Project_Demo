<?php
require('db.php');
include("auth.php"); //include auth.php file on all secure pages ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>User Profile</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p><a href="view_profile.php">View My Profile</a></p>
<p><a href="update_profile.php">Update My Profile</a></p>
<p><a href='index.php'>Back Home</a></p>
<p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>
