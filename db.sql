-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Oct 17, 2023 at 08:25 AM
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
CREATE DEFINER=`root`@`%` PROCEDURE `sp_deleteMediaById` (IN `media_id` INT)  BEGIN

DELETE FROM media WHERE mid = media_id;

END$$

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

CREATE DEFINER=`root`@`%` PROCEDURE `sp_userUpdate` (IN `user_email` VARCHAR(255), IN `first_name` VARCHAR(255), IN `last_name` VARCHAR(255), IN `profile_picture` VARCHAR(255))  BEGIN
    UPDATE users
	SET email = user_email, first_name = first_name, last_name = last_name, profile_picture = profile_picture
    WHERE email = user_email;
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
(1, '1697461313-wedding-8176868_1280.jpg', '/storage/images/1697461313-wedding-8176868_1280.jpg', 'jpg', '2023-10-16 13:01:53'),
(2, '1697518401-social_auth_linkedin_QrY63LdoBT.jpg', '/storage/images/1697518401-social_auth_linkedin_QrY63LdoBT.jpg', 'jpg', '2023-10-17 04:53:21'),
(3, '1697519607-social_auth_linkedin_QrY63LdoBT.jpg', '/storage/images/1697519607-social_auth_linkedin_QrY63LdoBT.jpg', 'jpg', '2023-10-17 05:13:27'),
(4, '1697519662-unknown (53).png', '/storage/images/1697519662-unknown (53).png', 'png', '2023-10-17 05:14:22'),
(5, '1697520176-', '/storage/images/1697520176-', '', '2023-10-17 05:22:56'),
(6, '1697520201-unknown (53).png', '/storage/images/1697520201-unknown (53).png', 'png', '2023-10-17 05:23:21'),
(7, '1697520247-unknown_54_1 (1).png', '/storage/images/1697520247-unknown_54_1 (1).png', 'png', '2023-10-17 05:24:07'),
(8, '1697520263-unknown_54_1 (1).png', '/storage/images/1697520263-unknown_54_1 (1).png', 'png', '2023-10-17 05:24:23'),
(9, '1697520332-unknown_54_1 (1).png', '/storage/images/1697520332-unknown_54_1 (1).png', 'png', '2023-10-17 05:25:32'),
(10, '1697520365-unknown_54_1 (1).png', '/storage/images/1697520365-unknown_54_1 (1).png', 'png', '2023-10-17 05:26:05'),
(11, '1697520637-unknown_54_1 (1).png', '/storage/images/1697520637-unknown_54_1 (1).png', 'png', '2023-10-17 05:30:38'),
(12, '1697520652-unknown_18.png', '/storage/images/1697520652-unknown_18.png', 'png', '2023-10-17 05:30:52'),
(13, '1697520664-unknown_18.png', '/storage/images/1697520664-unknown_18.png', 'png', '2023-10-17 05:31:04'),
(14, '1697520711-unknown_18.png', '/storage/images/1697520711-unknown_18.png', 'png', '2023-10-17 05:31:51'),
(15, '1697520719-unknown_18.png', '/storage/images/1697520719-unknown_18.png', 'png', '2023-10-17 05:31:59'),
(16, '1697520755-unknown_18.png', '/storage/images/1697520755-unknown_18.png', 'png', '2023-10-17 05:32:35'),
(17, '1697521007-', '/storage/images/1697521007-', '', '2023-10-17 05:36:47'),
(18, '1697521139-', '/storage/images/1697521139-', '', '2023-10-17 05:38:59'),
(19, '1697521156-', '/storage/images/1697521156-', '', '2023-10-17 05:39:16'),
(20, '1697521176-unknown (62).png', '/storage/images/1697521176-unknown (62).png', 'png', '2023-10-17 05:39:36'),
(21, '1697521188-unknown (62).png', '/storage/images/1697521188-unknown (62).png', 'png', '2023-10-17 05:39:48'),
(22, '1697521202-', '/storage/images/1697521202-', '', '2023-10-17 05:40:02'),
(23, '1697521247-', '/storage/images/1697521247-', '', '2023-10-17 05:40:47'),
(24, '1697521259-', '/storage/images/1697521259-', '', '2023-10-17 05:40:59'),
(25, '1697521972-screenshot.png', '/storage/images/1697521972-screenshot.png', 'png', '2023-10-17 05:52:52'),
(26, '1697521986-screenshot.png', '/storage/images/1697521986-screenshot.png', 'png', '2023-10-17 05:53:06'),
(27, '1697522015-screenshot.png', '/storage/images/1697522015-screenshot.png', 'png', '2023-10-17 05:53:35'),
(28, '1697522022-screenshot.png', '/storage/images/1697522022-screenshot.png', 'png', '2023-10-17 05:53:43'),
(29, '1697522044-og_image (1).png', '/storage/images/1697522044-og_image (1).png', 'png', '2023-10-17 05:54:05'),
(30, '1697522168-unknown_18.png', '/storage/images/1697522168-unknown_18.png', 'png', '2023-10-17 05:56:08'),
(31, '1697522185-IMG_20220314_084537.jpg', '/storage/images/1697522185-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 05:56:25'),
(32, '1697522187-IMG_20220314_084537.jpg', '/storage/images/1697522187-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 05:56:27'),
(33, '1697522195-IMG_20220314_084537.jpg', '/storage/images/1697522195-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 05:56:35'),
(34, '1697522284-IMG_20220314_084537.jpg', '/storage/images/1697522284-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 05:58:04'),
(35, '1697522330-IMG_20220314_084537.jpg', '/storage/images/1697522330-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 05:58:50'),
(36, '1697522350-IMG_20220314_084537.jpg', '/storage/images/1697522350-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 05:59:10'),
(37, '1697522469-IMG_20220314_084537.jpg', '/storage/images/1697522469-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 06:01:09'),
(38, '1697522483-IMG_20220314_084537.jpg', '/storage/images/1697522483-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 06:01:24'),
(39, '1697522496-IMG_20220314_084537.jpg', '/storage/images/1697522496-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 06:01:36'),
(40, '1697522501-IMG_20220314_084537.jpg', '/storage/images/1697522501-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 06:01:41'),
(41, '1697522523-IMG_20220314_084537.jpg', '/storage/images/1697522523-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 06:02:03'),
(42, '1697522649-IMG_20220314_084537.jpg', '/storage/images/1697522649-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 06:04:09'),
(43, '1697522663-IMG_20220314_084537.jpg', '/storage/images/1697522663-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 06:04:23'),
(44, '1697522770-IMG_20220314_084537.jpg', '/storage/images/1697522770-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 06:06:10'),
(45, '1697522822-IMG_20220314_084537.jpg', '/storage/images/1697522822-IMG_20220314_084537.jpg', 'jpg', '2023-10-17 06:07:02'),
(46, '1697522841-unknown (53).png', '/storage/images/1697522841-unknown (53).png', 'png', '2023-10-17 06:07:21'),
(47, '1697522899-unknown_54_1 (1).png', '/storage/images/1697522899-unknown_54_1 (1).png', 'png', '2023-10-17 06:08:19'),
(48, '1697523248-unknown (52).png', '/storage/images/1697523248-unknown (52).png', 'png', '2023-10-17 06:14:08'),
(49, '1697523394-', '/storage/images/1697523394-', '', '2023-10-17 06:16:34'),
(50, '1697523438-', '/storage/images/1697523438-', '', '2023-10-17 06:17:18'),
(51, '1697524296-unknown_54_1 (1).png', '/storage/images/1697524296-unknown_54_1 (1).png', 'png', '2023-10-17 06:31:37'),
(52, '1697524741-unknown (5).png', '/storage/images/1697524741-unknown (5).png', 'png', '2023-10-17 06:39:01'),
(53, '1697524781-unknown.png', '/storage/images/1697524781-unknown.png', 'png', '2023-10-17 06:39:41'),
(54, '1697524790-unknown.png', '/storage/images/1697524790-unknown.png', 'png', '2023-10-17 06:39:50'),
(55, '1697524937-unknown_54_1 (1).png', '/storage/images/1697524937-unknown_54_1 (1).png', 'png', '2023-10-17 06:42:17'),
(56, '1697524953-', '/storage/images/1697524953-', '', '2023-10-17 06:42:33'),
(57, '1697524969-', '/storage/images/1697524969-', '', '2023-10-17 06:42:49'),
(58, '1697524971-', '/storage/images/1697524971-', '', '2023-10-17 06:42:51'),
(60, '1697525002-', '/storage/images/1697525002-', '', '2023-10-17 06:43:22'),
(61, '1697525057-', '/storage/images/1697525057-', '', '2023-10-17 06:44:17'),
(62, '1697525070-unknown (53).png', '/storage/images/1697525070-unknown (53).png', 'png', '2023-10-17 06:44:30'),
(64, '1697525117-unknown (53).png', '/storage/images/1697525117-unknown (53).png', 'png', '2023-10-17 06:45:17'),
(65, '1697525129-', '/storage/images/1697525129-', '', '2023-10-17 06:45:29'),
(66, '1697525151-', '/storage/images/1697525151-', '', '2023-10-17 06:45:51'),
(67, '1697525216-unknown (55).png', '/storage/images/1697525216-unknown (55).png', 'png', '2023-10-17 06:46:56'),
(68, '1697525251-unknown (53).png', '/storage/images/1697525251-unknown (53).png', 'png', '2023-10-17 06:47:31'),
(69, '1697525345-unknown (55).png', '/storage/images/1697525345-unknown (55).png', 'png', '2023-10-17 06:49:05'),
(70, '1697525436-unknown (53).png', '/storage/images/1697525436-unknown (53).png', 'png', '2023-10-17 06:50:36'),
(71, '1697525527-unknown (53).png', '/storage/images/1697525527-unknown (53).png', 'png', '2023-10-17 06:52:07'),
(72, '1697525535-unknown_54_1 (1).png', '/storage/images/1697525535-unknown_54_1 (1).png', 'png', '2023-10-17 06:52:15'),
(73, '1697525547-untitled-design-1_1.png', '/storage/images/1697525547-untitled-design-1_1.png', 'png', '2023-10-17 06:52:27'),
(74, '1697525583-untitled-design-1_1.png', '/storage/images/1697525583-untitled-design-1_1.png', 'png', '2023-10-17 06:53:03'),
(75, '1697525595-untitled-design-1_1.png', '/storage/images/1697525595-untitled-design-1_1.png', 'png', '2023-10-17 06:53:15'),
(76, '1697525617-untitled-design-1_1.png', '/storage/images/1697525617-untitled-design-1_1.png', 'png', '2023-10-17 06:53:37'),
(77, '1697525680-unknown (53).png', '/storage/images/1697525680-unknown (53).png', 'png', '2023-10-17 06:54:40'),
(78, '1697525707-unknown (53).png', '/storage/images/1697525707-unknown (53).png', 'png', '2023-10-17 06:55:07'),
(79, '1697529086-unknown (52).png', '/storage/images/1697529086-unknown (52).png', 'png', '2023-10-17 07:51:26'),
(80, '1697529116-unknown (52).png', '/storage/images/1697529116-unknown (52).png', 'png', '2023-10-17 07:51:56'),
(81, '1697529130-unknown_54_1 (1).png', '/storage/images/1697529130-unknown_54_1 (1).png', 'png', '2023-10-17 07:52:10'),
(82, '1697529183-unknown (53).png', '/storage/images/1697529183-unknown (53).png', 'png', '2023-10-17 07:53:03'),
(83, '1697529196-unknown (53).png', '/storage/images/1697529196-unknown (53).png', 'png', '2023-10-17 07:53:16'),
(84, '1697529205-unknown (1).png', '/storage/images/1697529205-unknown (1).png', 'png', '2023-10-17 07:53:25'),
(85, '1697529213-IMG_7402.jpg', '/storage/images/1697529213-IMG_7402.jpg', 'jpg', '2023-10-17 07:53:33'),
(86, '1697529233-IMG_8466-1.jpg', '/storage/images/1697529233-IMG_8466-1.jpg', 'jpg', '2023-10-17 07:53:53'),
(87, '1697529739-unknown (7).png', '/storage/images/1697529739-unknown (7).png', 'png', '2023-10-17 08:02:19'),
(88, '1697529757-unknown_54_1 (1).png', '/storage/images/1697529757-unknown_54_1 (1).png', 'png', '2023-10-17 08:02:37'),
(98, '1697530022-unknown_18.png', '/storage/images/1697530022-unknown_18.png', 'png', '2023-10-17 08:07:02'),
(99, '1697530045-unknown_18.png', '/storage/images/1697530045-unknown_18.png', 'png', '2023-10-17 08:07:25'),
(100, '1697530070-unknown_18.png', '/storage/images/1697530070-unknown_18.png', 'png', '2023-10-17 08:07:50'),
(101, '1697530077-unknown (53).png', '/storage/images/1697530077-unknown (53).png', 'png', '2023-10-17 08:07:57'),
(102, '1697530085-unknown (53).png', '/storage/images/1697530085-unknown (53).png', 'png', '2023-10-17 08:08:05'),
(103, '1697530106-', '/storage/images/1697530106-', '', '2023-10-17 08:08:26'),
(104, '1697530162-', '/storage/images/1697530162-', '', '2023-10-17 08:09:22'),
(105, '1697530179-unknown_54_1 (1).png', '/storage/images/1697530179-unknown_54_1 (1).png', 'png', '2023-10-17 08:09:39'),
(106, '1697530190-unknown (53).png', '/storage/images/1697530190-unknown (53).png', 'png', '2023-10-17 08:09:50'),
(107, '1697530229-unknown (53).png', '/storage/images/1697530229-unknown (53).png', 'png', '2023-10-17 08:10:29'),
(108, '1697530237-untitled-design-1_1.png', '/storage/images/1697530237-untitled-design-1_1.png', 'png', '2023-10-17 08:10:37'),
(109, '1697530261-unknown (53).png', '/storage/images/1697530261-unknown (53).png', 'png', '2023-10-17 08:11:01'),
(110, '1697530274-unknown (53).png', '/storage/images/1697530274-unknown (53).png', 'png', '2023-10-17 08:11:14'),
(111, '1697530337-', '/storage/images/1697530337-', '', '2023-10-17 08:12:17'),
(112, '1697530353-unknown (52).png', '/storage/images/1697530353-unknown (52).png', 'png', '2023-10-17 08:12:33'),
(113, '1697530413-unknown (52).png', '/storage/images/1697530413-unknown (52).png', 'png', '2023-10-17 08:13:33'),
(114, '1697530417-', '/storage/images/1697530417-', '', '2023-10-17 08:13:37'),
(115, '1697530424-', '/storage/images/1697530424-', '', '2023-10-17 08:13:44'),
(116, '1697530431-', '/storage/images/1697530431-', '', '2023-10-17 08:13:51'),
(117, '1697530447-unknown (55).png', '/storage/images/1697530447-unknown (55).png', 'png', '2023-10-17 08:14:07'),
(118, '1697530453-', '/storage/images/1697530453-', '', '2023-10-17 08:14:13'),
(119, '1697530483-', '/storage/images/1697530483-', '', '2023-10-17 08:14:43'),
(120, '1697530497-', '/storage/images/1697530497-', '', '2023-10-17 08:14:57'),
(121, '1697530532-', '/storage/images/1697530532-', '', '2023-10-17 08:15:32'),
(122, '1697530541-untitled-design-1_1.png', '/storage/images/1697530541-untitled-design-1_1.png', 'png', '2023-10-17 08:15:41'),
(123, '1697530582-unknown (62).png', '/storage/images/1697530582-unknown (62).png', 'png', '2023-10-17 08:16:22'),
(124, '1697530665-unknown (62).png', '/storage/images/1697530665-unknown (62).png', 'png', '2023-10-17 08:17:45'),
(125, '1697530673-', '/storage/images/1697530673-', '', '2023-10-17 08:17:53'),
(126, '1697530698-', '/storage/images/1697530698-', '', '2023-10-17 08:18:19'),
(127, '1697530731-', '/storage/images/1697530731-', '', '2023-10-17 08:18:51'),
(128, '1697530791-', '/storage/images/1697530791-', '', '2023-10-17 08:19:51'),
(129, '1697530805-', '/storage/images/1697530805-', '', '2023-10-17 08:20:05'),
(130, '1697530816-', '/storage/images/1697530816-', '', '2023-10-17 08:20:16'),
(131, '1697530858-', '/storage/images/1697530858-', '', '2023-10-17 08:20:58'),
(132, '1697530896-', '/storage/images/1697530896-', '', '2023-10-17 08:21:36'),
(133, '1697530905-unknown_54_1 (1).png', '/storage/images/1697530905-unknown_54_1 (1).png', 'png', '2023-10-17 08:21:45'),
(134, '1697530938-unknown_54_1 (1).png', '/storage/images/1697530938-unknown_54_1 (1).png', 'png', '2023-10-17 08:22:18'),
(135, '1697530943-unknown_54_1 (1).png', '/storage/images/1697530943-unknown_54_1 (1).png', 'png', '2023-10-17 08:22:23'),
(136, '1697530951-unknown_54_1 (1).png', '/storage/images/1697530951-unknown_54_1 (1).png', 'png', '2023-10-17 08:22:31'),
(137, '1697530958-unknown_54_1 (1).png', '/storage/images/1697530958-unknown_54_1 (1).png', 'png', '2023-10-17 08:22:38'),
(138, '1697530965-', '/storage/images/1697530965-', '', '2023-10-17 08:22:45'),
(139, '1697531002-', '/storage/images/1697531002-', '', '2023-10-17 08:23:22'),
(140, '1697531011-', '/storage/images/1697531011-', '', '2023-10-17 08:23:31');

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
(2, 'firstddd2222', '2222', 'diomenikep@gmail.com', '$2y$10$tzrWVj8vNvcrMHk5Mmc61.5wBqV8ArQdbzdPmNhRwveGpNzLuepnO', '2023-10-17 05:14:22', 1, 47),
(5, 'dionddd2222', 'dion', 'dion@dion.com', '$2y$10$Eg0ytuprTi5RUABznumJO.7E5eXZV7hvSEuQYXEFGPNQ1jarREL6y', '2023-10-17 06:49:05', 1, 139);

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
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
