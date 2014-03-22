<?php
namespace wcf\acp\page;
use \wcf\data\user\group\UserGroup;

/**
 * Shows the user faker page.
 * 
 * @author	Matthias Schmidt
 * @copyright	2013 Matthias Schmidt
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	acp.page
 */
class UserFakerPage extends AbstractFakerPage {
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.faker.user';
	
	/**
	 * list of available user grouop
	 * @var	array<\wcf\data\user\group\UserGroup>
	 */
	public $userGroups = array();
	
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
			'userGroups' => $this->userGroups,
			'userCount' => $this->userCount
		));
	}
	
	/**
	 * @see	\wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		$this->userGroups = UserGroup::getGroupsByType(array(), array(
			UserGroup::EVERYONE,
			UserGroup::GUESTS,
			UserGroup::USERS
		));
		
		foreach ($this->userGroups as $key => $group) {
			if ($group->isAdminGroup()) unset($this->userGroups[$key]);
		}
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_user";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		
		$this->userCount = $statement->fetchColumn();
	}
}
