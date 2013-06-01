<?php
namespace wcf\system\faker;
use \wcf\data\user\User;

/**
 * Creates fake tags.
 * 
 * @author	Maximilian Mader
 * @copyright	2013 Maximilian Mader
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class TagFaker extends AbstractFaker {
	/**
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		// TEMPORARY
		$this->language = \wcf\system\language\LanguageFactory::getInstance()->getLanguageByCode(substr($this->parameters['fakerLocale'], 0, 2));
		// TEMPORARY
		
		$multiWordChance = (isset($this->parameters['multiWordChance'])) ? $this->parameters['multiWordChance'] : 10;
		$multiWordCountMin = (isset($this->parameters['multiWordCountMin'])) ? $this->parameters['multiWordCountMin'] : 2;
		$multiWordCountMax = (isset($this->parameters['multiWordCountMax'])) ? $this->parameters['multiWordCountMax'] : 5;
		
		if ($this->generator->boolean($multiWordChance)) {
			// this tag will be multiple words
			$tag = $_tag = \wcf\util\StringUtil::substring($this->generator->words($this->generator->randomNumber($multiWordCountMin, $multiWordCountMax), true), 0, 251);
			
			while (\wcf\data\tag\Tag::getTag($_tag, $this->language->languageID) !== null) {
				$_tag = $tag . $this->generator->randomNumber(4);
			}
			
			$tag = $_tag;
		}
		else {
			// this tag will be a single word
			$tag = $_tag = $this->generator->word;
			
			while (\wcf\data\tag\Tag::getTag($_tag, $this->language->languageID) !== null) {
				$_tag = $tag . $this->generator->randomNumber(8);
			}
			
			$tag = $_tag;
		}
		
		// save tag
		$objectAction = new \wcf\data\tag\TagAction(array(), 'create', array('data' => array(
			'name' => $tag,
			'languageID' => $this->language->languageID
		)));
		
		$objectAction->executeAction();
	}
}
