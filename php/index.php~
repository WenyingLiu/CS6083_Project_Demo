<!DOCTYPE html>
<html>
<head>
          <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<style>
.error {color: #FF0000;}
</style>
<body>

<h1>hw3</h1>

<?php

$servername = "127.0.0.1";
$username = "root";
$password = 196663;

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
     }

//Build connection to MySQL server.
/*
$link = mysql_connect('127.0.0.1', 'root', 196663);
if (!$link) {
  die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_close($link);
 */
?>

<?php
$search = $searchErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["search"])) {
          $searchErr = "Search keyword is required";
    }
    else {
      $search = test_input($_POST["search"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";}
          }
}

function test_input($data) {
     $data = trim($data);
     return $data;
}
?>

<h2>Search Keyword</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   Search: <input type="text" name="search" value="<?php echo $search;?>">
   <span class="error">* <?php echo $searchErr;?></span>
   <br><br>
   <input type="submit" name="submit" value="Submit">
</form>

<?php
echo '<h2> Search Result: </h2>';
$searchSQL = "
SELECT table_name FROM information_schema.tables
WHERE LOWER(table_name) LIKE LOWER('%$search%') AND table_schema = 'hw3'
";

if ($search!='')
{$result = $conn->query($searchSQL);

echo '<form method="POST" action="show_columns.php">'; // opening form tag

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $table_name = $row['table_name'];
        echo "<input type='submit' name='table_name' value='$table_name' /> <br/>";
    }
} else {
  echo '0 result';
}} else {echo ' ';}

echo'</form>'; // closing form tag
?>

</body>
</html>
