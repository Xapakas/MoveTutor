<html>
<head>
<title>Manu Page</title>
<style>
ul {
  list-style-type: none;
  padding: 0;
  border-bottom: 1px solid #ddd;
  font-size: 20px;
}
ol{
    font-size:18px;
}

ul li {
  padding: 15px 20px;
  border-bottom: 1px solid #ddd;
}

ul li:last-child {
  border-bottom: none
}
ol li:hover{
    background: #D8BFD8;
    font-weight:bold;
}
li:hover{
    background: #E6E6FA;
}

</style>
</head>
<body>


<p>
<b>Hyperlinks go to currently working pages</b><br>
<a href="./insert_move_page.php">Insert Move Page</a> <br>

<a href="./update_pokemon_name_page.php">Update Pokemon Name Page</a>
</p>

<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

// set variables to connect mariadb
$dbhost = 'localhost';
$dbuser = 'webuser';
$dbpass = 'pass';

// connect to mariadb
$conn = new mysqli($dbhost, $dbuser, $dbpass);

// indicate the database name to user
echo "<h1>Welcome to <i><b><u>Tutor Database</u></b></i></h2>";
echo "<br>";
echo "<h2>Which operation do you want to do?</h3>";
echo "<br>";

// choose the target database
$conn->query("USE move_tutor;");

echo "<ul>";
    echo "<li><b>Tables</b> (Inserting, Updating, Deleting)";
    echo "<ol>";
    // show all the table names in the target database
    $tableresult = $conn->query("SHOW TABLES;")or die("Last error: {$conn->error}\n");
        while ($tablename = $tableresult->fetch_array()) {
            // print each table name
            echo "<li>".$tablename['Tables_in_move_tutor']. "</li>";
        }
    // end connection
    $conn->close();
    echo "</ol></li>";

    echo "<li><b>Check on the specific Move</b></li>";
    echo "<li><b>Check on the specific Pokemon</b></li>";
echo "</ul>";

?>

</body>

</html>
