<?php 


define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'national_parks_db');
define('DB_USER', 'user1');
define('DB_PASS', 'user1');


require_once('db_connect.php');

$parks = 'CREATE TABLE parks (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(240) NOT NULL,
    location VARCHAR(50) NOT NULL,
    date_established DATE NOT NULL, 
    area_in_acres FLOAT(12,2) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id)
)';

$dbc->exec($parks);

?>