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
 * Globals
 */
// register module
$GLOBALS['UNIVERSALPAYMENT']['PAYMENT_METHOD']['postfinance'] = true;
// register class files for this payment method
$GLOBALS['UNIVERSALPAYMENT']['PAYMENT_MOD']['postfinance'] = 'ModuleUniversalPaymentPostfinance';
$GLOBALS['UNIVERSALPAYMENT']['PAYMENT_FFD']['postfinance'] = 'UniversalPaymentPostfinanceField';
$GLOBALS['UNIVERSALPAYMENT']['PAYMENT_CTE']['postfinance'] = 'ContentUniversalPaymentPostfinance';


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['validateFormField'][] = array('UniversalPaymentPostfinance', 'validateWidget');
$GLOBALS['TL_HOOKS']['processFormData'][] = array('UniversalPaymentPostfinance', 'redirectToPaymentSite');
