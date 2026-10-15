CREATE DATABASE IF NOT EXISTS student_events;
USE student_events;

DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS students;

CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    enrollment_no VARCHAR(20) NOT NULL UNIQUE,
    student_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    course VARCHAR(50) NOT NULL,
    year INT NOT NULL
);

CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    venue VARCHAR(100) NOT NULL
);

CREATE TABLE registrations (
    registration_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    event_id INT NOT NULL,
    registration_date DATE NOT NULL,

    CONSTRAINT fk_registration_student
        FOREIGN KEY (student_id)
        REFERENCES students(student_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_registration_event
        FOREIGN KEY (event_id)
        REFERENCES events(event_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT unique_student_event
        UNIQUE (student_id, event_id)
);

INSERT INTO students
(enrollment_no, student_name, email, course, year)
VALUES
('25CS073', 'Nandani Patel', 'nandani@example.com', 'CSE', 2),
('25CS074', 'Aadya Shah', 'aadya@example.com', 'CSE', 2),
('25CS075', 'Seena Patel', 'seena@example.com', 'CSE', 2);

INSERT INTO events
(event_name, event_date, venue)
VALUES
('Tech Fest 2026', '2026-10-15', 'A7 Building'),
('Cyber Security Workshop', '2026-10-20', 'CSPIT Lab'),
('AI Seminar', '2026-10-25', 'Seminar Hall');

INSERT INTO registrations
(student_id, event_id, registration_date)
VALUES
(1, 1, '2026-10-07'),
(1, 2, '2026-10-07'),
(2, 1, '2026-10-07'),
(3, 3, '2026-10-07');