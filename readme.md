# Student Hub Portal

A student-focused web portal developed as part of **ITUE203 – Web Development Frameworks, Semester 3, AY 2026–27**. The project brings together frontend web development, PHP processing, MySQL database operations, student management, event management, asynchronous CRUD operations, and administrator dashboard functionality.

## 1. Project Overview

Student Hub provides a common interface for student-related information and event activities. The project is developed incrementally through practical assignments, with separate modules demonstrating specific web development concepts.

**Project name:** Student Hub Portal  
**Frontend:** HTML5, CSS3, JavaScript  
**Backend:** PHP  
**Database:** MySQL  
**Local server:** XAMPP (Apache and MySQL)  
**Database administration:** phpMyAdmin  
**Asynchronous operations:** JavaScript Fetch API

## 2. Main Website Pages

The original portal includes the following pages:

- Home
- About Us
- Register
- Login
- Dashboard
- Events
- Profile
- Contact
- FAQ
- Feedback

The pages use shared styling and JavaScript resources to maintain a consistent interface.

## 3. Project Features and Practical Modules

### Frontend and interface
- Semantic HTML pages and navigation.
- CSS-based layouts and styling.
- JavaScript form validation and interactive behaviour.
- JSON-based event and FAQ data.
- CSV-based registration practical.

### User registration and authentication
- PHP form processing and database-backed registration modules.
- Password hashing and verification in the relevant authentication modules.
- Session-based login and logout.
- Role-related dashboard access and session handling.

### Student management
- Add and view student records.
- Search and filter records.
- Edit student details.
- Soft-delete functionality.
- Export student lists to CSV.

### Event management
- Create, view, edit and delete events.
- Upload event posters.
- Validate poster file types and file sizes.
- Store event information in MySQL.

### Fetch API CRUD
- Retrieve event records from a PHP JSON endpoint.
- Create, update and delete event records.
- Search, filter and sort events in the standalone practical interface.
- Perform asynchronous requests using the Fetch API.

### Administrator dashboard
- Administrator and student dashboard modules.
- Role-related navigation.
- Audit-log functionality in the Practical 14 module.

**Note:** The modules are maintained in separate folders. Verify their database connections, authentication and end-to-end integration before describing a feature as fully tested.

## 4. Project Folder Structure

```text
Student_Hub/
├── Home.html
├── AboutUs.html
├── Contact.html
├── Dashboard.html
├── Events.html
├── FAQ.html
├── Feedback.html
├── Login.html
├── Register.html
├── Profile.html
├── style.css
├── style2.css
├── script.js
├── data/
│   ├── events.json
│   ├── faqs.json
│   └── students.json
├── js/
│   └── events.js
├── practical7/
│   ├── Register.html
│   ├── process.php
│   └── data.csv
├── practical8/
│   ├── db.php
│   ├── schema.sql
│   └── test_connection.php
├── practical10/
│   ├── login.php
│   ├── authenticate.php
│   ├── dashboard.php
│   ├── admin_dashboard.php
│   ├── student_dashboard.php
│   └── logout.php
├── practical11_student_management/
├── events/
├── event-management/
├── Practical13_FetchCRUD/
└── practical14/
```

The structure above highlights the main files and modules. The complete source archive contains additional pages, stylesheets, assets, configuration files and supporting scripts.

## 5. Software Requirements

- Windows or another supported operating system.
- XAMPP with Apache, PHP and MySQL/MariaDB.
- A web browser.
- phpMyAdmin for database administration.
- A code editor such as Visual Studio Code.
- Git for source control (optional for local execution).

## 6. Local Installation and Deployment

1. Install XAMPP.
2. Copy the project folder to the XAMPP web root:

   `C:\xampp\htdocs\Student_Hub`

3. Start Apache and MySQL from the XAMPP Control Panel.
4. Open phpMyAdmin at:

   `http://localhost/phpmyadmin/`

5. Import the supplied database dump, `studenthub.sql`, into the MySQL server when the dump is available. It contains the database definitions and records included in that export.
6. Check each module's database connection file and ensure the configured database names, table names and credentials match the imported schema.
7. Do not import a module's schema over an existing database without first checking whether its table definitions conflict with the existing database.
8. Open the main portal:

   `http://localhost/Student_Hub/Home.html`

9. Open the individual practical URLs listed below to test their standalone functionality.

## 7. Practical Module URLs

With the project located in `C:\xampp\htdocs\Student_Hub`, the module URLs are:

| Module | Local URL |
|---|---|
| Main website | `http://localhost/Student_Hub/Home.html` |
| Practical 7 registration | `http://localhost/Student_Hub/practical7/Register.html` |
| Practical 10 login | `http://localhost/Student_Hub/practical10/login.php` |
| Student management | `http://localhost/Student_Hub/practical11_student_management/index.php` |
| Event management | `http://localhost/Student_Hub/events/login.php` |
| Practical 13 Fetch CRUD | `http://localhost/Student_Hub/Practical13_FetchCRUD/index.html` |
| Practical 14 login | `http://localhost/Student_Hub/practical14/login.php` |

These are entry points, not a guarantee that every module is currently operational. Complete the database setup and authentication checks required by each module before demonstration.

## 8. Database Configuration

The project uses multiple databases for separate practical modules.

| Database | Purpose |
|---|---|
| `practical8` | User, student, event and registration tables |
| `practical11` | Student management |
| `event_db` | Event management and administrator records |
| `practical13_events_db` | Fetch API event CRUD |
| `practical14_admin_db` | Administrator dashboard and audit logs |

The `student` and `test` databases may also exist in the local MySQL server. Include them in the submitted dump only if they are required by the final project.

Database credentials should be configured locally and must not be published in the repository. The submitted SQL dump should be checked for sensitive or personal information before sharing.

## 9. Testing

Test the following workflows and record the actual outcome in the accompanying Test and Security Report:

- Main website navigation and page loading.
- Registration form validation.
- Successful login and rejection of invalid credentials.
- Session logout and access restrictions.
- Student creation, search, editing and soft deletion.
- Event creation, editing and deletion.
- Poster upload validation.
- Fetch API CRUD operations.
- Administrator dashboard and audit logs.
- Database connectivity and error handling.
- Layout and navigation on desktop and mobile widths.

Attach screenshots as evidence of the tests performed. Record failures or untested functionality accurately.

## 10. Security and Accessibility

The relevant modules include security-related techniques such as password hashing, prepared database statements, session handling, role checks and upload validation. Their correct operation must be verified during testing.

The accessibility review should cover form labels, alternative text for images, keyboard navigation, heading structure, readable contrast and responsive layouts.

Do not treat the presence of a security-related function as proof that the complete application is secure.

## 11. Source Control and GitHub

**GitHub repository:** [Insert the actual repository URL]

The repository should contain the latest project source code, README, required configuration examples and relevant SQL schema files.

Before submission:
- Commit the final source changes.
- Push the latest commit to GitHub.
- Confirm that the repository URL opens.
- Exclude passwords, private database exports, unnecessary backup files and other sensitive information.

## 12. Submission Deliverables

The Practical 15 submission package should contain:

1. GitHub repository URL.
2. `studenthub.sql` database dump.
3. `README.md` setup and testing instructions.
4. Test and Security Report in PDF format.
5. Screenshots demonstrating the tested project.
6. A clean source-code ZIP archive.

## 13. Conclusion

Student Hub is a modular web development project that combines a student-facing website with PHP, MySQL, student management, event management, Fetch API operations and administrator functionality.

The final integration and deployment status should be established through documented tests performed in the local XAMPP environment.
