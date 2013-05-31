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
class WallResponseFaker extends AbstractFaker {
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
	 * number of wall comments
	 * 
	 * @var	integer
	 */
	public $wallCommentCount = 0;
	
	/**
	 * valid wall comment IDs
	 * 
	 * @var	array<integer>
	 */
	public $wallCommentIDs = array();
	
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
		
		$sql = "SELECT	commentID
			FROM	wcf".WCF_N."_comment
			WHERE	objectTypeID = ?";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->objectTypeID));
		
		$this->wallCommentIDs = array();
		while ($commentID = $statement->fetchColumn()) $this->wallCommentIDs[] = $commentID;
		$this->wallCommentCount = count($this->wallCommentIDs);
	}
	
	/**
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$sql = "SELECT		*
			FROM		wcf".WCF_N."_comment
			WHERE		commentID = ?";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1);
		$statement->execute(array($this->wallCommentIDs[$this->generator->numberBetween(0, $this->wallCommentCount - 1)]));
		$target = $statement->fetchObject('\wcf\data\comment\Comment');
		
		$sql = "SELECT		userID, username, registrationDate
			FROM		wcf".WCF_N."_user
			ORDER BY	userID ASC";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->userCount - 1));
		$statement->execute();
		$sender = $statement->fetchObject('\wcf\data\user\User');
		
		// create response
		$response = \wcf\data\comment\response\CommentResponseEditor::create(array(
			'commentID' => $target->commentID,
			'time' => $this->generator->numberBetween(max($sender->registrationDate, $target->time), TIME_NOW),
			'userID' => $sender->userID,
			'username' => $sender->username,
			'message' => $this->generator->text($this->generator->numberBetween(10, 5000))
		));
		
		// update response data
		$lastResponseIDs = $target->getLastResponseIDs();
		if (count($lastResponseIDs) == 3) array_shift($lastResponseIDs);
		$lastResponseIDs[] = $response->responseID;
		$responses = $target->responses + 1;
		
		// update comment
		$commentEditor = new \wcf\data\comment\CommentEditor($target);
		$commentEditor->update(array(
			'lastResponseIDs' => serialize($lastResponseIDs),
			'responses' => $responses
		));
		
		// update counter
		$this->objectType->getProcessor()->updateCounter($target->objectID, 1);
	}
}
