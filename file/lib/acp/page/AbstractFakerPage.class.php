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
	public $availableLocales = array();
	
	/**
	 * list of available provider locales
	 * @var	array<string>
	 */
	public static $providerLocales = array(
		'bg_BG',
		'cs_CZ',
		'da_DK',
		'de_AT',
		'de_DE',
		'en_AU',
		'en_CA',
		'en_GB',
		'en_PH'
		'en_US',
		'en_ZA',
		'es_AR',
		'es_ES',
		'es_PE',
		'fi_FI',
		'fr_BE',
		'fr_FR',
		'hu_HU'
		'hy_AM',
		'is_IS',
		'it_IT',
		'ja_JP',
		'lv_LV',
		'nl_BE',
		'nl_NL',
		'pl_PL',
		'pt_BR',
		'ro_MD',
		'ro_RO',
		'ru_RU',
		'sk_SK',
		'sr_Cyrl_RS',
		'sr_Latn_RS',
		'sr_RS',
		'tr_TR',
		'uk_UA',
		'zh_CN'
	);
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		\wcf\system\WCF::getTPL()->assign('availableLocales', $this->availableLocales);
	}
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function readData() {
		parent::readData();
		
		foreach (static::$providerLocales as $locale) {
			$languageCode = substr($locale, 0, 2);
			if (\wcf\system\language\LanguageFactory::getInstance()->getLanguageByCode($languageCode)) {
				$this->availableLocales[$locale] = \wcf\system\WCF::getLanguage()->get('wcf.acp.faker.locale.'.$locale);
			}
		}
	}
}
