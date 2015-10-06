# phpMyAdmin MySQL-Dump
# version 2.2.1-dev
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# Host: members-paid-e.db.lyceu.net:3320
# Generato il: 14 Lug, 2008 at 03:06 PM
# Versione MySQL: 3.23.33
# Versione PHP: 4.3.9
# Database : `emeraldion_it_3`
# --------------------------------------------------------

#
# Struttura della tabella `blocked_ips`
#

CREATE TABLE `blocked_ips` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip_addr` varchar(15) NOT NULL,
  `blocked_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ip_addr` (`ip_addr`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1 COMMENT='List of blocked IPs';
# --------------------------------------------------------

#
# Struttura della tabella `blocked_visits`
#

CREATE TABLE `blocked_visits` (
  `id` int(11) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `gate` text NOT NULL,
  `ip_addr` varchar(15) NOT NULL default '',
  `user_agent` text,
  `params` text NOT NULL,
  `referrer` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`),
  KEY `ip_addr` (`ip_addr`)
) ENGINE=MyISAM AUTO_INCREMENT=2111173 DEFAULT CHARSET=latin1;
# --------------------------------------------------------

#
# Struttura della tabella `blogroll_entries`
#

CREATE TABLE `blogroll_entries` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `URL` varchar(255) NOT NULL default '',
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='I blog che seguo';
# --------------------------------------------------------

#
# Struttura della tabella `books`
#

CREATE TABLE `books` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `author` varchar(255) NOT NULL default '',
  `editor` varchar(255) NOT NULL default '',
  `bol_id` varchar(255) NOT NULL default '',
  `bol_category` varchar(255) NOT NULL default '',
  `kind` enum('essay','novel','computer') NOT NULL default 'novel',
  `date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COMMENT='Elenco dei libri letti';
# --------------------------------------------------------

#
# Struttura della tabella `clients`
#

CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Clients that have enjoyed Claudio''s services.';
# --------------------------------------------------------

#
# Struttura della tabella `diario_comments`
#

CREATE TABLE `diario_comments` (
  `id` int(11) NOT NULL auto_increment,
  `author` varchar(24) collate latin1_general_ci NOT NULL default '',
  `post_id` int(11) NOT NULL default '0',
  `text` text collate latin1_general_ci NOT NULL,
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `URL` varchar(64) collate latin1_general_ci NOT NULL default '',
  `email` varchar(64) collate latin1_general_ci NOT NULL default '',
  `ip_addr` varchar(15) collate latin1_general_ci NOT NULL default '',
  `user_agent` varchar(255) collate latin1_general_ci NOT NULL default '',
  `approved` tinyint(4) NOT NULL default '0',
  `followup_email_notify` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=311 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
# --------------------------------------------------------

#
# Struttura della tabella `diario_pingbacks`
#

CREATE TABLE `diario_pingbacks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `post_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `created_at` datetime NOT NULL,
  `approved` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1 COMMENT='Pingbacks for Diario posts';
# --------------------------------------------------------

#
# Struttura della tabella `diario_posts`
#

CREATE TABLE `diario_posts` (
  `id` int(11) NOT NULL auto_increment,
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` text collate latin1_general_ci NOT NULL,
  `text` text collate latin1_general_ci NOT NULL,
  `author` varchar(24) collate latin1_general_ci NOT NULL default '',
  `status` enum('pubblicato','bozza','rimosso') collate latin1_general_ci NOT NULL default 'bozza',
  `readings` int(11) NOT NULL default '0',
  `external_url` varchar(128) collate latin1_general_ci NULL default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=331 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Contiene i post del Diario (weblog)';
# --------------------------------------------------------

#
# Struttura della tabella `diario_posts_tags`
#

