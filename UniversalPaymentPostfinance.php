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
use UniversalPayment\Core\ModuleFactory as PaymentModule;
use UniversalPayment\Frontend\Formfield\PaymentField as PaymentField;

/**
 * Class file
 */
class UniversalPaymentPostfinance extends \Frontend
{
	/**
	 * Payment Methode name registered
	 * @var string
	 */
	protected $strPaymentMethodName = 'postfinance';
	
	/**
	 * Unique Id
	 * @var string
	 */
	protected $strUniqueId;
	
	/**
	 * Redirect to payment site
	 * @param object
	 * @param object
	 * @param object
	 * called from processFormData HOOK
	 */
	public function redirectToPaymentSite($arrPost, $arrForm, $arrFiles)
	{
		// observe form submits or any other form action related to universal_payment
		$objInput = \Input::getInstance();
		
		$this->strUniqueId = $arrPost['UNIQUE_ID::'.$this->strPaymentMethodName];
		
		if(strlen($this->strUniqueId) < 1)
		{
			return;
		}
		
		$objPaymentSession = PaymentSession::getInstance();
		
		// get session information form unique id
		$arrPayment = $objPaymentSession->findItemByUnique($this->strUniqueId);
		
		if($arrPayment['presale_redirect'] && $arrPayment['uniqueId'] == $this->strUniqueId)
		{	
			$strUrl = $arrPayment['presale_redirect'];
			
			// remove temporary fields from session
			unset($arrPayment['redirect']);
			unset($arrPayment['presale_redirect']);
			$objPaymentSession->setItem($arrPayment);
		
			// redirect
			$this->redirect($strUrl);
		}

	}
	
	
	/**
	 * Validate the widget and redirect
	 * @param Widget object
	 * @param integer
	 * @return Widget object
	 * called from validateFormField Hook
	 */
	public function validateWidget(\Widget $objWidget, $intId)
	{
		if ($objWidget->universalPaymentMethod != $this->strPaymentMethodName)
		{
			return $objWidget;
		}
		
		global $objPage;
		$objInput = \Input::getInstance();
		$objDatabase = \Database::getInstance();
		$objPayment = UniversalPayment::getInstance();
		$objPaymentSession = PaymentSession::getInstance();
		
		// get session information form unique id
		$arrPayment = $objPaymentSession->findItemByIdAndType($objWidget->id,'ffd');
		
		if(empty($arrPayment))
		{
			// set default here or display an error
			$objWidget->addError($GLOBALS['TL_LANG']['MSC']['sessionEnded']);
			return $objWidget;
		}
		
		$this->strUniqueId = $arrPayment['uniqueId'];
		
		// get the payment selector field in this formular
		$objSelect = $objDatabase->prepare("SELECT * FROM tl_form_field WHERE pid=? AND type=?")
						->limit(1)
						->execute($objWidget->pid,'universalpayment_select');
		if($objSelect->numRows < 1)
		{
			// set default here or display an error
			$objWidget->addError($GLOBALS['TL_LANG']['MSC']['noUniversalPaymentSelect']);
			return $objWidget;
		}
		
		// if the selected payment methode is not paypal return here	
		if($objInput->post($objSelect->name) != $this->strPaymentMethodName)
		{
			return $objWidget;
		}
		
		// if a jumpTo page is active and selected, redirect to this page
		if($objWidget->universalPaymentAddJumpTo && $objWidget->universalPaymentJumpTo > 0)
		{
			$arrPayment['redirect'] = $this->replaceInsertTags('{{link_url::'.$objWidget->universalPaymentJumpTo.'}}');
			$arrPayment['presale_redirect'] = $this->replaceInsertTags('{{link_url::'.$objWidget->universalPaymentJumpTo.'}}');
			$objPaymentSession->setItem($arrPayment);
			return $objWidget;
		}
		
		// define url params
		$arrParams = array();
		$arrParams['CURRENCY'] = 'EUR';
		$arrParams['LANGUAGE'] = 'de_DE';
		$arrParams['ORDERID'] = $arrPayment['orderId'];
		
		// overwrite params with user settings
		if(strlen(trim($objWidget->up_postfinanceUrlParams)) > 0)
		{
			$objString = \String::getInstance();
			$strParams = trim($objWidget->up_postfinanceUrlParams);
			//replace spaces with plus symbol
			$strParams = str_replace(' ', '+', $strParams);
			// replace inserttags
			$strParams = $this->replaceInsertTags($strParams);
			// decode unicode 
			$strParams = $objString->decodeEntities($strParams);
			
			$tmp = explode('&', $strParams);
			foreach($tmp as $param)
			{
				$a = explode('=', $param);
				$k = trim($a[0]);
				$v = trim($a[1]);
				
				$arrParams[$k] = $v;
			}
		}
		
		$arrParams['uid'] = $this->strUniqueId;
		
		// add unique to return url
		if(isset($arrParams['ACCEPTURL']))
		{
			// HINT check if any GET params are set before adding the unique id
			$arrParams['ACCEPTURL'] .= '?uid='.$this->strUniqueId;
		}
		elseif(!isset($arrParams['return']))
		{
			$arrParams['ACCEPTURL'] .= 'http://'.$this->replaceInsertTags('{{env::host}}').'/'.$this->replaceInsertTags('{{link_url::'.$objPage->id.'}}');
			$arrParams['ACCEPTURL'] .= '?uid='.$this->strUniqueId;
		}
		
		$objString = \String::getInstance();
		// decode params
		$strParams = $objString->decodeEntities(http_build_query($arrParams));
		
		// build direct paypal url
		$strAction = 'https://e-payment.postfinance.ch/ncol/test/orderstandard.asp';
		$strAction = $strAction.'?'.$strParams;
		
		// build presale url
		$strPresale_action = $this->generateFrontendUrl($objPage->row());
		$strPresale_action .= '?fwd='.$strAction;
		
		// store presale url in payment item session for further use
		$arrPayment['redirect'] = $strAction;
		$arrPayment['presale_redirect'] = $strPresale_action;
		$objPaymentSession->setItem($arrPayment);
		
		$objWidget->redirectUrl = $strPresale_action;
		
		return $objWidget;
	}

}