<?php
$config = require __DIR__ . '/../utils/envSetter.util.php';

$host = $config['postgres']['host'];
$port = $config['postgres']['port'] ?? '5432';
$username = $config['postgres']['user'];
$password = $config['postgres']['password'];
$dbname = $config['postgres']['calendardb'];

$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo "❌ Connection Failed: " . pg_last_error() . "  <br>";
    exit();
} else {
    echo "✅ PostgreSQL Connection  <br>";
    pg_close($dbconn);
}
