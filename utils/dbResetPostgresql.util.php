<?php 
declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

$typeConfig = require_once UTILS_PATH . '/envSetter.util.php';
$pgConfig = $typeConfig['postgres'];

$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['db']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "✅ PostgreSQL connection established successfully\n";

$tables = ['meeting_users', 'tasks', 'meeting', 'users'];
foreach ($tables as $table) {
    try {
        $pdo->exec("DROP TABLE IF EXISTS public.\"{$table}\" CASCADE;");
        echo "🗑️ Table dropped: {$table}\n";
    } catch (PDOException $e) {
        echo "❌ Error dropping table {$table}: " . $e->getMessage() . "\n";
    }
}

$sqlFiles = [
    'database/user.model.sql',
    'database/meeting.model.sql',
    'database/meeting_users.model.sql',
    'database/task.model.sql'
];

foreach ($sqlFiles as $file) {
    echo "📦 Applying schema from {$file}…\n";
    $sql = file_get_contents($file);

    echo "\n🔍 DEBUG: Contents of {$file}:\n\n$sql\n\n";

    if ($sql === false) {
        throw new RuntimeException("❌ Unable to read file: {$file}");
    }

    $pdo->exec($sql);
    echo "✅ Schema applied successfully from {$file}\n";
}

echo "🧹 Truncating all tables...\n";
foreach (['meeting_users', 'meeting', 'tasks', 'users'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}
