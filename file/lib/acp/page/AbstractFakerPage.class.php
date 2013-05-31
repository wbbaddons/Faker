<?php
namespace wcf\acp\page;

/**
 * Abstract implementation of a faker page.
 * 
 * @author	Matthias Schmidt
 * @copyright	2013 Matthias Schmidt
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	acp.page
 */
abstract class AbstractFakerPage extends \wcf\page\AbstractPage {
	/**
	 * list of available languages
	 * @var	array<string>
	 */
	public $availableLocals = array();
	
	/**
	 * list of available provider locals
	 * @var	array<string>
	 */
	public static $providerLocals = array(
		'bg_BG',
		'cs_CZ',
		'da_DK',
		'de_AT',
		'de_DE',
		'en_GB',
		'en_US',
		'es_AR',
		'es_ES',
		'fi_FL',
		'it_IT',
		'nl_BE',
		'pl_PL',
		'pt_BR',
		'ru_RU',
		'sk_SK',
		'sr_Cyrl_RS',
		'sr_Latn_RS',
		'sr_RS',
		'tr_TR',
		'ua_UA'
	);
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		\wcf\system\WCF::getTPL()->assign('availableLocals', $this->availableLocals);
	}
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function readData() {
		parent::readData();
		
		foreach (static::$providerLocals as $local) {
			$languageCode = substr($local, 0, 2);
			if (\wcf\system\language\LanguageFactory::getInstance()->getLanguageByCode($languageCode)) {
				$this->availableLocals[$local] = \wcf\system\WCF::getLanguage()->get('wcf.acp.faker.local.'.$local);
			}
		}
	}
}
