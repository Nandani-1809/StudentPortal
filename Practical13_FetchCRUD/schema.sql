
CREATE DATABASE IF NOT EXISTS practical13_events_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE practical13_events_db;

CREATE TABLE IF NOT EXISTS events (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    event_date DATE NOT NULL,
    venue VARCHAR(150) NOT NULL,
    category VARCHAR(60) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_events_date (event_date),
    INDEX idx_events_category (category)
);

INSERT INTO events (name, event_date, venue, category)
VALUES
('Hackathon 2026', '2026-10-07', 'CSPIT Auditorium', 'Hackathon'),
('Web Development Workshop', '2026-10-12', 'A7 Building', 'Workshop'),
('Sports Meet 2026', '2026-10-15', 'University Ground', 'Sports'),
('AI and Machine Learning Seminar', '2026-10-18', 'CSPIT Seminar Hall', 'Seminar'),
('Cyber Security Awareness', '2026-10-20', 'A3 Building', 'Seminar'),
('Coding Contest', '2026-10-22', 'Computer Lab 3', 'Competition'),
('C++ Programming Workshop', '2026-10-25', 'Computer Lab 1', 'Workshop'),
('Entrepreneurship Talk', '2026-10-27', 'Main Auditorium', 'Seminar'),
('Photography Competition', '2026-10-29', 'Student Activity Center', 'Competition'),
('Tech Quiz', '2026-11-02', 'A5 Building', 'Competition'),
('Cloud Computing Workshop', '2026-11-05', 'Computer Lab 2', 'Workshop'),
('Annual Cultural Fest', '2026-11-10', 'University Ground', 'Cultural'),
('Cyber Security Hackathon', '2026-11-15', 'CSPIT Auditorium', 'Hackathon'),
('Career Guidance Session', '2026-11-18', 'Seminar Hall', 'Career'),
('Git and GitHub Workshop', '2026-11-22', 'Computer Lab 4', 'Workshop');
