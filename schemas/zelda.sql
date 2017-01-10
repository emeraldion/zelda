-- phpMyAdmin SQL Dump
-- version 2.8.0.2
-- http://www.phpmyadmin.net
-- 
-- Host: sql.emeraldion.it
-- Generation Time: Jan 10, 2017 at 07:53 PM
-- Server version: 5.1.49
-- PHP Version: 4.3.10-22
-- 
-- Database: `zelda`
-- 
CREATE DATABASE `zelda` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `zelda`;

-- --------------------------------------------------------

-- 
-- Table structure for table `blocked_ips`
-- 

CREATE TABLE `blocked_ips` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_addr` varchar(15) NOT NULL,
  `blocked_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_addr` (`ip_addr`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=latin1 COMMENT='List of blocked IPs' AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `blocked_visits`
-- 

CREATE TABLE `blocked_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gate` text NOT NULL,
  `ip_addr` varchar(15) NOT NULL DEFAULT '',
  `user_agent` text,
  `params` text NOT NULL,
  `referrer` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `ip_addr` (`ip_addr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `blogroll_entries`
-- 

CREATE TABLE `blogroll_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `URL` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='I blog che seguo' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `books`
-- 

CREATE TABLE `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `author` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(255) NOT NULL DEFAULT '',
  `bol_id` varchar(255) NOT NULL DEFAULT '',
  `bol_category` varchar(255) NOT NULL DEFAULT '',
  `kind` enum('essay','novel','computer') NOT NULL DEFAULT 'novel',
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COMMENT='Elenco dei libri letti' AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `clients`
-- 

CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Clients that have enjoyed Claudio''s services.' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `diario_comments`
-- 

CREATE TABLE `diario_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(24) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `post_id` int(11) NOT NULL DEFAULT '0',
  `text` text COLLATE latin1_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `URL` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `email` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ip_addr` varchar(15) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_agent` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `followup_email_notify` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=567 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=567 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `diario_pingbacks`
-- 

CREATE TABLE `diario_pingbacks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `created_at` datetime NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1 COMMENT='Pingbacks for Diario posts' AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `diario_posts`
-- 

CREATE TABLE `diario_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` text COLLATE latin1_general_ci NOT NULL,
  `text` text COLLATE latin1_general_ci NOT NULL,
  `author` varchar(24) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `status` enum('pubblicato','bozza','rimosso') COLLATE latin1_general_ci NOT NULL DEFAULT 'bozza',
  `readings` int(11) NOT NULL DEFAULT '0',
  `external_url` varchar(128) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=352 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Contiene i post del Diario (weblog)' AUTO_INCREMENT=352 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `diario_posts_tags`
-- 

