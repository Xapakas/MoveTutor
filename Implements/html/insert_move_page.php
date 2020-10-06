<!DOCTYPE html>
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

.lists {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  font-size: 20px;
}
input[list]{
  padding: 5px 10px;
  margin: 20px 0;
}

.topnav {
    top:0;
  position: fixed;
    width: 100%;
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
<div class="main">
<?php

// Show all PHP errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* These four lines are meant for local 
   testing and should be changed when 
   added to the group repository. */

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
<div class="topnav">
  <a class="active" href="./menu_page.php">Menu</a>
  <a href="#news">Update Move</a>
</div>

<h2 align="center">Insert a new move!</h2>
<div class="lists">
<form action="insert_move_page.php" method="post">

    <label for="move_name">Move name:</label><br>
    <input type="text" id="move_name" name="move_name" placeholder="Move name..."><br>

    <!-- <label for="move_type">Move type:</label><br>
    <input type="text" id="move_type" name="move_type"> -->

    <label for="move_type">Move type:</label><br>
    <input list="types" name="move_type" id="move_type">
    <datalist id="types">
    <?php
        $sql = "SELECT poke_type FROM types";
        if (!$result = $conn->query($sql)){ // get types
            echo "Failed to get types.";
            exit;
        }
        $types_arr = $result->fetch_all();

        for ($i = 0; $i < $result->num_rows; $i++){
            $typename = $types_arr[$i][0];
            echo "<option value=$typename>";
        }
    ?>
    </datalist>

    <p>Move time:</p>

    <input type="radio" id="past" name="move_time" value="past">
    <label for="past">Past</label><br>

    <input type="radio" id="present" name="move_time" value="present">
    <label for="present">Present</label><br>

    <input type="radio" id="future" name="move_time" value="future">
    <label for="future">Future</label><br>

    <input type="radio" id="N/A" name="move_time" value="N/A">
    <label for="N/A">N/A</label><br>

    <p>Is it a Hidden Move?</p>

    <!-- Since the value is an int, not a string, there may be a
         problem with the value here. -->

    <input type="radio" id="1" name="is_hm" value="yes">
    <label for="1">Yes</label><br>

    <input type="radio" id="0" name="is_hm" value="no">
    <label for="0">No</label><br><br>

    <input type="submit" value="Submit">
    
</form>
</div>
</div>

<?php

/* Check if every entry has been filled out by the user. */
if (isset($_POST["move_name"]) && isset($_POST["move_type"]) && 
    isset($_POST["move_time"]) && isset($_POST["is_hm"])){
        // prepared statement, of course.
        $add_stmt = $conn->prepare("INSERT INTO moves (move_name, move_type, move_time, is_hm)
                                         VALUES (?,?,?,?);"); // replace with file name??
        $add_stmt->bind_param('ssss', $_POST["move_name"], $_POST["move_type"], $_POST["move_time"], $_POST["is_hm"]);

        if (!$add_stmt->execute()) { // insert user data, return possible errors
            echo $conn->error;
            echo "\n Insert query failed!";
        }

    }

    $conn->close();

?>
</div>
</body>
</html>