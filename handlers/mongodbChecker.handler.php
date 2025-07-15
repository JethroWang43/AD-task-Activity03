<?php
$config = require __DIR__ . '/../utils/envSetter.util.php';

$uri = $config['mongo']['uri'];

try {
    $mongo = new MongoDB\Driver\Manager("mongodb://host.docker.internal:27171");

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);

    echo "✅ Connected to MongoDB successfully.  <br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . "  <br>";
}
