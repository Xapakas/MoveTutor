UPDATE known_moves
SET move_name = $new_move_name
WHERE poke_id = $poke_id AND move_name=$old_move_name;
