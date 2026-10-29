/* Optional homepage preview: uses the same PHP API but keeps the homepage read-only. */
(() => {
    "use strict";

    document.addEventListener("DOMContentLoaded", loadUpcomingEvents);

    async function loadUpcomingEvents() {
        const headings = Array.from(document.querySelectorAll("h2"));
        const heading = headings.find(item => item.textContent.trim().toLowerCase() === "upcoming events");
        const section = heading?.closest("section");
        const table = section?.querySelector("table");
        if (!table) return;

        try {
            const response = await fetch("api.php", { cache: "no-store" });
            const payload = await response.json();
            if (!response.ok || !payload.success || !Array.isArray(payload.data)) {
                throw new Error(payload.message || "Could not read event records.");
            }

            const now = new Date();
            const today = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, "0")}-${String(now.getDate()).padStart(2, "0")}`;
            const upcoming = payload.data
                .filter(event => String(event.date) >= today)
                .sort((a, b) => String(a.date).localeCompare(String(b.date)))
                .slice(0, 3);

            const body = table.tBodies[0] || table.createTBody();
            // The user's original table has its headings in the first row. Keep that row, then replace the data rows.
            const firstRow = body.rows.length ? body.rows[0] : null;
            const headingIsInBody = firstRow && Array.from(firstRow.cells).some(cell => /event/i.test(cell.textContent.trim()))
                && Array.from(firstRow.cells).some(cell => /date/i.test(cell.textContent.trim()));
            while (body.rows.length > 0) {
                if (headingIsInBody && body.rows.length === 1) break;
                body.deleteRow(headingIsInBody ? 1 : 0);
            }

            if (upcoming.length === 0) {
                const row = body.insertRow();
                const cell = row.insertCell();
                cell.colSpan = 3;
                cell.textContent = "No upcoming events are currently listed.";
                return;
            }

            upcoming.forEach(event => {
                const row = body.insertRow();
                const name = row.insertCell();
                const date = row.insertCell();
                const venue = row.insertCell();
                name.textContent = event.name;
                const parsed = new Date(`${event.date}T00:00:00`);
                date.textContent = Number.isNaN(parsed.getTime()) ? event.date : parsed.toLocaleDateString(undefined, { day: "numeric", month: "long" });
                venue.textContent = event.venue;
            });
        } catch (error) {
            console.error("Home page upcoming-events preview:", error);
            // Keep the original static homepage preview visible when the PHP API is unavailable.
        }
    }
})();
