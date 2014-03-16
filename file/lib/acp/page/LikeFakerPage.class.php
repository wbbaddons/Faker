<?php
namespace wcf\acp\page;

/**
 * Shows the like faker page.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 - 2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	acp.page
 */
class LikeFakerPage extends AbstractFakerPage {
	/**
	 * @see	\wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.faker.likes';
	
	/**
	 * @see	\wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		$commentableContents = \wcf\data\object\type\ObjectTypeCache::getInstance()->getObjectTypes('com.woltlab.wcf.comment.commentableContent');
		
		$commentObjectTypeIDs = array();
		foreach ($commentableContents as $objectType) {
			$commentObjectTypeIDs[$objectType->objectTypeID] = $objectType->objectType;
		}
		
		\wcf\system\WCF::getTPL()->assign(array(
			'commentObjectTypeIDs' => $commentObjectTypeIDs
		));
	}
}
