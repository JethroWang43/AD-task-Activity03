<?php
// utils/dbSeederPostgresql.util.php

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

    echo "🌱 Seeding users...\n";
    $users = require_once STATICDATA_PATH . '/dummies/users.staticData.php';
    $userStmt = $pdo->prepare("INSERT INTO users (username, role, first_name, last_name, password) VALUES (:username, :role, :fn, :ln, :pw)");
    foreach ($users as $user) {
        $userStmt->execute([
            ':username' => $user['username'],
            ':role' => $user['role'],
            ':fn' => $user['first_name'],
            ':ln' => $user['last_name'],
            ':pw' => password_hash($user['password'], PASSWORD_DEFAULT),
        ]);
    }

    echo "📅 Seeding meetings...\n";
    $meetings = require_once STATICDATA_PATH . '/dummies/meeting.staticData.php';
    $meetingStmt = $pdo->prepare("INSERT INTO meeting (name, description) VALUES (:name, :description)");
    foreach ($meetings as $meeting) {
        $meetingStmt->execute([
            ':name' => $meeting['name'],
            ':description' => $meeting['description']
        ]);
    }

    echo "🔗 Linking users to meetings...\n";
    $meetingUsers = require_once STATICDATA_PATH . '/dummies/meeting_users.staticData.php';
    foreach ($meetingUsers as $link) {
        $meetingIdStmt = $pdo->prepare("SELECT id FROM meeting WHERE name = :name LIMIT 1");
        $meetingIdStmt->execute([':name' => $link['meeting_name']]);
        $meetingId = $meetingIdStmt->fetchColumn();

        $userIdStmt = $pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
        $userIdStmt->execute([':username' => $link['username']]);
        $userId = $userIdStmt->fetchColumn();

        if ($meetingId && $userId) {
            $linkStmt = $pdo->prepare("INSERT INTO meeting_users (meeting_id, user_id) VALUES (:mid, :uid)");
            $linkStmt->execute([
                ':mid' => $meetingId,
                ':uid' => $userId
            ]);
        } else {
            echo "⚠️ Skipping link: meeting or user not found for '{$link['meeting_name']}' / '{$link['username']}'\n";
        }
    }

    echo "🧩 Seeding tasks...\n";
    $tasks = require_once STATICDATA_PATH . '/dummies/tasks.staticData.php';
    foreach ($tasks as $task) {
        $meetingIdStmt = $pdo->prepare("SELECT id FROM meeting WHERE name = :name LIMIT 1");
        $meetingIdStmt->execute([':name' => $task['meeting_name']]);
        $meetingId = $meetingIdStmt->fetchColumn();

        $assignedIdStmt = $pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
        $assignedIdStmt->execute([':username' => $task['assigned_to_username']]);
        $assignedId = $assignedIdStmt->fetchColumn();

        if ($meetingId && $assignedId) {
            $taskStmt = $pdo->prepare("INSERT INTO tasks (meeting_id, title, description, status, assigned_to) VALUES (:mid, :title, :desc, :status, :uid)");
            $taskStmt->execute([
                ':mid' => $meetingId,
                ':title' => $task['title'],
                ':desc' => $task['description'],
                ':status' => $task['status'],
                ':uid' => $assignedId
            ]);
        } else {
            echo "⚠️ Skipping task: meeting or assigned user not found for '{$task['title']}'\n";
        }
    }

    echo "🎉 All data seeded successfully!\n\n";

} catch (PDOException $ex) {
    echo "💥 Error during seeding: " . $ex->getMessage() . "\n";
    exit(255);
}
