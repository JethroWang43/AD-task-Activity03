<?php
require_once __DIR__ . '/../../bootstrap.php';
require_once COMPONENT_PATH . '/templates/header.component.php';
require_once COMPONENT_PATH . '/templates/nav.component.php';
require_once COMPONENT_PATH . '/templates/footer.component.php';
require_once COMPONENT_PATH . '/templates/MeetingComponent.php';
require_once HANDLERS_PATH . '/meeting.handler.php';

handleMeetingForm(); 
$meetings = fetchMeetings(); 

head();
nav();
?>

<main class="container">
    <div class="side-by-side">
        <?php include COMPONENT_PATH . '/templates/calendar.php'; ?>
        <?php renderMeetingComponent($meetings); ?>
    </div>
</main>

<?php
footer();
?>
