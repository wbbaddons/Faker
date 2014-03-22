<?php
namespace wcf\acp\page;

/**
 * Shows the tag faker page.
 * 
 * @author	Maximilian Mader
 * @copyright	2013 Maximilian Mader
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	acp.page
 */
class TagFakerPage extends AbstractFakerPage {
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.faker.tags';
	
	/**
	 * number of available tags
	 * 
	 * @var	integer
	 */
	public $tagCount = 0;
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		\wcf\system\WCF::getTPL()->assign('tagCount', $this->tagCount);
	}
	
	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_tag";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		
		$this->tagCount = $statement->fetchColumn();
	}
}
