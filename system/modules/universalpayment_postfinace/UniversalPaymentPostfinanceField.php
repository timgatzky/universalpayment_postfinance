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
 * Imports
 */
use UniversalPayment\Factory as UniversalPayment;
use UniversalPayment\Core\SessionFactory as PaymentSession;
use UniversalPayment\Frontend\Formfield\PaymentField as PaymentField;

/**
 * Class file
 */
class UniversalPaymentPostfinanceField extends PaymentField
{	
	/**
	 * Generate field
	 * @return string	html string output
	 */
	protected function compile()
	{
		// generate a orderid for this payment (8 digits)
		$objPaymentSession = PaymentSession::getInstance();
		
		// get session information form unique id
		$arrPayment = $objPaymentSession->findItemByUnique($this->uniqueId);
		
		$this->orderId = $arrPayment['orderId'];
		
		if(!$this->orderId)
		{
			$this->orderId= UniversalPayment::getInstance()->generatePassword(8,'0123456789');
			// store order id for this payment instance in session
			$arrPayment['orderId'] = $this->orderId;
			$objPaymentSession->setItem($arrPayment);
		}
		
		return '';
	}
	
	/**
	 * Process post sale actions
	 * @return object	self
	 */
	public function processPostSale()
	{
		// current order object
		$objOrder = $this->order;
		
		// set data for parent ModulePayment instance
		parent::set('postsale',$_POST);
		
		// return this object with all its settings for further use
		return $this;
	}
	
	/**
	 * Process pre sale actions
	 * @return object	self
	 */
	public function processPreSale() 
	{
		// do something here
		return $this;
	}
}