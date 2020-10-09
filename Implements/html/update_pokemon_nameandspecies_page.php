<!--
    This file will update the name or species of a pokemon in the
    pokemons table
-->

<!DOCTYPE html>
<html>
<head>
<title>Update Pokemon Name and Species</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<?php

    echo file_get_contents("./pokemon_control_menu.html", false);

?>



<div class="main">
<div class="header">
<h2>Update <i><u>Pokemon Name</u></i> !</h2>
<p>Update Pokemon name here, you can do other operations through sidebar....</p>
</div>
<div class="contents">
<?php
    // Show ALL PHP's errors.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // ---------- DISPLAY A RESULT SET AS AN HTML TABLE -----------------------
    function result_to_table($result, $qryres) {
        //$qryres = $result->fetch_all(); // get array of rows from result object, so we can iterate more than once
        $n_rows = $result->num_rows; // num_rows
        $n_cols = $result->field_count; // num_col
        
        // Description of table -------------------------------------
        // echo "<p>This table has $n_rows rows and $n_cols columns.</p>\n";
        

        //wrap table in a form and call self
        echo '<form action="update_pokemon_nameandspecies_page.php" method=POST>';
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
                    echo '<td><input type="checkbox" name="checkbox' . $qryres[$i][$j] . '" value=' . $qryres[$i][$j] . '/></td>';
                } else {
                    echo "<td>" . $qryres[$i][$j - 1] . "</td>";
                }
            }
            echo "</tr>\n";
        }
        echo "</tbody>\n</table>\n";
        
        //add a submit button to the form and close out the form
        echo "<br>";
        echo '<label for="poke_name">Pokemon name:</label><br>';
        echo '<input type="text" id="poke_name" name="name" placeholder="Pokemon name..."><br>';
        echo '<label for="poke_name">Pokemon species:</label><br>';
        echo '<input type="text" id="poke_name" name="species" placeholder="Pokemon species..."><br>';
        echo '<p><input type="submit"/></p></form>';
    }

    function insert_to_table() {


    }


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

    // $sql = "SELECT poke_id, poke_species, poke_name FROM pokemons";
    $sql = "SELECT poke_id, poke_name, poke_species FROM pokemons";
    

    if(!$result = $conn->query($sql)){
        echo "Query failed!";
        exit;
    }

    $result = $conn->query($sql);
    $qryres = $result->fetch_all();

    result_to_table($result, $qryres); 

    //check if a name was entered into the textbox for UPDATE
    if(isset($_POST["name"]) && $_POST["name"] != "" && isset($_POST["species"]) && $_POST["species"] != "") {
        for($i = 0; $i < $result->num_rows; $i++) {

            $id = $qryres[$i][0];
            $name = $_POST["name"];
            $species = $_POST["species"];
            //UPDATE statement found in same directory as self
            $file = file_get_contents('./../pokemon_updatenameandspecies.sql', false);
            $stmt = $conn->prepare($file);
            $stmt->bind_param('ssi', $name, $species, $id); 
    
            if (isset($_POST["checkbox$id"]) ){
                if (!$stmt->execute()) {
                    echo $conn->error;
                } else {
                    //redirect so refresh works properly
                    header("Location: {$_SERVER['REQUEST_URI']}", true, 303);
                    exit();
                }
                
            } else {
                //rows not selected
            }
        }
    }
    
    
    

    


    $conn->close();

    
?>
</div>
</div>
</body>
</html>

