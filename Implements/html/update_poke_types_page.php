
<!DOCTYPE html>
<html>
<head>
<title>Update PokeTypes</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<div class='sidebar'>
    <a class="active" href="./menu_page.php">Menu</a>
    <a href="./insert_poke_types_page.php">Insert Poke type</a>
    <a href="./delete_poke_types_page.php">Delete Poke type</a>
</div>

<div class="main">
<div class="header">
<h2>Update <i><u>Pokemon Types</u></i> !</h2>
<p>Update Pokemon types here! You can do other operations through sidebar.</p>
</div>

<div class="contents">
<?php
    /* Put redirect at start of file to avoid header errors. */
    if (!empty($_POST["type_name"])){
        header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
    }

    // Show ALL PHP's errors.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $dbhost = 'localhost';
    $dbuser = 'webuser';
    $dbpass = 'pass';

    $dbname = "move_tutor";

    
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    
    if ($conn->connect_errno) {
        echo "Error: Failed to make a MySQL connection: " . "<br>";
        echo "Errno: $conn->connect_errno \n";
        echo "Error: $conn->connect_error \n";
        exit;
    }

    // ---------- DISPLAY A RESULT SET AS AN HTML TABLE -----------------------
    function result_to_table($result, $qryres, $conn) {
        //$qryres = $result->fetch_all(); // get array of rows from result object, so we can iterate more than once
        $n_rows = $result->num_rows; // num_rows
        $n_cols = $result->field_count; // num_col
        
        // Description of table -------------------------------------
        // echo "<p>This table has $n_rows rows and $n_cols columns.</p>\n";
        

        //wrap table in a form and call self
        echo '<form action="update_poke_types_page.php" method=POST>';
        // Begin header ---------------------------------------------
        echo "<table>\n<thead>\n<tr>";
        
        
        $fields = $result->fetch_fields();
        for ($i=0; $i<$n_cols + 1; $i++){
            if ($i == 0) {
                echo "<th>Update?</th>";
            } else {
                echo "<th>" . $fields[$i - 1]->name . "</th>";
            }
            
        }
        echo "</tr>\n</thead>\n";
        
        // Should displayu
        for ($i=0; $i<$n_rows; $i++){
            echo "<tr>";
            for($j=0; $j<$n_cols + 1; $j++){
                if ($j == 0) {
                    //checkbox
                    echo '<td><input type="checkbox" name="checkbox' . $qryres[$i][$j] . $qryres[$i][$j+1] . '" value=' . $qryres[$i][$j] . $qryres[$i][$j+1] . '></td>';
                } else {
                    echo "<td>" . $qryres[$i][$j - 1] . "</td>";
                }
            }
            echo "</tr>\n";
        }
        echo "</tbody>\n</table>\n";
        
        //add a submit button to the form and close out the form

        // echo '<p>Change Pokemon ID: <input type="text" name="poke_id"></p><br>';
        echo '<p>Change Pokemon Type:<p>';
        echo '<input list="types" name="type_name" id="type_name">';
        echo '<datalist id="types">';
        $sql = "SELECT poke_type FROM types";
        if (!$result = $conn->query($sql)){ // get result object.
            echo "Failed to get types.";
            exit;
        }
        $types_arr = $result->fetch_all(); // turn object into array.

        for ($i = 0; $i < $result->num_rows; $i++){ // iterate through array
            $typename = $types_arr[$i][0];
            echo "<option value=$typename>"; // print out every value into datalist
        }
        echo '</datalist>';

        echo '<p><input type="submit" value="Submit"></p></form>';
    }

    $sql = "SELECT * FROM poke_types
            INNER JOIN pokemons
            USING(poke_id)";

    if(!$result = $conn->query($sql)){
        echo "Query failed!";
        exit;
    }

    $result = $conn->query($sql);
    $qryres = $result->fetch_all();

    result_to_table($result, $qryres, $conn); 

    //check if a name was entered into the textbox for UPDATE
    if(!empty($_POST["type_name"])) {
        for($i = 0; $i < $result->num_rows; $i++) {

            $id = $qryres[$i][0];
            $old_type = $qryres[$i][1];

            $stmt = $conn->prepare("UPDATE poke_types SET poke_type = ? WHERE poke_id = ? AND poke_type = ?");
            $stmt->bind_param('sis', $_POST["type_name"], $id, $old_type);
    
            if (!empty($_POST["checkbox$id$old_type"]) ){
                if (!$stmt->execute()) {
                    echo $conn->error;
                // } else {
                //     //redirect so refresh works properly
                //     header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
                //     exit();
                }

            }
        }
    }
    
    $conn->close();
    
?>
</div>
</div>
</body>
</html>