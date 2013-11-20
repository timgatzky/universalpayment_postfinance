-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the Contao    *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_form_field`
-- 

CREATE TABLE `tl_form_field` (
	`up_postfinanceJumpToComplete` int(10) unsigned NOT NULL default '0',
	`up_postfinanceUrlParams` text NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
	`up_postfinanceJumpToComplete` int(10) unsigned NOT NULL default '0',  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_content`
-- 

CREATE TABLE `tl_content` (
	`up_postfinanceJumpToComplete` int(10) unsigned NOT NULL default '0',  
) ENGINE=MyISAM DEFAULT CHARSET=utf8;