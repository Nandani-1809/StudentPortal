STUDENT HUB PORTAL - PRACTICAL 13

Files:
- db.php: MySQLi database connection for the standalone practical. If merging into a portal that already uses db.php, keep both connections separate; see INTEGRATION_NOTES.txt.
- api.php: JSON endpoint. GET reads events; POST actions create/update/delete records.
- schema.sql: creates database/table and seeds the 15 event rows provided by you.
- index.html: standalone practical test page with search, filter, sort and CRUD.
- script.js: Fetch API front-end for the standalone index.html.
- js/events-crud.js: integration script for your existing Events.html page.
- js/home-events.js: optional read-only Upcoming Events preview for Home.html.
- practical13.css: styling for this practical's form and table.
- INTEGRATION_NOTES.txt: setup and instructions for your existing portal.

Quick start: copy folder to C:\\xampp\\htdocs\\, start Apache and MySQL, import schema.sql through phpMyAdmin, then open http://localhost/Practical13_FetchCRUD/index.html.
