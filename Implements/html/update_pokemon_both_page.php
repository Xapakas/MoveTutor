<!DOCTYPE html>
<html>
<head>
    <title>Add a New Pokemon</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php // initial php setup

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

?>

<div class="sidebar">
  <a class="active" href="./menu_page.php">Menu</a>
  <a href="./pokemons_page.php">View Pokemon</a>
  <a href="./insert_pokemon_page.php">Insert Pokemon</a>
  <a href="./update_pokemon_both_page.php">Change Name & Species</a>
  <a href="./update_pokemon_name_page.php">Change Name</a>
  <a href="./update_pokemon_species_page.php">Evolve to New Species</a>
  <a href="./specific_pokemon_page.php">Check a Pokemon</a>
</div>

<div class="main">

<div class="header">
    <h2>Update a Pokemon's Name and Species!</h2>
</div>

<div class="contents">

<form action="update_pokemon_both_page.php" method="post">
    
    <label for="poke_id">Select pokemon by ID:</label><br>
    <input list="ids" id="poke_id" name="poke_id"><br>
    <datalist id="ids">
    <?php
        $sql = "SELECT poke_id FROM pokemons";
        if (!$result = $conn->query($sql)){ // get ids
            echo "Failed to get id numbers.";
            exit;
        }
        $id_arr = $result->fetch_all();

        for ($i = 0; $i < $result->num_rows; $i++){
            $id_num = $id_arr[$i][0];
            echo "<option value=$id_num>";
        }
    ?>
    </datalist><br>

    <label for="poke_name">Change Nickname:</label><br>
    <input type="text" id="poke_name" name="poke_name"><br>

    <label for="poke_species">Change Species:</label><br>
    <input type="text" id="poke_species" name="poke_species"><br>

    <input type="submit" value="Submit">

</form>

<?php

        if (!empty($_POST["poke_id"]) && !empty($_POST["poke_name"]) && !empty($_POST["poke_species"])){
            echo "henlo";
            $updt_stmt = $conn->prepare("UPDATE pokemons SET poke_name = ?, poke_species = ? WHERE poke_id = ?");
            $updt_stmt->bind_param('ssi', $_POST["poke_name"], $_POST["poke_species"], $_POST["poke_id"]);
            if (!$updt_stmt->execute()){
                echo $conn->error;
                echo "\n Update query failed!";
            }
        }

        $conn->close();

?>

</div>
</div>