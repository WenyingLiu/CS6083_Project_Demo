<!DOCTYPE html>
<html>
<head>
          <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
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

$search = "";
$searchErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["search"])) {
          $searchErr = "Search keyword is required";
    }
    else {
          $search = test_input($_POST["search"]);
          }
}

function test_input($data) {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
}
?>

<h2>Search Keyword</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   Search: <input type="text" name="search">
   <span class="error">* <?php echo $searchErr;?></span>
   <br><br>
   <input type="submit" name="submit" value="Submit">
</form>

<?php
echo '<h2> Search Result: </h2>';
$searchSQL = "
  SELECT DISTINCT table_name FROM information_schema.columns
WHERE LOWER(column_name) LIKE LOWER('%$search%') AND table_schema = 'hw3'
";

$result = $conn->query($searchSQL);

echo '<form method="POST" action="show_columns.php">'; // opening form tag

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $table_name = $row['table_name'];
        echo "<input type='submit' name='table_name' value='$table_name' /> <br/>";
    }
} else {
  echo '0 result';}

echo '</form>'; // closing form tag
?>

</body>
</html>
