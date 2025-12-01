<?php
// Connectar-se a la base de dades (o crear-la si no existeix)
$db = new SQLite3('ranking.db');

// Crear la taula seccions si no existeix
$db->exec("CREATE TABLE IF NOT EXISTS ranking (
	'jug_id'	INTEGER,
	'jug_nom'	TEXT,
    'jug_punts' Integer,
	'jug_temps' Text,
    /*Iniciar sesión + hacer un ranking real por nombre o por tiempo de contestación*/
	PRIMARY KEY('jug_id' AUTOINCREMENT)
);");
 
// Tancar la connexió
$db->close();
?>