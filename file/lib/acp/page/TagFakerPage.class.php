<?php
namespace wcf\acp\page;
use \wcf\data\user\group\UserGroup;

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
}