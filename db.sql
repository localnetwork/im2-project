-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Oct 15, 2023 at 12:31 PM
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
CREATE DEFINER=`root`@`%` PROCEDURE `sp_deleteStudent` (IN `studentId` INT)  BEGIN
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

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getLastMedia` ()  BEGIN


SELECT * FROM media ORDER BY mid DESC LIMIT 1;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getMediaById` (IN `media_id` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * from media WHERE mid = media_id;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getStudent` (IN `studentId` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * FROM students WHERE id = studentId;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getStudents` ()  BEGIN

SELECT * from students; 

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getUserInfo` (IN `userEmail` VARCHAR(255))  SQL SECURITY INVOKER
BEGIN

SELECT * FROM users WHERE email = userEmail;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertMedia` (IN `file_name` VARCHAR(255), IN `uri` VARCHAR(500), IN `file_mime` VARCHAR(255))  BEGIN

DECLARE formatted_now VARCHAR(255);

INSERT INTO media(filename, uri, filemime)
VALUES (file_name, uri, file_mime);

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertStudent` (IN `first_name` VARCHAR(50), IN `last_name` VARCHAR(50))  SQL SECURITY INVOKER
BEGIN
    INSERT INTO students (first_name, last_name)    VALUES (first_name, last_name);
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertUser` (IN `first_name` VARCHAR(255), IN `last_name` VARCHAR(255), IN `email` VARCHAR(255), IN `password` VARCHAR(255), IN `profile_picture` INT)  SQL SECURITY INVOKER
BEGIN
    DECLARE IsValidEmail BIT DEFAULT 0;
    
    
    IF email REGEXP '^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}$' THEN
        SET IsValidEmail = 1;
    END IF;

    IF IsValidEmail = 1 THEN
        
        INSERT INTO users (first_name, last_name, email, password, profile_picture) VALUES (first_name, last_name, email, password, profile_picture);
    ELSE
        
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid email address';
    END IF;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_updateStudent` (IN `studentId` INT, IN `first_name` VARCHAR(50), IN `last_name` VARCHAR(50))  SQL SECURITY INVOKER
BEGIN
    UPDATE students
	SET first_name = first_name, last_name = last_name
    WHERE id = studentId;
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

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `mid` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `filemime` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`mid`, `filename`, `uri`, `filemime`, `created`) VALUES
(1, '1697372181-unknown (53).png', '/storage/images/1697372181-unknown (53).png', 'png', '2023-10-15 12:16:21'),
(2, '1697372214-unknown (53).png', '/storage/images/1697372214-unknown (53).png', 'png', '2023-10-15 12:16:54'),
(3, '1697372930-unknown (53).png', '/storage/images/1697372930-unknown (53).png', 'png', '2023-10-15 12:28:50'),
(4, '1697372984-15780688_1369878763054545_4385314309442176537_n-cropped.jpg', '/storage/images/1697372984-15780688_1369878763054545_4385314309442176537_n-cropped.jpg', 'jpg', '2023-10-15 12:29:44');

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
(20, 'dion', 'halcyon'),
(21, 'Diome Nike', 'asdsda'),
(22, 'Diome Nike', 'test'),
(24, 'dion saddsa', 'halcyon'),
(25, 'aaasdasd', 'asdasd'),
(26, 'john', 'doe'),
(27, 'john ', 'test'),
(28, 'dion', 'halcyontntn'),
(29, 'john', 'ssss'),
(30, 'diooddd', 'nikeee');

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
  `profile_picture` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created`, `role`, `profile_picture`) VALUES
(60, 'Diome Nike', 'Potot', 'diome.halcyonwebdesign@gmail.com', '$2y$10$riIQFh2UWfyqH7.ze6XTfuL7opbHzJ7n9iYD04SVGuzwDiMj2zXhO', '2023-10-15 11:43:56', 1, NULL),
(69, 'Diome Nike', 'Potot', 'd@d.com', '$2y$10$3O2Rrc/2texiZTPsgNU3Wu5F7lP2UP10MDtohMj9DXsR9C8vhHzJO', '2023-10-15 12:16:21', 1, NULL),
(70, 'dion', 'halcyon', 'a@a.com', '$2y$10$QhWIMwp0sQ2uRV9xoWnf7.miwxBl0QFs0EIvxSSNH6b3v03UDbxzq', '2023-10-15 12:16:54', 1, 1),
(71, 'User', 'One', 'user1@user.com', '$2y$10$wU0PAsFZam2/FUiAjo5xHuRfiHQQPcXPDdDv6zHKen3CWwktXUckO', '2023-10-15 12:28:50', 1, 2),
(72, 'User', 'Two', 'user2@user.com', '$2y$10$cc6Mm0yAiyUv76yjVH9dh.HvMmx/04Oc0MlJfPexmuOjrPhfqCUYG', '2023-10-15 12:29:44', 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`mid`),
  ADD UNIQUE KEY `mid` (`mid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `profile_picture` (`profile_picture`) USING BTREE,
  ADD KEY `email` (`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `profile_picture` FOREIGN KEY (`profile_picture`) REFERENCES `media` (`mid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
