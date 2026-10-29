PRACTICAL 11 — STUDENT MANAGEMENT CRUD WITH SEARCH AND FILTER

FILES
- db.php: MySQLi database connection (database name: practical11)
- index.php: add/view/search/filter students; soft-delete confirmation
- edit.php: edit/update student details
- delete.php: marks a student inactive (does not permanently delete)
- export.php: exports the filtered student list as Excel-compatible CSV
- style.css: page styling
- student_management.sql: database/table and 20 fictional seed records

SETUP IN XAMPP
1. Start Apache and MySQL in XAMPP Control Panel.
2. Copy this entire practical11_student_management folder to C:\xampp\htdocs\
3. Open http://localhost/phpmyadmin/
4. Select Import, choose student_management.sql, then click Import/Go.
5. Open http://localhost/practical11_student_management/index.php

DATABASE NOTE
This project uses a separate practical11 database so it does not alter the database
used in Practical 7–10. If your MySQL root account has a password, update db.php.

TEST
- Add a student using a new enrollment number and email.
- Edit a record.
- Search using a name, email, or course.
- Filter by course and optionally by Active/Inactive status.
- Click Delete and accept the confirmation. Check that the status becomes Inactive.
- Click Export CSV and open the downloaded file in Excel.

SECURITY/BEHAVIOUR
Database reads/writes use MySQLi prepared statements. Soft delete uses POST and sets
status='inactive'. CSV export honours the current search, course and status filters.
