UPDATE pokemons
SET poke_species = $poke_species, poke_name= $poke_name
WHERE poke_id = $poke_id;
