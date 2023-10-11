-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Oct 11, 2023 at 11:52 AM
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

CREATE DEFINER=`root`@`%` PROCEDURE `sp_updateStudent` (IN `studentId` INT, IN `first_name` VARCHAR(50), IN `last_name` VARCHAR(50))  SQL SECURITY INVOKER
BEGIN
    UPDATE students
	SET first_name = first_name, last_name = last_name
    WHERE id = studentId;
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
(6, '11', '11'),
(7, 'asdsad', 'asdasd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
