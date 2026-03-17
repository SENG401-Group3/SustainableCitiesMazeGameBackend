-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 10, 2026 at 03:17 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sustainabilitymazegame`
--
-- Uncomment only when testing
-- DROP DATABASE `sustainabilitymazegame`; 
CREATE DATABASE IF NOT EXISTS `sustainabilitymazegame` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sustainabilitymazegame`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) AUTO_INCREMENT,
  `firstname` varchar(16) NOT NULL,
  `lastname` varchar(16) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `pfp` int(10) NOT NULL DEFAULT '0' COMMENT 'pfp id number',
  `highscore` int(10) NOT NULL DEFAULT '0',
  `citynumber` int(10) NOT NULL DEFAULT '1',
  `currentscore` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  UNIQUE KEY (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--

--
-- AUTO_INCREMENT for dumped tables
--

--

--
-- Constraints for dumped tables
--

--

-- Dummy users to populate the db (for testing purposes only)
INSERT INTO users (firstname, lastname, username, password, highscore, citynumber, currentscore)
VALUES
	("Test1234!", "Test1234!", "Test1234!", "Test1234!", 9999, 9999, 5);
INSERT INTO users (firstname, lastname, username, password, highscore, citynumber, currentscore)
VALUES
	("Mock1234!", "Mock1234!", "Mock1234!", "Mock1234!", 6211, 3721, 2);
INSERT INTO users (firstname, lastname, username, password, highscore, citynumber, currentscore)
VALUES
	("Fake1234!", "Fake1234!", "Fake1234!", "Fake1234!", 8723, 5782, 3);
INSERT INTO users (firstname, lastname, username, password, highscore, citynumber, currentscore)
VALUES
	("Dummy1234!", "Dummy1234!", "Dummy1234!", "Dummy1234!", -1, 9, 1);
    
SELECT * FROM users;