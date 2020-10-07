/*
    Implementation 2
    Jacob Ballard, Xu Song, Noah Feld, Malachi Beerram
    CSC 362
*/

/* Remove and re-create DB */
DROP DATABASE IF EXISTS move_tutor;
CREATE DATABASE move_tutor;
USE move_tutor;

/* Table describes a Pokemon */
CREATE TABLE pokemons (
    PRIMARY KEY (poke_id),
    poke_id                INT AUTO_INCREMENT UNIQUE,
    poke_species           VARCHAR(100) NOT NULL,
    poke_name              VARCHAR(100)               
);

/* Stores different types that can be associated with 0 or many Pokemon */
CREATE TABLE types (
    PRIMARY KEY (poke_type),
    poke_type   VARCHAR(16)
);

/* Table describes a move associated with 0 or many Pokemon through the KnownMoves and LearnHistory tables */
CREATE TABLE moves (
    PRIMARY KEY (move_name),
    move_name   VARCHAR(32) NOT NULL,
    move_type   VARCHAR(16) NOT NULL,
    move_time   VARCHAR(16) NOT NULL,
    is_hm       VARCHAR(3)  NOT NULL,
    FOREIGN KEY (move_type) REFERENCES types(poke_type)
                            ON DELETE RESTRICT

);

/* Table associates a Pokemon with 1 - 4 moves */
CREATE TABLE known_moves (
    PRIMARY KEY (poke_id,move_name),
    poke_id     INT          NOT NULL,
    move_name   VARCHAR(32)  NOT NULL,
    FOREIGN KEY (poke_id) REFERENCES pokemons(poke_id)
                            ON DELETE RESTRICT,
    FOREIGN KEY (move_name) REFERENCES moves(move_name)
                            ON DELETE RESTRICT
    
);

/* If a Pokemon is taught a move, it's stored here */
CREATE TABLE learn_history (
    PRIMARY KEY (poke_id, move_name),
    poke_id     INT         NOT NULL,
    move_name   VARCHAR(32) NOT NULL,
    learn_date  DATE        DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (poke_id) REFERENCES pokemons (poke_id)
                        ON DELETE RESTRICT,
    FOREIGN KEY (move_name) REFERENCES moves (move_name)
                        ON DELETE RESTRICT
);

/* Stores the type of a Pokemon, Pokemon have 1 or 2 types */
CREATE TABLE poke_types (
    PRIMARY KEY (poke_id, poke_type),
    poke_id     INT     ,
    poke_type   VARCHAR(16),
    FOREIGN KEY (poke_id) REFERENCES pokemons (poke_id)
                        ON DELETE RESTRICT,
    FOREIGN KEY (poke_type) REFERENCES types (poke_type)
                        ON DELETE RESTRICT
);



-- add values to validation table
INSERT INTO types (poke_type)
VALUES ('normal'),
       ('fighting'),
       ('flying'),
       ('poison'),
       ('ground'),
       ('rock'),
       ('bug'),
       ('ghost'),
       ('steel'),
       ('fire'),
       ('water'),
       ('ice'),
       ('electric'),
       ('dragon'),
       ('psychic'),
       ('dark'),
       ('fairy'),
       ('glass');

-- Add values to pokemon for testing

INSERT INTO pokemons (poke_species, poke_name)
VALUES  ('char', 'charmander'),
        ('bob', 'lizard'),
        ('charles', 'lollipop'),
        ('bake', 'ry');