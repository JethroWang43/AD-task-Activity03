function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();

    const clockEl = document.getElementById('live-clock');
    const dateEl = document.getElementById('live-date');

    if (clockEl) clockEl.textContent = `${hours}:${minutes}:${seconds}`;
    if (dateEl) dateEl.textContent = `${month}/${day}/${year}`;
}

function renderCalendar() {
    const container = document.getElementById('calendar-container');
    if (!container) return;

    const today = new Date();
    const year = today.getFullYear();
    const month = today.getMonth(); // 0-based
    const date = today.getDate();

    const firstDay = new Date(year, month, 1);
    const lastDate = new Date(year, month + 1, 0).getDate();
    const startDay = firstDay.getDay(); // 0 = Sunday

    const monthName = firstDay.toLocaleString('default', { month: 'long' });

    let html = `<h2>${monthName} ${year}</h2>`;
    html += `<table class="calendar"><tr>`;
    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    days.forEach(day => html += `<th>${day}</th>`);
    html += `</tr><tr>`;

    for (let i = 0; i < startDay; i++) {
        html += `<td></td>`;
    }

    for (let d = 1; d <= lastDate; d++) {
        const isToday = d === date;
        const className = isToday ? 'today' : '';
        html += `<td class="${className}">${d}</td>`;
        if ((d + startDay) % 7 === 0) html += `</tr><tr>`;
    }

    const totalCells = startDay + lastDate;
    const emptyCells = (7 - (totalCells % 7)) % 7;
    for (let i = 0; i < emptyCells; i++) {
        html += `<td></td>`;
    }

    html += `</tr></table>`;

    container.innerHTML = container.innerHTML + html;
}

setInterval(updateTime, 1000);
updateTime();
renderCalendar();
function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();

    const clockEl = document.getElementById('live-clock');
    const dateEl = document.getElementById('live-date');

    if (clockEl) clockEl.textContent = `${hours}:${minutes}:${seconds}`;
    if (dateEl) dateEl.textContent = `${month}/${day}/${year}`;
}

function renderCalendar() {
    const container = document.getElementById('calendar-container');
    if (!container) return;

    const today = new Date();
    const year = today.getFullYear();
    const month = today.getMonth(); // 0-based
    const date = today.getDate();

    const firstDay = new Date(year, month, 1);
    const lastDate = new Date(year, month + 1, 0).getDate();
    const startDay = firstDay.getDay(); // 0 = Sunday

    const monthName = firstDay.toLocaleString('default', { month: 'long' });

    let html = `<h2>${monthName} ${year}</h2>`;
    html += `<table class="calendar"><tr>`;
    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    days.forEach(day => html += `<th>${day}</th>`);
    html += `</tr><tr>`;

    for (let i = 0; i < startDay; i++) {
        html += `<td></td>`;
    }

    for (let d = 1; d <= lastDate; d++) {
        const isToday = d === date;
        const className = isToday ? 'today' : '';
        html += `<td class="${className}">${d}</td>`;
        if ((d + startDay) % 7 === 0) html += `</tr><tr>`;
    }

    const totalCells = startDay + lastDate;
    const emptyCells = (7 - (totalCells % 7)) % 7;
    for (let i = 0; i < emptyCells; i++) {
        html += `<td></td>`;
    }

    html += `</tr></table>`;

    container.innerHTML = container.innerHTML + html;
}

setInterval(updateTime, 1000);
updateTime();
renderCalendar();
