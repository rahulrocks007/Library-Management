-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2022 at 09:40 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` int(111) NOT NULL,
  `username` varchar(111) NOT NULL,
  `fullname` varchar(111) NOT NULL,
  `adminemail` varchar(111) NOT NULL,
  `password` varchar(111) NOT NULL,
  `pic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `username`, `fullname`, `adminemail`, `password`, `pic`) VALUES
(1, 'admin', 'rahul', 'abc@gmail.com', 'admin', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `authorid` int(111) NOT NULL,
  `authorname` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`authorid`, `authorname`) VALUES
(9, 'Bjarne Stroustrup'),
(11, 'Anthony Brun'),
(14, 'E. Balagurusamy'),
(15, 'Ken Liu'),
(16, 'A.G Riddle'),
(17, 'Rakib Hassan'),
(18, 'Rob Boffard'),
(19, 'Khaled Hosseini'),
(20, 'Sandra Block'),
(21, 'J.R.R. Tolkien'),
(22, 'William Goldman'),
(24, 'Md. Zafar Iqbal Hassan'),
(29, 'James Patterson'),
(30, 'Dharma Publications');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookid` int(100) NOT NULL,
  `bookpic` varchar(500) NOT NULL,
  `bookname` varchar(100) NOT NULL,
  `authorid` int(100) NOT NULL,
  `categoryid` int(100) NOT NULL,
  `ISBN` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookid`, `bookpic`, `bookname`, `authorid`, `categoryid`, `ISBN`, `price`, `quantity`) VALUES
(20, 'cplus.jpg', 'C++', 11, 2, '27899', 200, 9),
(22, 'python2.jpg', 'Python Programming', 11, 2, '2456', 600, 6),
(28, 'c.jpg', 'C Programming in ANSI', 14, 2, '24512', 200, 8),
(29, 'sf1.jpg', 'Borken Stars', 15, 1, '2487', 400, 5),
(30, 'sf2.jpg', 'The Solar War', 16, 1, '27899', 200, 10),
(31, 'sf3.jpg', 'Star Wars', 17, 1, '254789', 600, 8),
(32, 'sf4.jpg', 'Adrift', 18, 1, '24569', 500, 8),
(33, 'nv1.jpg', 'The Kite Runner', 19, 3, '23658', 600, 8),
(34, 'nv2.jpg', 'The Girl Without a Name', 20, 3, '21569', 300, 7),
(35, 'nv3.jpg', 'The Hobbit', 21, 3, '21569', 600, 8),
(36, 'nv4.jpg', 'The Princess Bride', 22, 3, '21456', 500, 7),
(40, 'java.jpg', 'Java', 29, 2, '24512', 500, 7),
(41, 'defaultbook.png', 'ENGLISH GRAMMER', 30, 11, '78654', 500, 4);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryid` int(111) NOT NULL,
  `categoryname` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryid`, `categoryname`) VALUES
(1, 'Science FIction'),
(2, 'Computer Programming'),
(3, 'Novel'),
(4, 'History'),
(11, 'Grammer');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `stdid` int(100) NOT NULL,
  `rating` int(100) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `issueinfo`
--

CREATE TABLE `issueinfo` (
  `studentid` int(100) NOT NULL,
  `bookid` int(100) NOT NULL,
  `issuedate` date NOT NULL DEFAULT current_timestamp(),
  `returndate` date DEFAULT NULL,
  `fine` int(100) NOT NULL,
  `expectedreturndate` date NOT NULL,
  `issued` tinyint(1) NOT NULL DEFAULT 1,
  `expired` tinyint(1) NOT NULL DEFAULT 0,
  `returned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `status` varchar(100) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `date` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentid` int(111) NOT NULL,
  `FullName` varchar(111) NOT NULL,
  `Email` varchar(111) NOT NULL,
  `Password` varchar(111) NOT NULL,
  `PhoneNumber` varchar(111) NOT NULL,
  `studentpic` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentid`, `FullName`, `Email`, `Password`, `PhoneNumber`, `studentpic`) VALUES
(32, 'rahul', 'abc@gmail.com', '456', '123', 'user2.png');

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `sid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `timerequested` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trendingbook`
--

CREATE TABLE `trendingbook` (
  `bookid` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trendingbook`
--

INSERT INTO `trendingbook` (`bookid`) VALUES
(22),
(20),
(33),
(28),
(41);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`authorid`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `authorid` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryid` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentid` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
