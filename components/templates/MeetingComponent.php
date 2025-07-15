<?php
function renderMeetingComponent($meetings)
{
?>
    <div class="form-box">
        <form method="POST" action="">
            <label for="title">Meeting Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter meeting title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Enter meeting description" rows="3"></textarea>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <button type="submit">➕ Add Meeting</button>
        </form>
    </div>

    <div class="meeting-list">
        <h2 style="margin: 1rem 0; color: #fff;">Upcoming Meetings</h2>

        <?php if (!empty($meetings)): ?>
            <?php foreach ($meetings as $meeting): ?>
                <div class="meeting">
                    <div class="meeting-title" style="color: #fff;">
                        <?= htmlspecialchars($meeting['title']) ?>
                    </div>
                    <div class="meeting-time" style="color: #fff;">
                        <?= htmlspecialchars($meeting['date']) ?> at <?= htmlspecialchars($meeting['time']) ?>
                    </div>
                    <?php if (!empty($meeting['description'])): ?>
                        <div class="meeting-description" style="color: #ccc; font-style: italic;">
                            <?= htmlspecialchars($meeting['description']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: #fff;">No meetings scheduled.</p>
        <?php endif; ?>
    </div>
<?php
}
?>
