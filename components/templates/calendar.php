<?php
$month = date('n');
$year = date('Y');
$today = date('j');
$currentMonth = date('n');
$currentYear = date('Y');

$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
$daysInMonth = date('t', $firstDayOfMonth);
$monthName = date('F', $firstDayOfMonth);
$startDay = date('w', $firstDayOfMonth);
?>

<div class="calendar-container">
    <div class="live-time">
        <span><strong>Time:</strong> <span id="live-clock"></span></span>
        <span><strong>Date:</strong> <span id="live-date"></span></span>
    </div>

    <h2><?= "$monthName $year"; ?></h2>

    <table class="calendar">
        <tr>
            <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th>
            <th>Thu</th><th>Fri</th><th>Sat</th>
        </tr>
        <tr>
            <?php
            for ($i = 0; $i < $startDay; $i++) echo "<td></td>";
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $isToday = ($day == $today && $month == $currentMonth && $year == $currentYear);
                $class = $isToday ? "today" : "";
                echo "<td class='$class'>$day</td>";
                if ((($day + $startDay) % 7) == 0) echo "</tr><tr>";
            }
            while ((($day + $startDay) % 7) != 1) {
                echo "<td></td>";
                $day++;
            }
            ?>
        </tr>
    </table>
</div>
