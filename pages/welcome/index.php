<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once COMPONENT_PATH . '/templates/header.component.php';
require_once COMPONENT_PATH . '/templates/nav.component.php';
require_once COMPONENT_PATH . '/templates/footer.component.php';
require_once COMPONENT_PATH . '/templates/MeetingComponent.php';
require_once UTILS_PATH . '/db.util.php'; // ✅ Added for DB connection

$pdo = connectToPostgres(); // ✅ Connect to DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $time = trim($_POST['time'] ?? '');

    if ($title && $date && $time) {
        // ✅ Save to DB instead of session
        $datetime = "$date $time";
        $stmt = $pdo->prepare("INSERT INTO meeting (name, created_at) VALUES (?, ?)");
        $stmt->execute([$title, $datetime]);

        header("Location: /pages/welcome/index.php"); // Redirect to avoid resubmission
        exit;
    }
}

// ✅ Fetch meetings from DB instead of session
$stmt = $pdo->query("SELECT name AS title, created_at AS date FROM meeting ORDER BY created_at DESC");
$meetings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Extract time from datetime
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
        <?php renderMeetingComponent($meetings); ?> <!-- ✅ Use DB-based data -->
    </div>
</main>

<?php
footer();
?>
