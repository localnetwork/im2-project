-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Oct 19, 2023 at 12:32 PM
-- Server version: 5.7.29
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `drupal9`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`%` PROCEDURE `sp_deleteMediaById` (IN `media_id` INT)  SQL SECURITY INVOKER
BEGIN

DELETE FROM media WHERE mid = media_id;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_deleteStudent` (IN `studentId` INT)  SQL SECURITY INVOKER
BEGIN
    DECLARE student_count INT;

    SELECT COUNT(*) INTO student_count
    FROM students
    WHERE id = studentId;

    IF student_count > 0 THEN
        DELETE FROM students
        WHERE id = studentId;
        SELECT CONCAT('Student with ID ', studentId, ' deleted successfully.') AS result;
    ELSE
        SELECT 'Student not found. No deletion performed.' AS result;
    END IF;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_deleteStudentsToSubject` (IN `sub_id` INT)  SQL SECURITY INVOKER
BEGIN

DELETE FROM students_assigned_subjects WHERE subject_id = sub_id; 

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_deleteSubject` (IN `sub_id` INT)  SQL SECURITY INVOKER
BEGIN
    DECLARE subject_count INT;

    SELECT COUNT(*) INTO subject_count
    FROM subjects
    WHERE subject_id = sub_id;

    IF subject_count > 0 THEN
        DELETE FROM subjects
        WHERE subject_id = sub_id;
        SELECT CONCAT('Subject with ID ', sub_id, ' deleted successfully.') AS result;
    ELSE
        SELECT 'Subject not found. No deletion performed.' AS result;
    END IF;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getAssignment` (IN `ass_id` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * from assignments WHERE assignment_id = ass_id; 

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getAssignments` ()  SQL SECURITY INVOKER
BEGIN

SELECT * from assignments;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getInstructor` (IN `user_id` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * from users WHERE role = 2 AND id = user_id;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getInstructors` ()  SQL SECURITY INVOKER
BEGIN

SELECT * from users WHERE role = 2;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getLastMedia` ()  SQL SECURITY INVOKER
BEGIN


SELECT * FROM media ORDER BY mid DESC LIMIT 1;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getMediaById` (IN `media_id` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * from media WHERE mid = media_id;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getRole` (IN `user_role_id` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * from roles WHERE role_id = user_role_id;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getStudent` (IN `studentId` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * FROM students WHERE id = studentId;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getStudents` ()  SQL SECURITY INVOKER
BEGIN

SELECT * from students; 

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getStudentsInSubject` (IN `sub_id` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * from students_assigned_subjects WHERE subject_id = sub_id;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getSubject` (IN `sub_id` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * from subjects WHERE subject_id = sub_id; 

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getSubjects` ()  SQL SECURITY INVOKER
BEGIN

SELECT * from subjects; 

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getUserInfo` (IN `userEmail` VARCHAR(255))  SQL SECURITY INVOKER
BEGIN

SELECT * FROM users WHERE email = userEmail;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertAssignment` (IN `author_id` INT, IN `subject_id` INT, IN `assignment_title` VARCHAR(255), IN `ass_description` VARCHAR(255), IN `score` INT)  SQL SECURITY INVOKER
BEGIN
    INSERT INTO assignments (author, subject_id, title, assignment_description, total_score)
    VALUES (author_id, subject_id, assignment_title, ass_description, score);
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertMedia` (IN `file_name` VARCHAR(255), IN `uri` VARCHAR(500), IN `file_mime` VARCHAR(255), IN `author_id` INT)  SQL SECURITY INVOKER
BEGIN

DECLARE formatted_now VARCHAR(255);

INSERT INTO media(filename, uri, filemime, author)
VALUES (file_name, uri, file_mime, author_id);

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertStudent` (IN `first_name` VARCHAR(50), IN `last_name` VARCHAR(50))  SQL SECURITY INVOKER
BEGIN
    INSERT INTO students (first_name, last_name)    VALUES (first_name, last_name);
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertStudentsToSubject` (IN `sub_id` INT, IN `student_ids` VARCHAR(1000))  SQL SECURITY INVOKER
BEGIN
    DECLARE student_id INT;
    DECLARE studentList VARCHAR(1000);
    DECLARE commaPosition INT;
    DECLARE done INT DEFAULT 0;

    
    SET studentList = student_ids;
    SET commaPosition = LOCATE(',', studentList);

    WHILE commaPosition > 0 DO
        
        SET student_id = CAST(SUBSTRING(studentList, 1, commaPosition - 1) AS SIGNED);

        SELECT student_id AS student_id_value;

		INSERT INTO students_assigned_subjects (subject_id, student_id) VALUES (sub_id, student_id);

        SET studentList = SUBSTRING(studentList, commaPosition + 1);

        -- Find the next comma
        SET commaPosition = LOCATE(',', studentList);
    END WHILE;

    -- Process the last student_id (if any)
    IF LENGTH(studentList) > 0 THEN
        SET student_id = CAST(studentList AS SIGNED);
        SELECT student_id AS student_id_value;
		SELECT sub_id AS subject_id_value;
        
        INSERT INTO students_assigned_subjects (subject_id, student_id) VALUES (sub_id, student_id);
    END IF;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertSubject` (IN `author_id` INT, IN `subject_title` VARCHAR(255), IN `subject_description` VARCHAR(500), IN `instructor_id` INT)  SQL SECURITY INVOKER
BEGIN
    INSERT INTO subjects (author, title, description, instructor)
    VALUES (author_id, subject_title, subject_description, instructor_id);
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertUser` (IN `user_role_id` INT, IN `first_name` VARCHAR(255), IN `last_name` VARCHAR(255), IN `email` VARCHAR(255), IN `password` VARCHAR(255), IN `profile_picture` INT)  SQL SECURITY INVOKER
BEGIN
    DECLARE IsValidEmail BIT DEFAULT 0;
    
    
    IF email REGEXP '^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}$' THEN
        SET IsValidEmail = 1;
    END IF;

    IF IsValidEmail = 1 THEN
        
        INSERT INTO users (role, first_name, last_name, email, password, profile_picture) VALUES (user_role_id, first_name, last_name, email, password, profile_picture);
    ELSE
        
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid email address';
    END IF;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_updateAssignment` (IN `subject_id` INT(255), IN `ass_id` INT(255), IN `assignment_title` VARCHAR(255), IN `ass_description` VARCHAR(255), IN `score` INT)  SQL SECURITY INVOKER
BEGIN
    UPDATE assignments
	SET title = assignment_title, assignment_description = ass_description, total_score = score
    WHERE assignment_id = ass_id;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_updateStudent` (IN `studentId` INT, IN `first_name` VARCHAR(50), IN `last_name` VARCHAR(50))  SQL SECURITY INVOKER
BEGIN
    UPDATE students
	SET first_name = first_name, last_name = last_name
    WHERE id = studentId;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_updateSubject` (IN `sub_id` INT, IN `title` VARCHAR(255), IN `description` VARCHAR(500))  SQL SECURITY INVOKER
BEGIN
    UPDATE subjects
	SET title = title, description = description
    WHERE subject_id = sub_id;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_userLoginPost` (IN `p_email` VARCHAR(255), IN `p_password` VARCHAR(255))  SQL SECURITY INVOKER
BEGIN
    DECLARE v_user_id INT;
    DECLARE v_hashed_password VARCHAR(255);

    
    SELECT id, password INTO v_user_id, v_hashed_password
    FROM users
    WHERE email = p_email;

    
    IF v_user_id IS NOT NULL AND BINARY p_password = v_hashed_password THEN
        
        SELECT 'Login successful' AS result;
    ELSE
        
        SELECT 'Invalid email or password. Please try again.' AS result;
    END IF;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_userUpdate` (IN `user_email` VARCHAR(255), IN `first_name` VARCHAR(255), IN `last_name` VARCHAR(255), IN `profile_picture` VARCHAR(255))  SQL SECURITY INVOKER
BEGIN
    UPDATE users
    SET email = user_email, first_name = first_name, last_name = last_name, profile_picture = profile_picture
    WHERE email = user_email;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `assignment_description` varchar(500) NOT NULL,
  `total_score` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `author`, `subject_id`, `title`, `assignment_description`, `total_score`, `created`) VALUES
(1, 1, 7, 'sample title', 'asdsad', 50, '2023-10-18 15:59:46'),
(2, 1, 7, 'sample assignment', '1545555', 22, '2023-10-18 16:18:35'),
(3, 1, 7, 'test assss', 'test assss', 100, '2023-10-18 16:22:40');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `mid` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `filemime` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`mid`, `filename`, `uri`, `filemime`, `created`, `author`) VALUES
(6, '1697640252-unknown (53).png', '/storage/images/1697640252-unknown (53).png', 'png', '2023-10-18 14:44:12', 1),
(7, '1697640299-unknown_54_1 (1).png', '/storage/images/1697640299-unknown_54_1 (1).png', 'png', '2023-10-18 14:44:59', 1),
(8, '1697640302-unknown.png', '/storage/images/1697640302-unknown.png', 'png', '2023-10-18 14:45:02', 1),
(9, '1697641365-366903889_316698967390036_9172396626901161920_n.jpg', '/storage/images/1697641365-366903889_316698967390036_9172396626901161920_n.jpg', 'jpg', '2023-10-18 15:02:45', 1),
(10, '1697641890-unknown (53).png', '/storage/images/1697641890-unknown (53).png', 'png', '2023-10-18 15:11:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_title`) VALUES
(1, 'admin'),
(2, 'instructor');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`) VALUES
(26, 'john', 'doe'),
(31, 'Diome Nike', 'Potot');

-- --------------------------------------------------------

--
-- Table structure for table `students_assigned_subjects`
--

CREATE TABLE `students_assigned_subjects` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `author` int(11) NOT NULL,
  `instructor` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `title`, `description`, `author`, `instructor`) VALUES
(7, 'Math', 'lorem ipsum', 1, 3),
(8, 'English', 'lorem ipsum\r\n4', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` int(255) NOT NULL DEFAULT '1',
  `profile_picture` int(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created`, `role`, `profile_picture`, `status`) VALUES
(1, 'Diome Nike111', 'Potot', 'admin@admin.com', '$2y$10$HoEiiEcrKyEPOD/J3Z3cl.0serw6v2eZKMYqNRKfnhoPAByw5cVk.', '2023-10-18 06:37:53', 1, 10, 1),
(3, 'Danny', 'Obidas', 'danny@danny.com', '$2y$10$3ccVuo4hnnrwsO2wEF1aJOGOfdKlinR/rG3ib7V8.VCw4WYW1YCo.', '2023-10-18 13:38:27', 2, 6, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `fk_assignment_author` (`author`),
  ADD KEY `fk_assignment_subject` (`subject_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`mid`),
  ADD UNIQUE KEY `mid` (`mid`),
  ADD KEY `fk_media_author` (`author`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_assigned_subjects`
--
ALTER TABLE `students_assigned_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sas_student` (`student_id`),
  ADD KEY `fk_sas_subject_id` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `fk_subjects_author` (`author`),
  ADD KEY `fk_subjects_instructor` (`instructor`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `profile_picture` (`profile_picture`) USING BTREE,
  ADD KEY `email` (`email`) USING BTREE,
  ADD KEY `user_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `students_assigned_subjects`
--
ALTER TABLE `students_assigned_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `fk_assignment_author` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_assignment_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `fk_media_author` FOREIGN KEY (`author`) REFERENCES `users` (`id`);

--
-- Constraints for table `students_assigned_subjects`
--
ALTER TABLE `students_assigned_subjects`
  ADD CONSTRAINT `fk_sas_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `fk_sas_subject_id` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk_subjects_author` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_subjects_instructor` FOREIGN KEY (`instructor`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `profile_picture` FOREIGN KEY (`profile_picture`) REFERENCES `media` (`mid`),
  ADD CONSTRAINT `user_role` FOREIGN KEY (`role`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
