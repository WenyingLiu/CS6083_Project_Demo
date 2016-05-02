<? include("db.php"); 
   session_start();
   ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Profile</title>
<link rel='stylesheet' href='css/style.css'/>
</head>
<body>
<div class="form">
  <p><a href="dashboard.php">Back</a> | <a href="logout.php">Logout</a></p>
</div>

<script language="javascript">
  function toggle<? echo $post_id; ?>() {
      var ele = document.getElementById("toggleComment<? echo $post_id; ?>");
      var text = document.getElementById("displayComment<? echo $post_id; ?>");
      if (ele.style.display == "block") {
        ele.style.display = "none"; } else {ele.style.display = "block";}
  }
</script>

<?
if (!ini_get('date.timezone')){
	  date_default_timezone_set('America/New_York');
}
$username = $_SESSION['username'];
if (isset($_GET['u'])) {
	$vusername = mysql_real_escape_string($_GET['u']);
	if (ctype_alnum($username)) {
	  //check if the user has view privilege to the visiting page.
	  $check = mysql_query("select username from user_profile 
			where (username='$vusername' and '$username' = '$vusername') or (username='$vusername' and ((profile_visible=0)
			or ((profile_visible=2 or profile_visible=1) and '$username' in (select g.* from (select @susername:='$vusername' p) parm , get_friends g))
			or (profile_visible=1 and '$username' in 
			(select username2 username from RELATIONSHIP
			 where username1 in
			(select g.* from (select @username:='$vusername' p) parm , get_friends g)
			  union 
			 select username1 username from RELATIONSHIP
			   where username2 in
			   (select g.* from (select @username:='$vusername' p) parm , get_friends g)))))");	
	if (mysql_num_rows($check) >= 1 ) {
	  $get = mysql_fetch_assoc($check);
	  $vusername = $get['username'];
	  $vfirstname = $get['first_name'];	
	  }
	else {
	  echo "<div style='font: 21px'><br><br><center> You have no privileges to view $vusername's full profile.</center>";	
	  echo "<form method='POST'>
		  <br /><center><input type='submit' name='addfriend' value='Add Friend'></center>
		</form>";
          exit();}
	}
}

$title = $_POST['title'];
$post = $_POST['post'];

$address = $_POST['address'];
$address = str_replace(" ", "+", $address);
$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=us";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($ch);
curl_close($ch);
$response_a = json_decode($response);
$addresslat = $response_a->results[0]->geometry->location->lat;
$addresslong = $response_a->results[0]->geometry->location->lng;
$exist_address = "select * from locations where latitude - '$addresslat' <= 0.00001 and longitude -'$addresslong' <= 0.0001";
$checkaddress = mysql_query($exist_address) or die(mysql_error());
if (mysql_num_rows($checkaddress) == 0) {
	$query = "insert into locations(location_name, latitude, longitude) values ('$address', '$addresslat', '$addresslong')";
	mysql_query($query) or die(mysql_error());
}
$fetch_addressid = "select location_id from locations where latitude - '$addresslat' <= 0.00001 and longitude - '$addresslong' <= 0.00001";
$result_addressid = mysql_query($fetch_addressid) or die(mysql_error());
$address_id = mysql_result($result_addressid, 0);

if (isset($_FILES['image']['tmp_name'])){
  $image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $image_name = $_FILES['image']['name'];
  } else { $image = '' ;}

if ($post != "") {
  $date_posted = date("Y-m-d H:m:s");
  $posted_by = $username;
  $sqlCommand = "INSERT INTO posts (username, title, body, image, location_id, post_timestamp) VALUES ('$username', '$title','$post', '$image', '$address_id','$date_posted')";  
  $query = mysql_query($sqlCommand) or die (mysql_error()); 
  }
?>

<?
if ($username==$vusername){
  echo '<div id="status"></div>
	  <br />
	  <div class="postForm">
	    <form  method="POST" style="padding-left:3cm; width: 70%" enctype="multipart/form-data">
              <br />
	      <textarea id="title" name="title" rows="1" cols="80" placeholder="What\'s Your News Today?"></textarea><br />
	      <textarea id="post" name="post" rows="6" cols="80"></textarea><br />
	      <input type="file" name="image">
	      <br /><textarea id="address" name="address" row="1" cols="60" placeholder="Your address here?"></textarea><br />
	      <input type="submit" name="send" value="Post" style="background-color: #78b941; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; text-align: center; border: 1px solid #78b941; color:#white; height:28px; width: 55px; font-size: 15px; margin-top: 5px; margin-left: 0" /><br /><br />
	    </form>
         </div>';
  }
?>

<div class="profilePosts">
<?
  $getposts = mysql_query("SELECT * FROM posts WHERE username='$vusername' ORDER BY post_timestamp DESC") or die(mysql_error());
  while($row = mysql_fetch_assoc($getposts)) {
	$post_id = $row['post_id'];
	$title = $row['title'];	
	$post_timestamp = $row['post_timestamp'];
	$posted_by = $vusername;
        
	echo "<br /><div class='newsFeedPost'>
	       <div class='posted_by' style='padding-left:3cm; padding-top: 0; width: 70%; font-size:18px'>Posted by:
                 <a href='profile.php?u=$vusername' style='font-weight: bold'>$posted_by</a> on $post_timestamp
	         <div  style='max-width: 800px;'>
                   <a href='fullpost.php?post_id=$post_id' style='font-weight: bold'>$title</a><br /><p /><p />
                 </div>
	        </div></div>	 ";
}

$errorMsg = "";
  if (isset($_POST['addfriend'])) {
     $friend_request = $_POST['addfriend'];
     
     $rusername = $vusername;
     $susername = $username;
     
     if ($rusername == $susername) {
      $errorMsg = "You can't send a friend request to yourself!<br />";
     }
     else
     {
      $create_request = mysql_query("INSERT INTO friend_req VALUES ('$susername','$rusername', now())");
      $errorMsg = "<br /> Your friend request has been sent!";
     }

  }
?>
</div>

<div style="font-size: 21px; padding-left:1cm; padding-top:18px"><? echo '<strong>About '.$vusername; ?></strong></div>
<div class="profileLeftSideContent">
    <?
      $about_query = mysql_query("SELECT * FROM user_profile u left join dept d on u.dept_id=d.dept_id WHERE username='$vusername'");
      $get_result = mysql_fetch_assoc($about_query);
      $city = ucfirst(strtolower($get_result['city']));
      $state = ucfirst(strtolower($get_result['state']));
      $department = $get_result['dept_name'];
      $dept_building = $get_result['dept_building'];
      $job_title = $get_result['job_title'];
      $level = $get_result['level'];
      $friendsArray = array();
      $countFriends = "";
      $addAsFriend = "";
      $selectFriendsQuery = mysql_query("select g.* from (select @susername:='$vusername' p) parm , get_friends g");
      while ($row = mysql_fetch_assoc($selectFriendsQuery)){
        foreach($row as $u)
          { array_push($friendsArray, $u); }
      }
      if ($friendsArray != "") {
        $countFriends = count($friendsArray);}
	echo "<li>City: $city</li>
              <li>State: $state</li>
	      <li>Department: $department</li>
	      <li>Building: $dept_building</li>
	      <li>Job Title: $job_title</li>
	      <li>Level: $level</li>
	      <li>$vusername has  <a href='friend_list.php?u=$vusername'>$countFriends</a> friends.</li>";
      {?>
    <form method="POST">
      <? if ((!in_array($username, $friendsArray)) and $vusername!=$username)
         { $addAsFriend = '<input type="submit" name="addfriend" value="Add Friend">';
           echo $addAsFriend;
           echo $errorMsg;}
      ?> 
      </form> <?php } ?>
</div>

</body>
</html>
