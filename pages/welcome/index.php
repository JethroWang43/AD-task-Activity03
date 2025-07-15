<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once COMPONENT_PATH . '/templates/header.component.php';
require_once COMPONENT_PATH . '/templates/nav.component.php';
require_once COMPONENT_PATH . '/templates/footer.component.php';
require_once COMPONENT_PATH . '/templates/MeetingComponent.php';
require_once UTILS_PATH . '/db.util.php'; // ✅ DB connection

$pdo = connectToPostgres(); // ✅ Connect to DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $time = trim($_POST['time'] ?? '');

    if ($title && $date && $time) {
        $datetime = "$date $time";

        // ✅ Insert with description
        $stmt = $pdo->prepare("INSERT INTO meeting (name, description, created_at) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $datetime]);

        header("Location: /pages/welcome/index.php"); // Avoid form resubmission
        exit;
    }
}

// ✅ Fetch with description
$stmt = $pdo->query("SELECT name AS title, description, created_at AS date FROM meeting ORDER BY created_at DESC");
$meetings = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

// ✅ Extract date and time from datetime
foreach ($meetings as &$meeting) {
    $dt = new DateTime($meeting['date']);
    $meeting['date'] = $dt->format('Y-m-d');
    $meeting['time'] = $dt->format('H:i');
}

head();
nav();
?>

<main class="container">
    <div class="side-by-side">
        <?php include COMPONENT_PATH . '/templates/calendar.php'; ?>
        <?php renderMeetingComponent($meetings); ?> <!-- ✅ Now includes description -->
    </div>
</main>

<?php
footer();
?>
