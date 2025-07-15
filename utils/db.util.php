<?php
function connectToPostgres(): PDO {
    $host = $_ENV['POSTGRES_HOST'] ?? 'localhost';
    $port = $_ENV['POSTGRES_PORT'] ?? '5432';
    $dbname = $_ENV['POSTGRES_DB'] ?? 'calendardb';
    $user = $_ENV['POSTGRES_USER'] ?? 'postgres';
    $password = $_ENV['POSTGRES_PASSWORD'] ?? '';

    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    try {
        return new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        error_log("PostgreSQL connection error: " . $e->getMessage());
        http_response_code(500);
        exit('Internal Server Error');
    }
}



