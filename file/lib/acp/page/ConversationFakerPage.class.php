<?php
namespace wcf\acp\page;

/**
 * Shows the conversation faker page.
 * 
 * @author	Maximilian Mader
 * @copyright	2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	acp.page
 */
class ConversationFakerPage extends AbstractFakerPage {
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.faker.conversations';
	
	/**
	 * number of conversations
	 * 
	 * @var	integer
	 */
	public $conversationCount = 0;
	
	/**
	 * number of registered users
	 * @var	integer
	 */
	public $userCount = 0;
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		\wcf\system\WCF::getTPL()->assign(array(
			'conversationCount' => $this->conversationCount,
			'userCount' => $this->userCount
		));
	}
	
	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_conversation
			WHERE	isDraft = ?
				AND	isClosed = ?";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute(array(0, 0));
		
		$this->conversationCount = $statement->fetchColumn();
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_user";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		
		$this->userCount = $statement->fetchColumn();
	}
}
