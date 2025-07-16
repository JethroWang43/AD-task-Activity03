<?php
declare(strict_types=1);

require_once UTILS_PATH . '/db.util.php';

function handleMeetingForm(): void {
    $pdo = connectToPostgres();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');

        if ($title && $date && $time) {
            $datetime = "$date $time";
            $stmt = $pdo->prepare("INSERT INTO meeting (name, description, created_at) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $datetime]);

            header("Location: /pages/welcome/index.php");
            exit;
        }
    }
}

function fetchMeetings(): array {
    $pdo = connectToPostgres();
    $stmt = $pdo->query("SELECT name AS title, description, created_at AS date FROM meeting ORDER BY created_at DESC");
    $meetings = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

    foreach ($meetings as &$meeting) {
        $dt = new DateTime($meeting['date']);
        $meeting['date'] = $dt->format('Y-m-d');
        $meeting['time'] = $dt->format('H:i');
    }

    return $meetings;
}
