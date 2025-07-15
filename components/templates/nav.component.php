<?php
function nav() {
    echo <<<HTML
<nav class="navbar">
    <div class="navbar-brand">🗓️ Meeting Planner</div>
    <ul class="navbar-links">
        <li><a href="/index.php">Home</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="/handlers/logout.handler.php">Logout</a></li>

    </ul>
</nav>
HTML;
}
