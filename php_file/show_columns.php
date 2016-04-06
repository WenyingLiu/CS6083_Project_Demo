<?php
$servername='127.0.0.1';
$username = 'root';
$password = 196663;
$database = 'hw3';

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

echo '<form method="POST" action="show_tables.php">';
if(!empty($_POST['table_name'])) {
    $table_name = $_POST['table_name']; // get input

    $descTableSQL = "DESCRIBE {$table_name};"; // use DESCRIBE
    $query = $conn->query($descTableSQL); // execute query
    while($row = $query->fetch_assoc()) { // fetch rows
      $field_name = $row['Field'];
      echo "<input type='submit' name='field_name' value='$field_name' /> <br/>";
        }
}
echo '</form>';
?>
