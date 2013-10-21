<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @copyright	Tim Gatzky 2013
 * @author		Tim Gatzky <info@tim-gatzky.de>
 * @package		universalpayment
 * @subpackage	postfinance
 * @link		http://contao.org
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = array('TableFormFieldUniversalPaymentPostfinance', 'modifyPalette');


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['up_postfinanceJumpToComplete'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['up_postfinanceJumpToComplete'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'eval'                    => array('fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'               	  => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['up_postfinanceUrlParams'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['up_postfinanceUrlParams'],
	'exclude'                 => true,
	'inputType'               => 'textarea',
	'eval'                    => array('style'=>'height:80px;min-height:30px;'),
	'sql'					  => "text NULL",
);