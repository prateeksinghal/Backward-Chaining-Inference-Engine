-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 26, 2013 at 07:52 AM
-- Server version: 5.5.30
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fc`
--

-- --------------------------------------------------------

--
-- Table structure for table `kb1`
--

CREATE TABLE IF NOT EXISTS `kb1` (
  `fact` varchar(500) NOT NULL,
  `dex` varchar(500) NOT NULL,
  `basicDerived` varchar(500) NOT NULL,
  `level` int(11) NOT NULL,
  `lhs` varchar(500) NOT NULL,
  `rhs` varchar(500) NOT NULL,
  `derivedFrom` varchar(500) NOT NULL,
  PRIMARY KEY (`dex`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kb1`
--

INSERT INTO `kb1` (`fact`, `dex`, `basicDerived`, `level`, `lhs`, `rhs`, `derivedFrom`) VALUES
('animal has hair', 'F1', 'Basic', 0, 'R1', 'Nil', 'Nil'),
('animal has black stripes', 'F10', 'Basic', 0, 'R8 R10', 'Nil', 'Nil'),
('animal has long legs', 'F11', 'Basic', 0, 'R11 ', 'Nil', 'Nil'),
('animal has long neck', 'F12', 'Basic', 0, 'R11', 'Nil', 'Nil'),
('animal flies very well', 'F13', 'Basic', 0, 'R12', 'Nil', 'Nil'),
('animal is a mammal', 'F14', 'Derived', 1, 'R5 R6', 'R1 R2', 'F1+F2'),
('animal is a bird', 'F15', 'Derived', 1, 'R11 R12', 'R3 R4', 'F3+F4.F5'),
('animal is a carnivore', 'F16', 'Derived', 2, 'R7 R8', 'R5', 'F14.F6'),
('animal is a herbivore', 'F17', 'Derived', 2, 'R9 R10', 'R6', 'F14.F7'),
('animal is a cheetah', 'F18', 'Derived', 3, 'Nil', 'R7', 'F16.F8.F9'),
('animal is a tiger', 'F19', 'Derived', 3, 'Nil', 'R8', 'F16.F8.F10'),
('animal gives milk', 'F2', 'Basic ', 0, 'R2', 'Nil', 'Nil'),
('animal is a giraffe', 'F20', 'Derived', 3, 'Nil', 'R9', 'F17.F8.F9'),
('animal is a zebra', 'F21', 'Derived', 3, 'Nil', 'R10', 'F17.F8.F10'),
('animal is a ostrich', 'F22', 'Derived', 3, 'Nil', 'R11', 'F15.!F4.F11.F12'),
('animal is a albatross', 'F23', 'Derived', 3, 'Nil', 'R12', 'F15.F13'),
('animal has feathers', 'F3', 'Basic', 0, 'R3', 'Nil', 'Nil'),
('animal flies', 'F4', 'Basic', 0, 'R4 R11', 'Nil', 'Nil'),
('animal lays eggs', 'F5', 'Basic', 0, 'R4', 'Nil', 'Nil'),
('animal eats meat', 'F6', 'Basic', 0, 'R5', 'Nil', 'Nil'),
('animal chews grass', 'F7', 'Basic', 0, 'R6', 'Nil', 'Nil'),
('animal has tawny color', 'F8', 'Basic', 0, 'R7 R8 R9 R10', 'Nil', 'Nil'),
('animal has dark spots', 'F9', 'Basic', 0, 'R7 R9', 'Nil', 'Nil');

-- --------------------------------------------------------

--
-- Table structure for table `kb2`
--

CREATE TABLE IF NOT EXISTS `kb2` (
  `rule` varchar(500) NOT NULL,
  `dependFacts` varchar(500) NOT NULL,
  `previousRule` varchar(500) NOT NULL,
  `derived` varchar(500) NOT NULL,
  `nextRule` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kb2`
--

INSERT INTO `kb2` (`rule`, `dependFacts`, `previousRule`, `derived`, `nextRule`) VALUES
('R1', 'F1', 'Nil', 'F14', 'R5 R6'),
('R2', 'F2', 'Nil', 'F14', 'R5 R6'),
('R3', 'F3', 'Nil', 'F15', 'R11 R12'),
('R4', 'F4.F5', 'Nil', 'F15', 'R11 R12'),
('R5', 'F14.F6', 'R1 R2', 'F16', 'R7 R8'),
('R6', 'F14.F7', 'R1 R2', 'F17', 'R9 R10'),
('R7', 'F16.F8.F9', 'R5', 'F18', 'Nil'),
('R8', 'F16.F8.F10', 'R5', 'F19', 'Nil'),
('R9', 'F17.F8.F9', 'R6', 'F20', 'Nil'),
('R10', 'F17.F8.F10', 'R6', 'F21', 'Nil'),
('R11', 'F15.!F4.F11.F12', 'R3 R4', 'F22', 'Nil'),
('R12', 'F15.F13', 'R3 R4', 'F23', 'Nil');
