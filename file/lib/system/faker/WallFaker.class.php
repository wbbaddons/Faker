<?php
namespace wcf\system\faker;

/**
 * Creates fake wall posts.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class WallFaker extends AbstractFaker {
	/**
	 * number of user accounts
	 * 
	 * @var	integer
	 */
	public $userCount = 0;
	
	/**
	 * object type id of profile comments
	 * 
	 * @var	integer
	 */
	public $objectTypeID = 0;
	
	/**
	 * object type matching the object type id
	 * 
	 * @var	\wcf\data\object\type\ObjectType
	 */
	public $objectType = null;
	
	/**
	 * @see	\wcf\system\faker\AbstractFaker::__construct()
	 */
	public function __construct(\Faker\Generator $generator, array $parameters) {
		parent::__construct($generator, $parameters);
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_user";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		
		$this->userCount = $statement->fetchColumn();
		
		$this->objectTypeID = \wcf\system\comment\CommentHandler::getInstance()->getObjectTypeID('com.woltlab.wcf.user.profileComment');
		$this->objectType = \wcf\data\object\type\ObjectTypeCache::getInstance()->getObjectType($this->objectTypeID);
	}
	
	/**
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$sql = "SELECT		userID, registrationDate
			FROM		wcf".WCF_N."_user
			ORDER BY	userID ASC";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->userCount - 1));
		$statement->execute();
		$target = $statement->fetchObject('\wcf\data\user\User');
		
		$sql = "SELECT		userID, username, registrationDate
			FROM		wcf".WCF_N."_user
			ORDER BY	userID ASC";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->userCount - 1));
		$statement->execute();
		$sender = $statement->fetchObject('\wcf\data\user\User');
		
		// create comment
		$comment = \wcf\data\comment\CommentEditor::create(array(
			'objectTypeID' => $this->objectTypeID,
			'objectID' => $target->userID,
			'time' => $this->generator->numberBetween(max($sender->registrationDate, $target->registrationDate), TIME_NOW),
			'userID' => $sender->userID,
			'username' => $sender->username,
			'message' => $this->generator->text($this->generator->numberBetween(10, 5000)),
			'responses' => 0,
			'lastResponseIDs' => serialize(array())
		));
		
		// update counter
		$this->objectType->getProcessor()->updateCounter($this->objectTypeID, 1);
	}
}
