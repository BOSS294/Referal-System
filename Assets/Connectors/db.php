<?php
$host = '';
$db_name = '';
$username = '';
$password = '';


$mysqli = new mysqli($host, $username, $password, $db_name);

if ($mysqli->connect_error) {
    error_log("Database connection failed: " . $mysqli->connect_error);
    die("Sorry, there was a problem connecting to the database. Please try again later.");
}

$mysqli->set_charset("utf8mb4");

$mysqli->query("SET SESSION sql_mode = 'STRICT_ALL_TABLES'");
?>
