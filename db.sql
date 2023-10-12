-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Oct 12, 2023 at 08:43 AM
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

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getStudent` (IN `studentId` INT)  SQL SECURITY INVOKER
BEGIN

SELECT * FROM students WHERE id = studentId;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_getStudents` ()  BEGIN

SELECT * from students; 

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertStudent` (IN `first_name` VARCHAR(50), IN `last_name` VARCHAR(50))  SQL SECURITY INVOKER
BEGIN
    INSERT INTO students (first_name, last_name)    VALUES (first_name, last_name);
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `sp_insertUser` (IN `email` VARCHAR(255), IN `password` VARCHAR(255), IN `role` INT(255))  SQL SECURITY INVOKER
BEGIN
    DECLARE IsValidEmail BIT DEFAULT 0;
    
    
    IF email REGEXP '^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}$' THEN
        SET IsValidEmail = 1;
    END IF;

    IF IsValidEmail = 1 THEN
        
        INSERT INTO users (email, password, role) VALUES (email, password, role);
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

    -- Find the user by email
    SELECT id, password INTO v_user_id, v_hashed_password
    FROM users
    WHERE email = p_email;

    -- Check if the user exists and the password is correct
    IF v_user_id IS NOT NULL AND BINARY p_password = v_hashed_password THEN
        -- Password is correct, set up a session and return success
        SELECT 'Login successful' AS result;
    ELSE
        -- Invalid credentials, return an error message
        SELECT 'Invalid email or password. Please try again.' AS result;
    END IF;
END$$

DELIMITER ;

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
(15, 'aaddd', 'aa222'),
(16, 'aa', 'aaa'),
(17, 'Diome Nike', 'Potot'),
(18, 'aa', '21321');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`) VALUES
(1, 'diome.halcyonwebdesign@gmail.com', '$2y$10$TjUjRBEO5x3sUX8eGovEzuRTYwpZofvjLsauI0iLq/0MbcWLPleBa', 1);

--
-- Indexes for dumped tables
--

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
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
