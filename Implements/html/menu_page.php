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

.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  background-color: #f1f1f1;
  position: fixed;
  height: 100%;
  overflow: auto;
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}
 
.sidebar a.active {
  background-color: #008CBA;
  color: white;
}

.sidebar a:hover:not(.active) {
  background-color: #555;
  color: white;
}

div.main {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.main {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}

</style>
</head>
<body>

<div class="sidebar">
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
