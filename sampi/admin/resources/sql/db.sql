-- phpMyAdmin SQL Dump
-- version 4.0.8deb1
-- http://www.phpmyadmin.net
--
-- SampiCMS database layout
-- This file contains the default layout for the database.
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- TABLES
--

-- --------------------------------------------------------

--
-- TABLE `sampi_comments`
--

CREATE TABLE IF NOT EXISTS `sampi_comments` (
  `comment_nr` smallint(6) NOT NULL AUTO_INCREMENT,
  `post_nr` smallint(6) NOT NULL,
  `commenter` text NOT NULL,
  `comment` text NOT NULL,
  `date` text NOT NULL,
  PRIMARY KEY (`comment_nr`),
  KEY `POST_NR` (`post_nr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- TABLE `sampi_menu`
--

CREATE TABLE IF NOT EXISTS `sampi_menu` (
  `menu_nr` smallint(6) NOT NULL AUTO_INCREMENT,
  `entry_nr` smallint(6) NOT NULL,
  `entry_type` smallint(6) NOT NULL,
  `entry_relation` smallint(6) NOT NULL,
  PRIMARY KEY (`menu_nr`,`entry_nr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- TABLE `sampi_panels`
--

CREATE TABLE IF NOT EXISTS `sampi_panels` (
  `panel_nr` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `filename` text NOT NULL,
  `main` tinyint(1) NOT NULL,
  PRIMARY KEY (`panel_nr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `sampi_panels` (`panel_nr`, `name`, `filename`, `main`) VALUES
(0, 'Post', 'post', 1),
(1, 'General', 'general', 1),
(2, 'Add user', 'add_user', 1),
(3, 'Posts', 'edit_posts', 1),
(4, 'Add static', 'static', 1);

-- --------------------------------------------------------

--
-- TABLE `sampi_posts`
--

CREATE TABLE IF NOT EXISTS `sampi_posts` (
  `post_nr` smallint(6) NOT NULL AUTO_INCREMENT,
  `date` text NOT NULL,
  `date_updated` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `keywords` text NOT NULL,
  PRIMARY KEY (`post_nr`),
  KEY `author` (`author`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- TABLE `sampi_settings`
--

CREATE TABLE IF NOT EXISTS `sampi_settings` (
  `setting_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `setting_name` text NOT NULL,
  `setting_value` text NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- TABLE `sampi_statics`
--

CREATE TABLE IF NOT EXISTS `sampi_statics` (
  `page_nr` smallint(6) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`page_nr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- TABLE `sampi_users`
--

CREATE TABLE IF NOT EXISTS `sampi_users` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `full_name` text NOT NULL,
  `twitter_user` text,
  `facebook_user` text,
  `google_plus_user` text,
  `rights` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- CONSTRAINTS
--

-- --------------------------------------------------------

--
-- CONSTRAINTS `sampi_comments`
--
ALTER TABLE `sampi_comments`
  ADD CONSTRAINT `sampi_comments_ibfk_1` FOREIGN KEY (`post_nr`) REFERENCES `sampi_posts` (`post_nr`) ON DELETE CASCADE ON UPDATE CASCADE;

-- --------------------------------------------------------
  
--
-- CONSTRAINTS `sampi_posts`
--
ALTER TABLE `sampi_posts`
  ADD CONSTRAINT `sampi_posts_ibfk_1` FOREIGN KEY (`author`) REFERENCES `sampi_users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

-- --------------------------------------------------------
