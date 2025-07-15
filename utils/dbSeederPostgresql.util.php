<?php 
declare(strict_types=1);
require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

try {
    $dsn = "pgsql:host={$_ENV['POSTGRES_HOST']};port={$_ENV['POSTGRES_PORT']};dbname={$_ENV['POSTGRES_DB']}";
    $pdo = new PDO($dsn, $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $modelFiles = [
        'user.model.sql',
        'meeting.model.sql',
        'meeting_users.model.sql',
        'task.model.sql',
    ];

    foreach ($modelFiles as $file) {
        $modelPath = BASE_PATH . '/database/' . $file;

        if (!file_exists($modelPath)) {
            echo "🚫 Oops! Couldn't find $file. Skipping...\n";
            continue;
        }

        echo "📦 Unpacking schema magic from database/{$file}…\n\n";
        $sql = file_get_contents($modelPath);
        
        if (trim($sql) === '') {
            echo "⚠️ Heads up: $file is empty. Skipping this one.\n\n";
            continue;
        }

        echo "🧾 Sneak peek into $file contents:\n\n$sql\n\n";
        $pdo->exec($sql);
        echo "✅ Boom! Schema from $file applied successfully.\n\n";
    }

    echo "🌱 Time to plant some users into the database garden...\n";

    $users = require_once STATICDATA_PATH . '/dummies/users.staticData.php';
    

    $stmt = $pdo->prepare("
        INSERT INTO users (username, role, first_name, last_name, password)
        VALUES (:username, :role, :fn, :ln, :pw)
    ");

    foreach ($users as $use) {
        $stmt->execute([
            ':username' => $use['username'],
            ':role' => $use['role'],
            ':fn' => $use['first_name'],
            ':ln' => $use['last_name'],
            ':pw' => password_hash($use['password'], PASSWORD_DEFAULT),
        ]);
    }

    echo "🎉 All users seeded successfully! Ready for action.\n\n";
} catch (PDOException $ex) {
    echo "💥 Something went wrong while planting users: " . $ex->getMessage() . "\n";
    exit(255);
}
