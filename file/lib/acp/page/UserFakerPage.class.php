<?php
namespace wcf\acp\page;

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
		
		\wcf\system\WCF::getTPL()->assign(array(
			'userGroups' => \wcf\data\user\group\UserGroup::getGroupsByType(array(\wcf\data\user\group\UserGroup::OTHER))
		));
	}
}
