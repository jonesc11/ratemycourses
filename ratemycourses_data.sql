-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2017 at 04:33 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ratemycourses`
--

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `courseid`, `comment`, `active`, `ratingid`, `userid`, `flagged`) VALUES
('0', '0002', 'this class was soooooo hard', 1, '0', '00000000', 0),
('1', '0002', 'I loved this class! It was hard but really fulfilling', 1, '1', '00000000', 0),
('2', '0001', 'this class was super easy', 1, '2', '00000000', 0),
('3', '0001', '', 1, '3', '00000000', 0),
('4', '4', 'Plotka rules!', 1, '4', '00000000', 0),
('6', '4', 'I really liked this class!', 1, '6', '00000000', 0);

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `coursename`, `major`, `coursenum`, `schoolid`) VALUES
('0001', 'Introduction to Computer Science', 'CSCI', 1100, 'RPI'),
('0002', 'Data Structures', 'CSCI', 1200, 'RPI'),
('10', 'Graph Theory', 'CSCI', 4260, 'RPI'),
('11', 'Parallel Programming', 'CSCI', 4320, 'RPI'),
('12', 'Data and Society', 'CSCI', 4370, 'RPI'),
('13', 'Database Systems', 'CSCI', 4380, 'RPI'),
('14', 'Xinformatics', 'CSCI', 4400, 'RPI'),
('15', 'Software Design and Documentation', 'CSCI', 4440, 'RPI'),
('16', 'Principles of Program Analysis', 'CSCI', 4450, 'RPI'),
('17', 'Robotics II', 'CSCI', 4490, 'RPI'),
('18', 'Game Development II', 'CSCI', 4540, 'RPI'),
('19', 'Introduction to English', 'ENGL', 1000, '1'),
('1a', 'Web Systems Development', 'ITWS', 2110, 'RPI'),
('1b', 'Managing IT Resources', 'ITWS', 4310, 'RPI'),
('3', 'Foundations of Computer Science', 'CSCI', 2200, 'RPI'),
('4', 'Introduction to ITWS', 'ITWS', 1100, 'RPI'),
('5', 'Computer Organization', 'CSCI', 2500, 'RPI'),
('6', 'Introduction to Computer Programming', 'CSCI', 1010, 'RPI'),
('7', 'Beginning Programming for Engineers', 'CSCI', 1190, 'RPI'),
('8', 'Introduction to Algorithms', 'CSCI', 2300, 'RPI'),
('9', 'Principles of Software', 'CSCI', 2600, 'RPI'),
('a', 'Computer Algorithms', 'CSCI', 4020, 'RPI'),
('b', 'Computational Social Processes', 'CSCI', 4110, 'RPI'),
('c', 'Natural Language Processing', 'CSCI', 4130, 'RPI'),
('d', 'Introduction to Artificial Intelligence', 'CSCI', 4150, 'RPI'),
('e', 'Operating Systems', 'CSCI', 4210, 'RPI'),
('f', 'Network Programming', 'CSCI', 4220, 'RPI');

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `major`, `school`, `name`, `schoolid`) VALUES
('0001', 'CSCI', 'School of Science', 'Computer Science', 'RPI'),
('0002', 'BIOL', 'School of Science', 'Biology', 'RPI'),
('0003', 'MATH', 'School of Science', 'Mathematics', 'RPI'),
('0004', 'STSS', 'School of Humanities, Arts, and Social Science', 'Science and Technology Studies', 'RPI'),
('0005', 'WRIT', 'School of Humanities, Arts, and Social Science', 'Writing', 'RPI'),
('0006', 'CHME', 'School of Engineering', 'Chemical Engineering', 'RPI'),
('0007', 'MGMT', 'School of Management', 'Management', 'RPI'),
('0008', 'ARCH', 'School of Architecture', 'Architecture', 'RPI'),
('0009', 'ADMN', 'Other', 'Administrative Courses', 'RPI'),
('0010', 'LGHT', 'Other', 'Lighting', 'RPI'),
('11', 'ITWS', 'School of Science', 'Information Technology and Web Science', 'RPI'),
('12', 'CSCI', 'School of Science', 'Computer Science', '1'),
('13', 'ENGL', 'School of Humanities', 'English', '1'),
('14', 'HIST', 'School of Humanities', 'History', '1'),
('15', 'BMED', 'School of Engineering', 'Biomedical Engineering', 'RPI'),
('16', 'CIVL', 'School of Engineering', 'Civil Engineering', 'RPI'),
('17', 'ESCE', 'School of Engineering', 'Electrical Engineering', 'RPI'),
('18', 'ENVE', 'School of Engineering', 'Environmental Engineering', 'RPI');

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `category1`, `category2`, `category3`, `category4`, `category5`, `userid`) VALUES
('0', 1, 1, 3, 3, NULL, '00000000'),
('1', 3, 3, 3, 5, NULL, '00000000'),
('2', 5, 3, 5, 3, NULL, '00000000'),
('3', 5, 5, 5, 5, NULL, '00000000'),
('4', 4, 4, 1, 4, NULL, '00000000'),
('5', 1, 1, 1, 1, NULL, '00000000'),
('6', 4, 4, 1, 5, NULL, '00000000');

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`) VALUES
('1', 'COLUMBIA UNIVERSITY'),
('RIT', 'Rochester Institute of Technology'),
('RPI', 'Rensselaer Polytechnic Institute');

--
-- Dumping data for table `suggestions`
--

INSERT INTO `suggestions` (`id`, `userid`, `suggestion`, `status`) VALUES
('0', 'collin', 'I made a suggestion!', 0),
('1', 'collin', 'Add a course for web sys!', 0),
('2', '00000000', 'Can you please add Cornell to the schools page?', 1);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `permissions`, `firstname`, `lastname`, `active`) VALUES
('00000000', 'neemay', '5e26becc9f9fb868b7ea5ed12bd84055f685d73271e3995595d969c02ef56bea', '5c28298d71d4d6f1', 'yarden123@gmail.com', 0, 'Yarden', 'Ne''eman', 1),
('00000001', 'Admin', '5d321ae25fa385c61f90ccd0d59851fa8d58d7ed8e8642408252e153283c24cf', '4b1a1d2440e35d32', 'admin@admin.com', 2, 'Diana', 'Edwards', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
