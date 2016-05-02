<?php
session_start();
ob_start();
require('db.php');
include("auth.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>View Records</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p><a href="index.php">Home</a> | <a href="logout.php">Logout</a></p>
<h2>View My Profile</h2>
<table width="100%" border="1" style="border-collapse:collapse;">
<thead>
<tr><th><strong>Firstname</strong></th><th><strong>Lastname</strong></th><th><strong>Age</strong></th><th><strong>City</strong></th><th><strong>State</strong></th><th><strong>Department</strong></th><th><strong>Level</strong></th><th><strong>Job Title</strong></th><th><strong>Update</strong></th></tr>
</thead>
<tbody>
<?php
$username=$_SESSION['username'];
$sel_query="CALL fetch_profile('$username')";
$result = mysql_query($sel_query);
$firstname = "N/A";
$lastname = "N/A";
$age = "N/A";
$city= "N/A";
$state = "N/A";
$department = "N/A";
$level = "N/A";
$job_title = "N/A";
while($row = mysql_fetch_assoc($result)) { 
        $firstname = $row['firstname'];
	$lastname = $row['lastname'];
	$age = $row['age'];
	$city = $row['city'];
	$state = $row['state'];
	$department = $row['dept_name'];
	$level = $row['level'];
	$job_title = $row['job_title'];
        }
?>
        <tr><td align="center"><?php echo ucfirst(strtolower($firstname)); ?></td>
            <td align="center"><?php echo ucfirst(strtolower($lastname)); ?></td>
	    <td align="center"><?php echo $age; ?></td>
	    <td align="center"><?php echo ucfirst(strtolower($city)); ?></td>
            <td align="center"><?php echo ucfirst(strtolower($state)); ?></td>
            <td align="center"><?php echo $department; ?></td>
	    <td align="center"><?php echo $level; ?></td>
            <td align="center"><?php echo $job_title; ?></td>
            <td align="center"><a href="update_profile.php?id=<?php echo $username; ?>">Update</a></td>
        </tr>
</tbody>
</table>
</div>
</body>
</html>
