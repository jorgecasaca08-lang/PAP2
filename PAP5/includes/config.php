<?php
/*
Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password).
*/
define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USERNAME', getenv('DB_USERNAME') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'nicodobra');

/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($mysqli->connect_error){
    // Instead of dying, we'll set it to false and handle it in the pages
    // to show a friendly error message instead of a blank page.
    $mysqli = false;
}
?>
