<?php
// Connect to the MySQL database
$env = parse_ini_file(__DIR__ . '/../.env');
$DB_HOST = $env["DB_HOST"];
$DB_USERNAME = $env["DB_USERNAME"];
$DB_PASSWORD = $env["DB_PASSWORD"];
$DB_NAME = $env["DB_NAME"];
$conn = mysqli_connect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check connection
if (!$conn) {
    // Display connection errors and terminate
    echo 'Error code: ' . mysqli_connect_errno();
    echo 'Error message: ' . mysqli_connect_error();
    exit;
}
?>