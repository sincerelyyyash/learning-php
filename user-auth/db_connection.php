
<?php
$host = 'localhost';
$dbname = 'mysql';
$username = 'root';
$password = '';

try {
    $mysqli = new mysqli($host, $username, $password, $dbname);

    if ($mysqli->connect_errno) {
        throw new Exception("Failed to connect to MySQL: " . $mysqli->connect_error);
    }

    echo "Connected successfully to the database.";

} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

