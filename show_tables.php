<?php
$servername='127.0.0.1';
$username = 'root';
$password = 196663;
$database = 'hw3';

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

echo '<form method="POST" action="show_columns.php">';
if(!empty($_POST['field_name'])) {
  $field_name = $_POST['field_name'];
  $searchTableSQL = "SELECT DISTINCT table_name FROM information_schema.columns
    WHERE LOWER(column_name) LIKE LOWER('%$field_name%') AND table_schema = 'hw3'";
  $result = $conn->query($searchTableSQL);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $table_name = $row['table_name'];
      echo "<input type='submit' name='table_name' value='$table_name' /> <br/>";
    }
  }
}
echo '</form>';
?>
