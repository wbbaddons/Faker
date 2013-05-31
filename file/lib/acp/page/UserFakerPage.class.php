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
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		$groups = UserGroup::getGroupsByType(array(), array(
			UserGroup::EVERYONE,
			UserGroup::GUESTS,
			UserGroup::USERS
		));
		
		foreach ($groups as $key => $group) {
			if ($group->isAdminGroup()) unset($groups[$key]);
		}
		
		\wcf\system\WCF::getTPL()->assign(array(
			'userGroups' => $groups
		));
	}
}
