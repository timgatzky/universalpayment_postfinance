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


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'ContentUniversalPaymentPostfinance'			=> 'system/modules/universalpayment_postfinance/ContentUniversalPaymentPostfinance.php',
	'ModuleUniversalPaymentPostfinance'				=> 'system/modules/universalpayment_postfinance/ModuleUniversalPaymentPostfinance.php',
	'TableContentUniversalPaymentPostfinance'		=> 'system/modules/universalpayment_postfinance/TableContentUniversalPaymentPostfinance.php',
	'TableModuleUniversalPaymentPostfinance'		=> 'system/modules/universalpayment_postfinance/TableModuleUniversalPaymentPostfinance.php',
	'TableFormFieldUniversalPaymentPostfinance'		=> 'system/modules/universalpayment_postfinance/TableFormFieldUniversalPaymentPostfinance.php',
	'UniversalPaymentPostfinance'					=> 'system/modules/universalpayment_postfinance/UniversalPaymentPostfinance.php',
	'UniversalPaymentPostfinanceField'				=> 'system/modules/universalpayment_postfinance/UniversalPaymentPostfinanceField.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'form_payment_postfinance'         				=> 'system/modules/universalpayment_postfinance/templates',
));
