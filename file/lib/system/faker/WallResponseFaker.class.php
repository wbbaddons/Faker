<?php
namespace wcf\system\faker;

/**
 * Creates fake wall responses.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class WallResponseFaker extends AbstractCommentResponseFaker {	
	/**
	 * @see	\wcf\system\faker\AbstractFaker::__construct()
	 */
	public function __construct(\Faker\Generator $generator, array $parameters) {
		$this->objectTypeID = \wcf\system\comment\CommentHandler::getInstance()->getObjectTypeID('com.woltlab.wcf.user.profileComment');
		$this->objectType = \wcf\data\object\type\ObjectTypeCache::getInstance()->getObjectType($this->objectTypeID);
		
		parent::__construct($generator, $parameters);
	}
}
