-- Practical 11: Student Management CRUD with Search and Filter
-- Import this file in phpMyAdmin. It creates a separate database so earlier
-- practicals and their tables are not modified.

CREATE DATABASE IF NOT EXISTS practical11 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE practical11;

CREATE TABLE IF NOT EXISTS students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    enrollment VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    dob DATE NULL,
    gender VARCHAR(30) NULL,
    course VARCHAR(100) NOT NULL,
    `year` TINYINT UNSIGNED NOT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Seed 20 fictional test records only when the table is empty.
-- Check emptiness before running INSERT so re-importing this SQL won't add duplicates.
SET @student_seed_empty = ((SELECT COUNT(*) FROM students) = 0);
INSERT INTO students (first_name, last_name, enrollment, email, dob, gender, course, `year`, status)
SELECT * FROM (
    SELECT 'Aarav' AS first_name, 'Shah' AS last_name, 'P11CS001' AS enrollment, 'aarav.shah01@example.com' AS email, '2006-01-14' AS dob, 'Male' AS gender, 'Computer Science' AS course, 2 AS `year`, 'active' AS status
    UNION ALL SELECT 'Asha', 'Patel', 'P11CS002', 'asha.patel02@example.com', '2005-08-22', 'Female', 'Computer Science', 2, 'active'
    UNION ALL SELECT 'Vivaan', 'Mehta', 'P11IT003', 'vivaan.mehta03@example.com', '2006-03-10', 'Male', 'Information Technology', 1, 'active'
    UNION ALL SELECT 'Diya', 'Desai', 'P11CE004', 'diya.desai04@example.com', '2005-12-01', 'Female', 'Computer Engineering', 2, 'active'
    UNION ALL SELECT 'Arjun', 'Trivedi', 'P11ME005', 'arjun.trivedi05@example.com', '2004-09-18', 'Male', 'Mechanical Engineering', 3, 'active'
    UNION ALL SELECT 'Anaya', 'Joshi', 'P11EE006', 'anaya.joshi06@example.com', '2005-05-16', 'Female', 'Electrical Engineering', 2, 'active'
    UNION ALL SELECT 'Reyansh', 'Dave', 'P11CS007', 'reyansh.dave07@example.com', '2006-02-07', 'Male', 'Computer Science', 1, 'active'
    UNION ALL SELECT 'Ira', 'Pandya', 'P11IT008', 'ira.pandya08@example.com', '2005-11-28', 'Female', 'Information Technology', 2, 'active'
    UNION ALL SELECT 'Kabir', 'Rao', 'P11CE009', 'kabir.rao09@example.com', '2004-07-19', 'Male', 'Computer Engineering', 3, 'active'
    UNION ALL SELECT 'Myra', 'Kapoor', 'P11ME010', 'myra.kapoor10@example.com', '2006-04-25', 'Female', 'Mechanical Engineering', 1, 'active'
    UNION ALL SELECT 'Advik', 'Nair', 'P11EE011', 'advik.nair11@example.com', '2005-06-30', 'Male', 'Electrical Engineering', 2, 'active'
    UNION ALL SELECT 'Sara', 'Mistry', 'P11CS012', 'sara.mistry12@example.com', '2004-10-11', 'Female', 'Computer Science', 3, 'active'
    UNION ALL SELECT 'Krish', 'Solanki', 'P11IT013', 'krish.solanki13@example.com', '2006-01-09', 'Male', 'Information Technology', 1, 'active'
    UNION ALL SELECT 'Kiara', 'Bhatt', 'P11CE014', 'kiara.bhatt14@example.com', '2005-02-20', 'Female', 'Computer Engineering', 2, 'active'
    UNION ALL SELECT 'Dhruv', 'Gandhi', 'P11ME015', 'dhruv.gandhi15@example.com', '2004-12-15', 'Male', 'Mechanical Engineering', 3, 'active'
    UNION ALL SELECT 'Navya', 'Thakkar', 'P11EE016', 'navya.thakkar16@example.com', '2006-07-06', 'Female', 'Electrical Engineering', 1, 'active'
    UNION ALL SELECT 'Rudra', 'Parekh', 'P11CS017', 'rudra.parekh17@example.com', '2005-04-02', 'Male', 'Computer Science', 2, 'active'
    UNION ALL SELECT 'Pari', 'Shukla', 'P11IT018', 'pari.shukla18@example.com', '2004-08-13', 'Female', 'Information Technology', 3, 'active'
    UNION ALL SELECT 'Yuvaan', 'Soni', 'P11CE019', 'yuvaan.soni19@example.com', '2006-09-21', 'Male', 'Computer Engineering', 1, 'active'
    UNION ALL SELECT 'Saanvi', 'Pathak', 'P11CS020', 'saanvi.pathak20@example.com', '2005-03-27', 'Female', 'Computer Science', 2, 'active'
) AS seed
WHERE @student_seed_empty = 1;