CREATE TABLE `diario_posts_tags` (
  `post_id` int(10) unsigned NOT NULL DEFAULT '0',
  `tag_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Many to many relation between Diario posts and Tags';

-- --------------------------------------------------------

-- 
-- Table structure for table `google_groups_entries`
-- 

CREATE TABLE `google_groups_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int(10) unsigned NOT NULL DEFAULT '0',
  `url` text COLLATE latin1_general_ci NOT NULL,
  `email` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `software_id` (`software_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Google Groups URLs and emails' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `hosts`
-- 

CREATE TABLE `hosts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_addr` varchar(15) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip_addr` (`ip_addr`)
) ENGINE=MyISAM AUTO_INCREMENT=1597 DEFAULT CHARSET=latin1 COMMENT='Cache dei lookup dei nomi host' AUTO_INCREMENT=1597 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `iusethis_entries`
-- 

CREATE TABLE `iusethis_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `software_id` int(11) NOT NULL DEFAULT '0',
  `iusethis_name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='IUseThis entries for software products' AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `macupdate_entries`
-- 

CREATE TABLE `macupdate_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rating` float NOT NULL DEFAULT '0',
  `mu_title` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='MacUpdate entries and ratings for Software' AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `outbounds`
-- 

CREATE TABLE `outbounds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `gate` text NOT NULL,
  `occurred_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21728 DEFAULT CHARSET=latin1 COMMENT='Outbound links' AUTO_INCREMENT=21728 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `password_requests`
-- 

CREATE TABLE `password_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hash` varchar(32) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Requests for new passwords.' AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `people`
-- 

CREATE TABLE `people` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COMMENT='Persone' AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `projects`
-- 

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(48) CHARACTER SET utf8 DEFAULT NULL,
  `summary` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `projects_tags`
-- 

CREATE TABLE `projects_tags` (
  `project_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  UNIQUE KEY `project_id_2` (`project_id`,`tag_id`),
  KEY `tag_id` (`tag_id`),
  KEY `project_id` (`project_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `registrations`
-- 

CREATE TABLE `registrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int(10) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `license_type` tinyint(4) NOT NULL,
  `registered_on` date DEFAULT NULL,
  `expires_on` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='Registrations of software Singular' AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `server_errors`
-- 

CREATE TABLE `server_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` smallint(6) NOT NULL DEFAULT '0',
  `description` text COLLATE latin1_general_ci NOT NULL,
  `occurred_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4568 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Log of server errors (404''s, etc.)' AUTO_INCREMENT=4568 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `softpedia_clean_awards`
-- 

CREATE TABLE `softpedia_clean_awards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `software_id` (`software_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='URLs for Softpedia Clean Awards' AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `software_artifacts`
-- 

CREATE TABLE `software_artifacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int(10) unsigned NOT NULL DEFAULT '0',
  `release_id` int(10) unsigned NOT NULL DEFAULT '0',
  `file` varchar(255) NOT NULL DEFAULT '',
  `URL` varchar(255) NOT NULL DEFAULT '',
  `downloads` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `visible` tinyint(4) NOT NULL DEFAULT '1',
  `priority` tinyint(4) DEFAULT '0',
  `enabled` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=501 DEFAULT CHARSET=latin1 COMMENT='Lista dei download dei software' AUTO_INCREMENT=501 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `software_comments`
-- 

CREATE TABLE `software_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `software_id` int(10) unsigned NOT NULL DEFAULT '0',
  `author` varchar(24) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `text` text COLLATE latin1_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `URL` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `email` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ip_addr` varchar(15) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_agent` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `followup_email_notify` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3062 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Commenti sul software' AUTO_INCREMENT=3062 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `software_downloads`
-- 

CREATE TABLE `software_downloads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `artifact_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24095 DEFAULT CHARSET=latin1 COMMENT='Log of software downloads' AUTO_INCREMENT=24095 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `software_pingbacks`
-- 

CREATE TABLE `software_pingbacks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `created_at` datetime NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COMMENT='Pingbacks for Software items' AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `software_quotes`
-- 

CREATE TABLE `software_quotes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int(10) unsigned NOT NULL DEFAULT '0',
  `quote` text COLLATE latin1_general_ci NOT NULL,
  `author` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `url` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Quotes by enthusiastic software users' AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `software_releases`
-- 

CREATE TABLE `software_releases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int(10) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changes` text NOT NULL,
  `version` varchar(15) NOT NULL DEFAULT '',
  `released` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=233 DEFAULT CHARSET=latin1 COMMENT='Lista delle release dei software' AUTO_INCREMENT=233 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `software_typos`
-- 

CREATE TABLE `software_typos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typo` varchar(255) NOT NULL,
  `software_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COMMENT='Common typos for software names (useful to redirect old name' AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `softwares`
-- 

CREATE TABLE `softwares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL DEFAULT '',
  `market` varchar(5) NOT NULL DEFAULT 'intl',
  `license` enum('freeware','donationware','shareware','commercial','demo','adware','free software','public beta') DEFAULT 'freeware',
  `title` varchar(24) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `type` varchar(24) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `spam_signatures`
-- 

CREATE TABLE `spam_signatures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `signature` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `signature` (`signature`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `tags`
-- 

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Tags for taxonomy' AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `titlebar_messages`
-- 

CREATE TABLE `titlebar_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text COLLATE latin1_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` enum('info') COLLATE latin1_general_ci NOT NULL DEFAULT 'info',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Messages that are visualized in the titlebar' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `user_logins`
-- 

CREATE TABLE `user_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `performed_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Record of user logins' AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(12) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `password` varchar(32) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `first` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `last` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `version_tracker_entries`
-- 

CREATE TABLE `version_tracker_entries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `software_id` int(10) unsigned NOT NULL DEFAULT '0',
  `rating` float NOT NULL DEFAULT '0',
  `mu_title` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `vt_id` int(11) NOT NULL,
  `url` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='VersionTracker entries and ratings for Software' AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `visits`
-- 

CREATE TABLE `visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gate` text COLLATE latin1_general_ci NOT NULL,
  `ip_addr` varchar(15) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_agent` text COLLATE latin1_general_ci NOT NULL,
  `params` text COLLATE latin1_general_ci NOT NULL,
  `referrer` text COLLATE latin1_general_ci NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=790686 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=790686 ;
