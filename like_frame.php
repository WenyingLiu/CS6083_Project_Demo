<?php
session_start();
require 'db.php';
if (isset($_GET['id'])) {
  $post_id = $_GET['id'];
  $username = $_SESSION['username'];
  $query = "INSERT INTO likes select * from (select '$post_id', '$username') as tmp where not exists (select * from likes where post_id='$post_id' and username='$username')";
  mysql_query($query) or die(mysql_error());
}
header('Location: dashboard.php');
?>
