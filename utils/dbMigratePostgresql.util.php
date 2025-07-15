<?php 
declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

try {
    $dsn = "pgsql:host={$_ENV['POSTGRES_HOST']};port={$_ENV['POSTGRES_PORT']};dbname={$_ENV['POSTGRES_DB']}";
    $pdo = new PDO($dsn, $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Removing existing tables...\n";
    foreach ([
        'meeting_users',
        'tasks',
        'meeting',
        'users',
        'projects'
    ] as $table) {
        $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
        echo "🗑️ Removed table: $table\n";
    }

    $modelFiles = [
        'user.model.sql',
        'meeting.model.sql',
        'meeting_users.model.sql',
        'task.model.sql',
    ];

    foreach ($modelFiles as $file) {
        $path = BASE_PATH . '/database/' . $file;
        echo "📦 Loading schema from database/{$file}...\n";

        $sql = file_get_contents($path);

        if ($sql === false) {
            throw new RuntimeException("❌ Unable to read database/{$file}");
        }

        $pdo->exec($sql);
        echo "✅ Schema successfully applied from $file\n\n";
    }

    echo "🎉 finished successfully!\n";
} catch (Throwable $e) {
    echo "❌ Migration encountered an error: " . $e->getMessage() . "\n";
    exit(255);
}
