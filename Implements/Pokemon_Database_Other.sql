/*
  CSC 362 Database Systems
  Team 3
*/

/* Create the database (dropping the previous version if necessary) */
DROP DATABASE IF EXISTS Pokemon_Database;
CREATE DATABASE Pokemon_Database;
USE Pokemon_Database;

/* Create the Pokemons tables */
CREATE TABLE Pokemons(
    PRIMARY KEY     (poke_id),
    
    poke_id         INT AUTO_INCREMENT  NOT NULL,      
    poke_species  	VARCHAR(50)         NOT NULL,
    poke_name    	VARCHAR(100)        NOT NULL
);

/* Create the Types tables */
CREATE TABLE Types(
    PRIMARY KEY     (type),
    
    type            VARCHAR(50)         NOT NULL
);

/* Create the PokeTypes tables */
CREATE TABLE PokeTypes(
    FOREIGN KEY(poke_id)   REFERENCES Pokemons(poke_id),
    FOREIGN KEY(type)      REFERENCES Types(type),
    
    poke_id         INT AUTO_INCREMENT  NOT NULL,      
    type  	        VARCHAR(50)
);

/* Create the Moves tables */
CREATE TABLE Moves(
    PRIMARY KEY(move_name),
    FOREIGN KEY(type)      REFERENCES Types(type),
    
    move_name       VARCHAR(100)        NOT NULL,
    type            VARCHAR(50)         NOT NULL,
    move_time       INT,      
    is_hm  	        BOOLEAN
);

/* Create the LearnHistory tables */
    /* note that date is a key work and a data type os date is used as date_ and with a date type */
CREATE TABLE LearnHistory(
    FOREIGN KEY(poke_id)   REFERENCES Pokemons(poke_id),
    FOREIGN KEY(move_name) REFERENCES Moves(move_name),
    
    poke_id         INT AUTO_INCREMENT  NOT NULL,
    move_name       VARCHAR(100),
    date_           DATE  
);


/* Create the KnownMoves tables */
CREATE TABLE KnownMoves(
    FOREIGN KEY(poke_id)   REFERENCES Pokemons(poke_id),
    FOREIGN KEY(move_name) REFERENCES Moves(move_name),
    
    poke_id         INT AUTO_INCREMENT  NOT NULL,      
    move_name       VARCHAR(100)
);