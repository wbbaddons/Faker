<?php
namespace wcf\system\faker;

/**
 * Creates fake wall responses.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 - 2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
abstract class AbstractCommentResponseFaker extends AbstractFaker {
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
	public $commentCount = 0;
	
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
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_comment
			WHERE	objectTypeID = ?";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->objectTypeID));
		
		$this->commentCount = $statement->fetchColumn();
	}
	
	/**
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$sql = "SELECT		*
			FROM		wcf".WCF_N."_comment
			WHERE		objectTypeID = ?";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->commentCount - 1));
		$statement->execute(array($this->objectTypeID));
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
		$responseIDs = $target->getResponseIDs();
		if (count($responseIDs) < 3) $responseIDs[] = $response->responseID;
		$responses = $target->responses + 1;
		
		// update comment
		$commentEditor = new \wcf\data\comment\CommentEditor($target);
		$commentEditor->update(array(
			'responseIDs' => serialize($responseIDs),
			'responses' => $responses
		));
		
		// update counter
		$this->objectType->getProcessor()->updateCounter($target->objectID, 1);
	}
}
