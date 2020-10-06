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
.lists {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  font-size: 20px;
}
.topnav {
  top:0;
  width: 100%;
  position: fixed;
  overflow: hidden;
  background-color: #333;
}
.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}
.topnav a.active {
  background-color: #008CBA;
  color: white;
}
.main {
  padding: 16px;
  margin-top: 30px;

}

</style>
</head>
<body>

<div class="topnav">
  <a class="active" href="./menu_page.php">Menu</a>
  <a href="#pokemon">Pokemon</a>
  <a href="#pokemon">Poke_Type</a>
  <a href="#pokemon">Known_Moves</a>
  <a href="#pokemon">Moves</a>
  <a href="#pokemon">Types</a>
  <a href="#pokemon">Learn_History</a>
  <a href="#pokemon">Specific Pokemon</a>
  <a href="#pokemon">Specific Move</a>
</div>

<div class="main">
<h1>Welcome to <i><b><u>Tutor Database</u></b></i></h2>
<br>
<h2>Which operation do you want to do?</h2>
<br>
<p>
<b>Hyperlinks go to currently working pages</b><br>
<a href="./insert_move_page.php">Insert Move Page</a> <br>

<a href="./update_pokemon_name_page.php">Update Pokemon Name Page</a>
</p>

<div class="lists">
<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

// set variables to connect mariadb
$dbhost = 'localhost';
$dbuser = 'webuser';
$dbpass = 'pass';

// connect to mariadb
$conn = new mysqli($dbhost, $dbuser, $dbpass);

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
</div>
</div>
</body>

</html>
