<!DOCTYPE html>
<html>
<head>
    <title>Update a Move</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php

/* Show all PHP errors. */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Set connection info. */

$dbhost = 'localhost';
$dbuser = 'webuser';
$dbpass = 'pass';
$dbname = 'move_tutor';

/* Make connection, and return an error if it fails. */

if (!$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname)){
    echo "Error: Failed to make a MySQL connection: " . "<br>";
    echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n";
    exit;
}

?>

<div class="sidebar">
  <a class="active" href="./menu_page.php">Menu</a>
  <a class="mainpage" href="./moves_page.php">Main Move</a>
  <a href="./update_move_page.php">Update Move</a>
  <a href="./delete_move_page.php">Delete Move</a>
  <a href="./move_trend_page.php">Move Trend</a>
</div>

<div class="main">

<div class="header">
<h2>Update <i><u>Move</u></i> !</h2>
<p>Select a move and update its time (past, present, or future).</p>
</div>

<div class="contents">

<form action="update_move_page.php" method="post">

    <label for="move_name">Select move by name:</label><br>
    <input list="names" name="move_name" id="move_name">
    <datalist id="names">
    <?php
        $sql = "SELECT move_name FROM moves";
        if (!$result = $conn->query($sql)){ // get move names.
            echo "Failed to get move names.";
            exit;
        }
        $names_arr = $result->fetch_all(); // convert to array.

        for ($i = 0; $i < $result->num_rows; $i++){ // iterate
            $movename = $names_arr[$i][0];
            echo "<option value=$movename>"; // add option for every move.
        }
    ?>
    </datalist>

    <p>Change the move time to...</p>

    <input type="radio" id="past" name="move_time" value="past">
    <label for="past">Past</label><br>

    <input type="radio" id="present" name="move_time" value="present">
    <label for="present">Present</label><br>

    <input type="radio" id="future" name="move_time" value="future">
    <label for="future">Future</label><br>

    <input type="radio" id="N/A" name="move_time" value="N/A">
    <label for="N/A">N/A</label><br>

    <input type="submit" value="Submit">

</form>

</div>
</div>

<?php

    if (isset($_POST["move_name"]) && isset($_POST["move_time"])){
        // prepared statement, of course.
        $updt_stmt = $conn->prepare("UPDATE moves SET move_time = ? WHERE move_name = ?;");
        $updt_stmt->bind_param('ss', $_POST["move_time"], $_POST["move_name"]);
        // now, actually update.
        if (!$updt_stmt->execute()){ 
            echo $conn->error;
            echo "\n Update query failed!";
        } 
        else { // redirect so refreshing doesn't break everything.
            header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
            exit();
        }
    }

    $conn->close();

?>

</body>
</html>