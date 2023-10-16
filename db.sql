-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Oct 16, 2023 at 08:02 AM
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
(4, '1697372984-15780688_1369878763054545_4385314309442176537_n-cropped.jpg', '/storage/images/1697372984-15780688_1369878763054545_4385314309442176537_n-cropped.jpg', 'jpg', '2023-10-15 12:29:44'),
(5, '1697435324-263653685_433820498269496_6433106433251749453_n (1).jpg', '/storage/images/1697435324-263653685_433820498269496_6433106433251749453_n (1).jpg', 'jpg', '2023-10-16 05:48:44'),
(6, '1697435385-263653685_433820498269496_6433106433251749453_n (1).jpg', '/storage/images/1697435385-263653685_433820498269496_6433106433251749453_n (1).jpg', 'jpg', '2023-10-16 05:49:45'),
(7, '1697435398-unknown_54_1 (1).png', '/storage/images/1697435398-unknown_54_1 (1).png', 'png', '2023-10-16 05:49:58'),
(8, '1697435421-unknown_54_1 (1).png', '/storage/images/1697435421-unknown_54_1 (1).png', 'png', '2023-10-16 05:50:21'),
(9, '1697435464-unknown (53).png', '/storage/images/1697435464-unknown (53).png', 'png', '2023-10-16 05:51:04'),
(10, '1697435560-unknown (53).png', '/storage/images/1697435560-unknown (53).png', 'png', '2023-10-16 05:52:40'),
(11, '1697435618-unknown_54_1 (1).png', '/storage/images/1697435618-unknown_54_1 (1).png', 'png', '2023-10-16 05:53:39'),
(12, '1697435760-unknown_54_1 (1).png', '/storage/images/1697435760-unknown_54_1 (1).png', 'png', '2023-10-16 05:56:00'),
(14, '1697436173-unknown (5).png', '/storage/images/1697436173-unknown (5).png', 'png', '2023-10-16 06:02:53'),
(15, '1697436185-unknown (5).png', '/storage/images/1697436185-unknown (5).png', 'png', '2023-10-16 06:03:05'),
(16, '1697436197-unknown (5).png', '/storage/images/1697436197-unknown (5).png', 'png', '2023-10-16 06:03:17'),
(17, '1697436202-unknown (5).png', '/storage/images/1697436202-unknown (5).png', 'png', '2023-10-16 06:03:22'),
(18, '1697436423-unknown (5).png', '/storage/images/1697436423-unknown (5).png', 'png', '2023-10-16 06:07:03'),
(19, '1697436432-unknown (5).png', '/storage/images/1697436432-unknown (5).png', 'png', '2023-10-16 06:07:12'),
(20, '1697436532-unknown (5).png', '/storage/images/1697436532-unknown (5).png', 'png', '2023-10-16 06:08:52'),
(21, '1697436539-unknown (5).png', '/storage/images/1697436539-unknown (5).png', 'png', '2023-10-16 06:08:59'),
(22, '1697436580-unknown (5).png', '/storage/images/1697436580-unknown (5).png', 'png', '2023-10-16 06:09:40'),
(23, '1697436582-unknown (5).png', '/storage/images/1697436582-unknown (5).png', 'png', '2023-10-16 06:09:42'),
(27, '1697436677-unknown (5).png', '/storage/images/1697436677-unknown (5).png', 'png', '2023-10-16 06:11:17'),
(28, '1697436678-unknown (5).png', '/storage/images/1697436678-unknown (5).png', 'png', '2023-10-16 06:11:18'),
(29, '1697436692-unknown (5).png', '/storage/images/1697436692-unknown (5).png', 'png', '2023-10-16 06:11:32'),
(30, '1697436699-unknown (5).png', '/storage/images/1697436699-unknown (5).png', 'png', '2023-10-16 06:11:39'),
(31, '1697436707-unknown (5).png', '/storage/images/1697436707-unknown (5).png', 'png', '2023-10-16 06:11:47'),
(36, '1697436796-unknown (5).png', '/storage/images/1697436796-unknown (5).png', 'png', '2023-10-16 06:13:16'),
(37, '1697436804-unknown (5).png', '/storage/images/1697436804-unknown (5).png', 'png', '2023-10-16 06:13:25'),
(39, '1697436820-unknown (5).png', '/storage/images/1697436820-unknown (5).png', 'png', '2023-10-16 06:13:40'),
(45, '1697436942-screenshot.png', '/storage/images/1697436942-screenshot.png', 'png', '2023-10-16 06:15:42'),
(46, '1697436992-screenshot.png', '/storage/images/1697436992-screenshot.png', 'png', '2023-10-16 06:16:32'),
(47, '1697437083-unknown.png', '/storage/images/1697437083-unknown.png', 'png', '2023-10-16 06:18:03'),
(51, '1697437291-unknown (65).png', '/storage/images/1697437291-unknown (65).png', 'png', '2023-10-16 06:21:31');

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
(72, 'User', 'Two', 'user2@user.com', '$2y$10$cc6Mm0yAiyUv76yjVH9dh.HvMmx/04Oc0MlJfPexmuOjrPhfqCUYG', '2023-10-15 12:29:44', 1, 3),
(73, 'bro1@test.com', 'bro1@test.com', 'bro1@test.com', '$2y$10$o9HQAHpsShF2BnMZLllLP.anzvrV1Lvgado1lsyTCqXAem7BEijyy', '2023-10-16 05:49:45', 1, 1),
(74, 'bro2@test.com', 'bro2@test.com', 'bro2@test.com', '$2y$10$t2uAkAXf7gFzi.uWhFgmQObOIx0k5M350AXEOKE0xT/yIc2GRT7gy', '2023-10-16 05:49:58', 1, 1),
(75, 'br2o2@test.com', 'br2o2@test.com', 'br2o2@test.com', '$2y$10$mrhyVgdtMjaM3GT4gCFqAOPvkMurrT73i1zs1xcNcICJykbKJeKRy', '2023-10-16 05:50:21', 1, 1),
(76, '1br2o2@test.com', '1br2o2@test.com', '1br2o2@test.com', '$2y$10$FkZuRfIyfi4koP23cBSywegrVKjSIj/ySWf2yrc7DKBa0Fl5Zlxfq', '2023-10-16 05:51:04', 1, 1),
(77, '11br2o2@test.com', '11br2o2@test.com', '11br2o2@test.com', '$2y$10$ObMf3l5WJmaw6eT91Zy/v.1mAJi6EOMbC5cGrfenFQW0/GvD3hYim', '2023-10-16 05:52:40', 1, 1),
(78, '11br222o2@test.com', '11br222o2@test.com', '11br222o2@test.com', '$2y$10$NjDPHXEMrF2ltLsLUu5JpeAxM.s2iTBWsQKSqlIcWLX84GUHjTtYW', '2023-10-16 05:53:39', 1, 1),
(79, '11b2r222o2@test.com', '11b2r222o2@test.com', '11b2r222o2@test.com', '$2y$10$mrKu7fojjqIbRLyBLLIjReR1fHltARGVeKRYgOSdVQOSDpfCOXoxq', '2023-10-16 05:56:00', 1, 1),
(80, '1111b2r222o2@test.com', '1111b2r222o2@test.com', '1111b2r222o2@test.com', '$2y$10$8P6DFKKpBc1eKohFSSxFkemQalqz62pDoJCwYDkAYntOATF23QYle', '2023-10-16 06:02:53', 1, 1),
(81, 'amos@amos.com', 'amos@amos.com', 'amos@amos.com', '$2y$10$pBM3GILTDxmzXHG0xsnC/O985vL.WgwOlTNgj2ZDrI9brLxBnIUgC', '2023-10-16 06:15:42', 1, 1),
(82, '11amos@amos.com', '11amos@amos.com', '11amos@amos.com', '$2y$10$O8qsNCZhAivIXc8i5CyhWeRn3DdGbV5eIJMrUmKC6QrwavL3kv16y', '2023-10-16 06:16:32', 1, 46),
(83, 'Diome Nike', 'Potot', 'system.administrator@staging.saas.halcyondigitalhost.com', '$2y$10$zZOmgmxh7gYuzj4zbJz1r.9jVPPcd.bNljwfnfoT4fkwoWUfMUX6a', '2023-10-16 06:18:03', 1, 47),
(84, 'Diome Nike', 'Potot', '1@1.casd', '$2y$10$45x3Nrdo4n7RN0Y5BWk0SejL2XiAqYxnFai8YAHA1hbK61DXa9gNa', '2023-10-16 06:21:31', 1, 51);

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
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

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
