<?php
namespace wcf\system\faker;

/**
 * Creates fake wall posts.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 - 2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class WallFaker extends AbstractCommentFaker {
	/**
	 * user whose wall will be commented
	 * 
	 * @var	\wcf\data\user\User
	 */
	protected $receiver = null;
	
	/**
	 * @see	\wcf\system\faker\AbstractFaker::__construct()
	 */
	public function __construct(\Faker\Generator $generator, array $parameters) {
		parent::__construct($generator, $parameters);
		
		$this->objectTypeID = \wcf\system\comment\CommentHandler::getInstance()->getObjectTypeID('com.woltlab.wcf.user.profileComment');
		$this->objectType = \wcf\data\object\type\ObjectTypeCache::getInstance()->getObjectType($this->objectTypeID);
	}
	
	/**
	 * @see	\wcf\system\faker\AbstractFaker::fake()
	 */
	public function fake() {
		$this->getObject();
		
		parent::fake();
	}
	
	/**
	 * Fetches a user from the database.
	 */
	protected function getObject() {
		$sql = "SELECT		userID, registrationDate
			FROM		wcf".WCF_N."_user
			ORDER BY	userID ASC";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1, $this->userCount - 1 ? $this->generator->numberBetween(0, $this->userCount - 1) : 0);
		$statement->execute();
		$this->receiver = $statement->fetchObject('\wcf\data\user\User');
	}
	
	/**
	 * @see	\wcf\system\faker\AbstractCommentFaker::getObjectID()
	 */
	public function getObjectID() {
		return $this->receiver->userID;
	}
	
	/**
	 * @see	\wcf\system\faker\AbstractCommentFaker::getCreationTime()
	 */
	public function getCreationTime() {
		return $this->receiver->registrationDate;
	}
}