CREATE TABLE `diario_posts_tags` (
  `post_id` int(10) unsigned NOT NULL default '0',
  `tag_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Many to many relation between Diario posts and Tags';
# --------------------------------------------------------

#
# Struttura della tabella `google_groups_entries`
#

CREATE TABLE `google_groups_entries` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `software_id` int(10) unsigned NOT NULL default '0',
  `url` text collate latin1_general_ci NOT NULL,
  `email` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `software_id` (`software_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Google Groups URLs and emails';
# --------------------------------------------------------

#
# Struttura della tabella `hosts`
#

CREATE TABLE `hosts` (
  `id` int(11) NOT NULL auto_increment,
  `ip_addr` varchar(15) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `last_update` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ip_addr` (`ip_addr`)
) ENGINE=MyISAM AUTO_INCREMENT=482690 DEFAULT CHARSET=latin1 COMMENT='Cache dei lookup dei nomi host';
# --------------------------------------------------------

#
# Struttura della tabella `iusethis_entries`
#

CREATE TABLE `iusethis_entries` (
  `id` int(11) NOT NULL auto_increment,
  `software_id` int(11) NOT NULL default '0',
  `iusethis_name` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='IUseThis entries for software products';
# --------------------------------------------------------

#
# Struttura della tabella `macupdate_entries`
#

CREATE TABLE `macupdate_entries` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `software_id` int(10) unsigned NOT NULL default '0',
  `rating` float NOT NULL default '0',
  `mu_title` varchar(255) collate latin1_general_ci NOT NULL default '',
  `url` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='MacUpdate entries and ratings for Software';
# --------------------------------------------------------

#
# Struttura della tabella `outbounds`
#

CREATE TABLE `outbounds` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url` text NOT NULL,
  `gate` text NOT NULL,
  `occurred_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=863 DEFAULT CHARSET=latin1 COMMENT='Outbound links';
# --------------------------------------------------------

#
# Struttura della tabella `password_requests`
#

CREATE TABLE `password_requests` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `hash` varchar(32) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Requests for new passwords.';
# --------------------------------------------------------

#
# Struttura della tabella `people`
#

CREATE TABLE `people` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COMMENT='Persone';
# --------------------------------------------------------

#
# Struttura della tabella `registrations`
#

CREATE TABLE `registrations` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `software_id` int(10) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `license_type` tinyint(4) NOT NULL,
  `registered_on` date default NULL,
  `expires_on` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Registrations of software Singular';
# --------------------------------------------------------

#
# Struttura della tabella `server_errors`
#

CREATE TABLE `server_errors` (
  `id` int(11) NOT NULL auto_increment,
  `code` smallint(6) NOT NULL default '0',
  `description` text collate latin1_general_ci NOT NULL,
  `occurred_at` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58398 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Log of server errors (404''s, etc.)';
# --------------------------------------------------------

#
# Struttura della tabella `softpedia_clean_awards`
#

CREATE TABLE `softpedia_clean_awards` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `software_id` int(11) NOT NULL default '0',
  `url` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `software_id` (`software_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='URLs for Softpedia Clean Awards';
# --------------------------------------------------------

#
# Struttura della tabella `software_artifacts`
#

CREATE TABLE `software_artifacts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `software_id` int(10) unsigned NOT NULL default '0',
  `release_id` int(10) unsigned NOT NULL default '0',
  `file` varchar(255) NOT NULL default '',
  `URL` varchar(255) NOT NULL default '',
  `downloads` int(10) unsigned NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `visible` tinyint(4) NOT NULL default '1',
  `priority` tinyint(4) default '0',
  `enabled` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=491 DEFAULT CHARSET=latin1 COMMENT='Lista dei download dei software';
# --------------------------------------------------------

#
# Struttura della tabella `software_comments`
#

CREATE TABLE `software_comments` (
  `id` int(11) NOT NULL auto_increment,
  `software_id` int(10) unsigned NOT NULL default '0',
  `author` varchar(24) collate latin1_general_ci NOT NULL default '',
  `text` text collate latin1_general_ci NOT NULL,
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `URL` varchar(64) collate latin1_general_ci NOT NULL default '',
  `email` varchar(64) collate latin1_general_ci NOT NULL default '',
  `ip_addr` varchar(15) collate latin1_general_ci NOT NULL default '',
  `user_agent` varchar(255) collate latin1_general_ci NOT NULL default '',
  `approved` tinyint(4) NOT NULL default '0',
  `followup_email_notify` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=999 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Commenti sul software';
# --------------------------------------------------------

#
# Struttura della tabella `software_downloads`
#

CREATE TABLE `software_downloads` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `artifact_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24095 DEFAULT CHARSET=latin1 COMMENT='Log of software downloads';
# --------------------------------------------------------

#
# Struttura della tabella `software_pingbacks`
#

CREATE TABLE `software_pingbacks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `software_id` int(10) unsigned default NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `created_at` datetime NOT NULL,
  `approved` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COMMENT='Pingbacks for Software items';
# --------------------------------------------------------

#
# Struttura della tabella `software_quotes`
#

CREATE TABLE `software_quotes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `software_id` int(10) unsigned NOT NULL default '0',
  `quote` text collate latin1_general_ci NOT NULL,
  `author` varchar(255) collate latin1_general_ci NOT NULL default '',
  `url` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Quotes by enthusiastic software users';
# --------------------------------------------------------

#
# Struttura della tabella `software_releases`
#

CREATE TABLE `software_releases` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `software_id` int(10) unsigned NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `changes` text NOT NULL,
  `version` varchar(15) NOT NULL default '',
  `released` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=225 DEFAULT CHARSET=latin1 COMMENT='Lista delle release dei software';
# --------------------------------------------------------

#
# Struttura della tabella `software_typos`
#

CREATE TABLE `software_typos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `typo` varchar(255) NOT NULL,
  `software_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COMMENT='Common typos for software names (useful to redirect old name';
# --------------------------------------------------------

#
# Struttura della tabella `softwares`
#

CREATE TABLE `softwares` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(24) NOT NULL default '',
  `market` varchar(5) NOT NULL default 'intl',
  `license` enum('freeware','donationware','shareware','commercial','demo','adware','free software','public beta') default 'freeware',
  `title` varchar(24) NOT NULL default '',
  `description` text NOT NULL,
  `type` varchar(24) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
# --------------------------------------------------------

#
# Struttura della tabella `tags`
#

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(255) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Tags for taxonomy';
# --------------------------------------------------------

#
# Struttura della tabella `titlebar_messages`
#

CREATE TABLE `titlebar_messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `message` text collate latin1_general_ci NOT NULL,
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `type` enum('info') collate latin1_general_ci NOT NULL default 'info',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Messages that are visualized in the titlebar';
# --------------------------------------------------------

#
# Struttura della tabella `user_logins`
#

CREATE TABLE `user_logins` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `performed_at` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Record of user logins';
# --------------------------------------------------------

#
# Struttura della tabella `users`
#

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(12) collate latin1_general_ci NOT NULL default '',
  `password` varchar(32) collate latin1_general_ci NOT NULL default '',
  `first` varchar(255) collate latin1_general_ci NOT NULL,
  `last` varchar(255) collate latin1_general_ci NOT NULL,
  `email` varchar(64) collate latin1_general_ci default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
# --------------------------------------------------------

#
# Struttura della tabella `version_tracker_entries`
#

CREATE TABLE `version_tracker_entries` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `software_id` int(10) unsigned NOT NULL default '0',
  `rating` float NOT NULL default '0',
  `mu_title` varchar(255) collate latin1_general_ci NOT NULL default '',
  `vt_id` int(11) NOT NULL,
  `url` text collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='VersionTracker entries and ratings for Software';
# --------------------------------------------------------

#
# Struttura della tabella `visits`
#

CREATE TABLE `visits` (
  `id` int(11) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `gate` text collate latin1_general_ci NOT NULL,
  `ip_addr` varchar(15) collate latin1_general_ci NOT NULL default '',
  `user_agent` text collate latin1_general_ci NOT NULL,
  `params` text collate latin1_general_ci NOT NULL,
  `referrer` text collate latin1_general_ci NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=321639 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
