<html>
<head>
    <title>Add a New Move</title>
    <style>
    input[type=text], select {
  width: 100%;
  padding: 10px 20px;
  margin: 20px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
font-size: 16px;
  width: 100%;
  padding: 14px 20px;
  margin: 8px 0;
  border-radius: 4px;
  cursor: pointer;
  background-color: #008CBA;
  color: white;
  border: 2px solid #008CBA;
  transition-duration: 0.4s;
}

input[type=submit]:hover {
    
  background-color: white; 
  color: black;
}

.contents {
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
.header {
  padding: 30px;
  text-align: center;
  background: #2EAEBD;
  color: white;
  font-size:27px;
}
table {
  border-collapse: collapse;
  width: 100%;
  text-align: middle;
}

th, td {
  padding: 8px;
  text-align: middle;
  border-bottom: 1px solid #ddd;
}

tr:hover {background-color: #f5f5f5;}
tr:nth-child(odd) {background-color: #CFD4D5;}

th {
  background-color: #4A737D;
  color: white;
}

    </style>
</head>
<body>
<?php

// Show all PHP errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbhost = 'localhost';
$dbuser = 'webuser';
$dbpass = 'pass';
$dbname = 'move_tutor'; /* Change to move_tutor */

/* Make connection, and return error if it fails */
if (!$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname)){
    echo "Error: Failed to make a MySQL connection: " . "<br>";
    echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n";
    exit;
}
?>
    

<div class="sidebar">
  <a class="active" href="./menu_page.php">Menu</a>
  <a href="#news">Pokemon</a>
  <a href="#news">Move</a>
  <a href="#news">Pokemon_type</a>
</div>

<div class="main">
<div class="header">
<h2>Insert A <i><u>New Type</u></i> !</h2>
<p>Sorry, you can only insert into Types table... you can't updating or deleting...</p>
</div>
<div class="contents">
<form action="insert_type_page.php" method="post">
<label for="type_name">Type name:</label><br>
    <input type="text" id="type_name" name="type_name" 
    placeholder="Type name...Please check spelling...You can't update or delete in this table..."><br>

    <input type="submit" value="Submit">
</form>
<br> <br>
<table>
    <th>Existing Pokemon Types in the Database</th>
    <?php 
    $conn->query("USE $dbname;");
    $selectall_sql="SELECT * FROM types;";
    if (!$tableresult = $conn->query($selectall_sql)){ // get types
         echo "Failed to get types.";
         exit;
     }
    
    $addstmt = $conn->prepare("INSERT INTO types (poke_type) VALUES (?)");
    $addstmt->bind_param('s', $type_name);
    if (isset($_POST["type_name"])){
      $type_name=$_POST["type_name"];
      if(!$addstmt->execute()){
          echo $conn->error;
          echo "\n Insert query failed!";
       }
       else {
        //redirect so refresh works properly
        header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
        exit();}
      }
      if (!$tableresult = $conn->query($selectall_sql)){ // get types
        echo "Failed to get types.";
        exit;
    }
    while ($type_names = $tableresult->fetch_array()) {
      echo "<tr>";
      echo "<td>".$type_names['poke_type']. "</td>";
      echo "</tr>";}

    $conn->close();
    ?>

</table>



</div>
</div>
</body>