(() => {
    "use strict";

    const API_URL = "api.php"; // Events.html and api.php should be in the same folder.
    const PAGE_SIZE = 8;

    let allEvents = [];
    let currentPage = 1;
    let editingId = null;

    document.addEventListener("DOMContentLoaded", initialise);

    function initialise() {
        const tableBody = document.getElementById("eventsTableBody");
        const table = tableBody ? tableBody.closest("table") : null;

        if (!tableBody || !table) {
            console.error("Practical 13: Could not find #eventsTableBody inside a table.");
            return;
        }

        const searchInput = document.getElementById("searchEvent");
        const categorySelect = document.getElementById("categoryFilter");
        const sortSelect = document.getElementById("sortEvent");
        let pagination = document.getElementById("pagination");

        if (!pagination) {
            pagination = document.createElement("div");
            pagination.id = "pagination";
            pagination.className = "crud-pagination";
            table.insertAdjacentElement("afterend", pagination);
        }

        const tableHeaderRow = table.querySelector("thead tr") || table.querySelector("tr");
        if (tableHeaderRow && !Array.from(tableHeaderRow.cells).some(cell => cell.textContent.trim().toLowerCase() === "actions")) {
            const actionHeader = document.createElement("th");
            actionHeader.scope = "col";
            actionHeader.textContent = "Actions";
            tableHeaderRow.appendChild(actionHeader);
        }

        const status = document.createElement("p");
        status.className = "crud-status";
        status.setAttribute("role", "status");
        status.setAttribute("aria-live", "polite");

        const panel = document.createElement("section");
        panel.className = "crud-form-panel";
        panel.innerHTML = `
            <h2 id="eventFormHeading">Add a New Event</h2>
            <p class="crud-intro">Add, view, edit, and delete event records stored in MySQL.</p>
            <form id="eventCrudForm" class="event-form-grid">
                <input type="hidden" id="crudEventId" name="id">
                <label>Event name
                    <input type="text" id="crudEventName" name="name" maxlength="150" required placeholder="e.g. Coding Contest">
                </label>
                <label>Date
                    <input type="date" id="crudEventDate" name="date" required>
                </label>
                <label>Venue
                    <input type="text" id="crudEventVenue" name="venue" maxlength="150" required placeholder="e.g. Computer Lab 2">
                </label>
                <label>Category
                    <input type="text" id="crudEventCategory" name="category" maxlength="60" list="crudCategories" required placeholder="e.g. Workshop">
                    <datalist id="crudCategories">
                        <option value="Hackathon"></option><option value="Workshop"></option>
                        <option value="Sports"></option><option value="Seminar"></option>
                        <option value="Competition"></option><option value="Cultural"></option>
                        <option value="Career"></option>
                    </datalist>
                </label>
                <div class="crud-form-buttons">
                    <button type="submit" id="saveEventButton" class="crud-button crud-primary">Add Event</button>
                    <button type="button" id="cancelEditButton" class="crud-button crud-secondary" hidden>Cancel Edit</button>
                </div>
            </form>
        `;
        const eventForm = panel.querySelector("#eventCrudForm");
        const formHeading = panel.querySelector("#eventFormHeading");
        const idInput = panel.querySelector("#crudEventId");
        const nameInput = panel.querySelector("#crudEventName");
        const dateInput = panel.querySelector("#crudEventDate");
        const venueInput = panel.querySelector("#crudEventVenue");
        const categoryInput = panel.querySelector("#crudEventCategory");
        const saveButton = panel.querySelector("#saveEventButton");
        const cancelButton = panel.querySelector("#cancelEditButton");
        panel.appendChild(status);
        table.insertAdjacentElement("beforebegin", panel);

        function setStatus(message, kind = "info") {
            status.textContent = message;
            status.dataset.kind = kind;
        }

        function resetForm() {
            editingId = null;
            eventForm.reset();
            idInput.value = "";
            formHeading.textContent = "Add a New Event";
            saveButton.textContent = "Add Event";
            cancelButton.hidden = true;
        }

        async function request(url, options = {}) {
            const response = await fetch(url, {
                cache: "no-store",
                ...options,
                headers: {
                    ...(options.body ? { "Content-Type": "application/json" } : {}),
                    ...(options.headers || {})
                }
            });
            let payload;
            try {
                payload = await response.json();
            } catch (_error) {
                throw new Error("The server did not return JSON. Check that you opened the page through XAMPP and that api.php has no PHP errors.");
            }
            if (!response.ok || !payload.success) {
                throw new Error(payload.message || `Request failed (${response.status}).`);
            }
            return payload;
        }

        async function loadEvents(showMessage = false) {
            tableBody.replaceChildren();
            const loadingRow = document.createElement("tr");
            const loadingCell = document.createElement("td");
            loadingCell.colSpan = Math.max(5, tableHeaderRow ? tableHeaderRow.cells.length : 5);
            loadingCell.textContent = "Loading events from the database...";
            loadingRow.appendChild(loadingCell);
            tableBody.appendChild(loadingRow);

            try {
                const payload = await request(API_URL);
                allEvents = Array.isArray(payload.data) ? payload.data : [];
                updateCategoryOptions();
                currentPage = 1;
                renderEvents();
                if (showMessage) setStatus(payload.message || "Events refreshed from MySQL.", "success");
                else setStatus(`${allEvents.length} event record(s) loaded from MySQL.`, "success");
            } catch (error) {
                allEvents = [];
                renderMessageRow("Could not load events. " + error.message);
                setStatus("Connection failed. Start Apache and MySQL in XAMPP, then import schema.sql in phpMyAdmin.", "error");
                console.error(error);
            }
        }

        function updateCategoryOptions() {
            if (!categorySelect) return;
            const previousValue = categorySelect.value;
            const firstText = categorySelect.options[0]?.textContent.trim() || "All Categories";
            categorySelect.replaceChildren(new Option(firstText, ""));
            const categories = [...new Set(allEvents.map(event => String(event.category || "").trim()).filter(Boolean))]
                .sort((a, b) => a.localeCompare(b));
            categories.forEach(category => categorySelect.add(new Option(category, category)));
            if (categories.includes(previousValue)) categorySelect.value = previousValue;
        }

        function filteredAndSortedEvents() {
            const query = (searchInput?.value || "").trim().toLowerCase();
            const selectedCategory = categorySelect?.value || "";
            const sortValue = (sortSelect?.value || "date-asc").toLowerCase();

            const visibleEvents = allEvents.filter(event => {
                const matchesText = [event.name, event.venue, event.category, event.date]
                    .some(value => String(value ?? "").toLowerCase().includes(query));
                const matchesCategory = !selectedCategory || selectedCategory.toLowerCase() === "all" || event.category === selectedCategory;
                return matchesText && matchesCategory;
            });

            visibleEvents.sort((a, b) => {
                if (sortValue.includes("name") || sortValue.includes("event")) {
                    const result = String(a.name).localeCompare(String(b.name));
                    return sortValue.includes("desc") ? -result : result;
                }
                const result = String(a.date).localeCompare(String(b.date));
                return sortValue.includes("desc") ? -result : result;
            });
            return visibleEvents;
        }

        function renderMessageRow(message) {
            tableBody.replaceChildren();
            const row = document.createElement("tr");
            const cell = document.createElement("td");
            cell.colSpan = Math.max(5, tableHeaderRow ? tableHeaderRow.cells.length : 5);
            cell.className = "crud-empty-cell";
            cell.textContent = message;
            row.appendChild(cell);
            tableBody.appendChild(row);
            if (pagination) pagination.replaceChildren();
        }

        function formatDate(value) {
            if (!value) return "";
            const parsed = new Date(`${value}T00:00:00`);
            return Number.isNaN(parsed.getTime()) ? value : parsed.toLocaleDateString(undefined, {
                day: "2-digit", month: "short", year: "numeric"
            });
        }

        function makeButton(label, className, handler, accessibleLabel) {
            const button = document.createElement("button");
            button.type = "button";
            button.textContent = label;
            button.className = `crud-button ${className}`;
            button.setAttribute("aria-label", accessibleLabel);
            button.addEventListener("click", handler);
            return button;
        }

        function renderEvents() {
            const matches = filteredAndSortedEvents();
            const pageCount = Math.max(1, Math.ceil(matches.length / PAGE_SIZE));
            currentPage = Math.min(currentPage, pageCount);
            const startIndex = (currentPage - 1) * PAGE_SIZE;
            const pageEvents = matches.slice(startIndex, startIndex + PAGE_SIZE);
            tableBody.replaceChildren();

            if (pageEvents.length === 0) {
                renderMessageRow("No events match your search or category filter.");
            } else {
                pageEvents.forEach(event => {
                    const row = document.createElement("tr");
                    [event.name, formatDate(event.date), event.venue, event.category].forEach(value => {
                        const cell = document.createElement("td");
                        cell.textContent = String(value ?? "");
                        row.appendChild(cell);
                    });

                    const actionCell = document.createElement("td");
                    actionCell.className = "crud-action-cell";
                    const editButton = makeButton("Edit", "crud-edit", () => startEdit(event), `Edit ${event.name}`);
                    const deleteButton = makeButton("Delete", "crud-delete", () => deleteEvent(event), `Delete ${event.name}`);
                    actionCell.append(editButton, deleteButton);
                    row.appendChild(actionCell);
                    tableBody.appendChild(row);
                });
            }

            renderPagination(matches.length, pageCount);
        }

        function renderPagination(total, pageCount) {
            if (!pagination) return;
            pagination.replaceChildren();
            if (total <= PAGE_SIZE) return;

            const info = document.createElement("span");
            info.className = "crud-page-info";
            info.textContent = `Page ${currentPage} of ${pageCount}`;
            const previous = makeButton("← Previous", "crud-secondary", () => {
                if (currentPage > 1) { currentPage--; renderEvents(); }
            }, "Previous page");
            const next = makeButton("Next →", "crud-secondary", () => {
                if (currentPage < pageCount) { currentPage++; renderEvents(); }
            }, "Next page");
            previous.disabled = currentPage === 1;
            next.disabled = currentPage === pageCount;
            pagination.append(previous, info, next);
        }

        function startEdit(event) {
            editingId = Number(event.id);
            idInput.value = String(event.id);
            nameInput.value = event.name || "";
            dateInput.value = event.date || "";
            venueInput.value = event.venue || "";
            categoryInput.value = event.category || "";
            formHeading.textContent = "Edit Event";
            saveButton.textContent = "Save Changes";
            cancelButton.hidden = false;
            nameInput.focus();
            setStatus(`Editing event #${event.id}. Update the fields and select Save Changes.`, "info");
            panel.scrollIntoView({ behavior: "smooth", block: "start" });
        }

        async function deleteEvent(event) {
            if (!window.confirm(`Delete "${event.name}"? This cannot be undone.`)) return;
            try {
                const payload = await request(API_URL, {
                    method: "POST",
                    body: JSON.stringify({ action: "delete", id: Number(event.id) })
                });
                setStatus(payload.message || "Event deleted successfully.", "success");
                await loadEvents();
            } catch (error) {
                setStatus(error.message, "error");
            }
        }

        eventForm.addEventListener("submit", async event => {
            event.preventDefault();
            if (!eventForm.reportValidity()) return;

            const record = {
                name: nameInput.value.trim(),
                date: dateInput.value,
                venue: venueInput.value.trim(),
                category: categoryInput.value.trim()
            };
            if (editingId !== null) record.id = editingId;

            saveButton.disabled = true;
            saveButton.textContent = editingId === null ? "Adding..." : "Saving...";
            try {
                const payload = await request(API_URL, {
                    method: "POST",
                    body: JSON.stringify({ action: editingId === null ? "create" : "update", ...record })
                });
                resetForm();
                setStatus(payload.message || "Event saved successfully.", "success");
                await loadEvents();
            } catch (error) {
                setStatus(error.message, "error");
                saveButton.textContent = editingId === null ? "Add Event" : "Save Changes";
            } finally {
                saveButton.disabled = false;
            }
        });

        cancelButton.addEventListener("click", resetForm);
        if (searchInput) searchInput.addEventListener("input", () => { currentPage = 1; renderEvents(); });
        if (categorySelect) categorySelect.addEventListener("change", () => { currentPage = 1; renderEvents(); });
        if (sortSelect) sortSelect.addEventListener("change", () => { currentPage = 1; renderEvents(); });

        loadEvents();
    }
})();
