<!DOCTYPE html>
<html>
<head>
    <title>Add a New Pokemon</title>
    <link rel="stylesheet" href="styles.css">
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
$dbname = 'move_tutor';

/* Make connection, and return error if it fails */
if (!$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname)){
    echo "Error: Failed to make a MySQL connection: " . "<br>";
    echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n";
    exit;
}

function insertType($conn, $id, $type_name) {
    // prepared statement.
    $ins_stmt = $conn->prepare("INSERT INTO poke_types (poke_id, poke_type)
                                     VALUES (?, ?);");
    $ins_stmt->bind_param('is',$id,$_POST[$type_name]);

    if (!$ins_stmt->execute()) { // add type.
        echo $conn->error;
        echo "Failed to insert type.";
    } 
}

function insertMove($conn, $id, $move_name) {
    $ins_stmt = $conn->prepare("INSERT INTO known_moves (poke_id,move_name)
                                                VALUES (?,?);");
    $ins_stmt->bind_param('is',$id,$_POST[$move_name]);
    if (!$ins_stmt->execute()) { // add move.
        echo $conn->error;
        echo "Failed to insert move.";
    }
}

?>

<div class="sidebar">
  <a class="active" href="./menu_page.php">Menu</a>
  <a href="./insert_pokemon_page.php">Insert Pokemon</a>
  <a href="./update_pokemon_both_page.php">Change Name & Species</a>
  <a href="./update_pokemon_name_page.php">Change Name</a>
  <a href="./update_pokemon_species_page.php">Evolve to New Species</a>
  <a href="./specific_pokemon_page.php">Check a Pokemon</a>
</div>

<div class="main">

<div class="header">
    <h2>Add a New Pokemon!</h2>
</div>

<div class="contents">

<form action="insert_pokemon_page.php" method="post">

    <label for="poke_species">Pokemon Species:</label><br>
    <input type="text" id="poke_species" name="poke_species"><br>

    <label for="poke_name">Pokemon Nickname (optional):</label><br>
    <input type="text" id="poke_name" name="poke_name"><br>

    <label for="poke_type1">Pokemon Type 1:</label><br>
    <input list="types" name="poke_type1" id="poke_type1">
    <datalist id="types">
    <?php // maybe replace with a procedure
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
    </datalist><br>

    <label for="poke_type2">Pokemon Type 2 (optional)</label><br>
    <input list="types" name="poke_type2" id="poke_type2">
    <datalist id="types"></datalist><br>

    <label for="move_1">Move 1:</label><br>
    <input list="names" name="move_1" id="move_1">
    <datalist id="names">
    <?php // again, procedure?
        $sql = "SELECT move_name FROM moves";
        if (!$result = $conn->query($sql)){ // get move names.
            echo "Failed to get move names.";
            exit;
        }
        $names_arr = $result->fetch_all(); // convert to array.

        for ($i = 0; $i < $result->num_rows; $i++){ // iterate
            $movename = $names_arr[$i][0];
            echo '<option value="'.$movename.'">'; // add option for every move.
        }
    ?>
    </datalist><br>

    <label for="move_2">Move 2 (optional):</label><br>
    <input list="names" name="move_2" id="move_2">
    <datalist id="names"></datalist><br>

    <label for="move_3">Move 3 (optional):</label><br>
    <input list="names" name="move_3" id="move_3">
    <datalist id="names"></datalist><br>

    <label for="move_4">Move 4 (optional):</label><br>
    <input list="names" name="move_4" id="move_4">
    <datalist id="names"></datalist><br>

    <input type="submit" value="Submit">

</form>

<?php
    if (isset($_POST["poke_species"]) && isset($_POST["poke_type1"]) && isset($_POST["move_1"])){
        /* Firstly, insert the name and species into the pokemon table. */
        if (isset($_POST["poke_name"])){ // poke_name IS entered
            // prepared statement, of course.
            $ins_stmt = $conn->prepare("INSERT INTO pokemons (poke_species,poke_name)
                                             VALUES (?,?);");
            $ins_stmt->bind_param('ss',$_POST["poke_species"],$_POST["poke_name"]);

            if (!$ins_stmt->execute()) { // insert user data, return possible errors
                echo $conn->error;
                echo "\n Insert query failed!";
            }
        }
        else { // poke_name is NOT entered
            // a different prepared statment.
            $ins_stmt = $conn->prepare("INSERT INTO pokemons (poke_species)
                                             VALUES (?);");
            $ins_stmt->bind_param('s',$_POST["poke_species"]);

            if (!$ins_stmt->execute()) { // insert user data, return possible errors
                echo $conn->error;
                echo "\n Insert query failed!";
            }
        }
        /* Then, insert types into poke_types. */

        $id_object = $conn->query("SELECT max(poke_id) FROM pokemons;"); // get id of added pokemon
        if (!$id_object){
            echo "Failed to get pokemon id.";
            exit();
        }
        $id_arr = $id_object->fetch_all(); // turn id into array.
        $inserted_id = $id_arr[0][0]; // get value [0][0] from the array: the integer id.

        insertType($conn, $inserted_id, "poke_type1");

        if (isset($_POST["poke_type2"])){ // 2 poke types were added
            insertType($conn, $inserted_id, "poke_type2");
        } 

        /* Now, insert into knownmoves. */

        insertMove($conn, $inserted_id, "move_1");

        if (isset($_POST["move_2"])){ 
            insertMove($conn, $inserted_id, "move_2");
        }

        if (isset($_POST["move_3"])){ 
            insertMove($conn, $inserted_id, "move_3");
        }

        if (isset($_POST["move_4"])){ 
            insertMove($conn, $inserted_id, "move_4");
        }

        header("Location: {$_SERVER['REQUEST_URI']}", true, 303); // redirect.

        $conn->close();

    }
?>

</div>
</div>

</body>
</html>