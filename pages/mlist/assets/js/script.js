// assets/javascript/script.js

document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ Script loaded successfully");

    // Example dynamic calendar
    const today = new Date();
    const calendar = document.getElementById('calendar-box');
    if (calendar) {
        calendar.innerHTML = `<strong>Today is:</strong> ${today.toDateString()}`;
    }
});
