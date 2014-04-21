<?php
namespace wcf\system\faker;
use \wcf\data\user\User;
use \wcf\system\WCF;

/**
 * Creates messages in conversations.
 * 
 * @author	Maximilian Mader
 * @copyright	2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class ConversationMessageFaker extends AbstractFaker {
	/**
	 * number of conversations
	 * 
	 * @var	integer
	 */
	public $conversationCount = 0;
	
	public function __construct(\Faker\Generator $generator, array $parameters) {
		parent::__construct($generator, $parameters);
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_conversation
			WHERE		isDraft = ?
				AND	isClosed = ?";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute(array(0, 0));
		
		$this->conversationCount = $statement->fetchColumn();
	}
	
	/**
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$sql = "SELECT		userID, username, conversationID, lastPostTime, participantSummary
			FROM		wcf".WCF_N."_conversation
			WHERE		isDraft = ?
				AND	isClosed = ?
			ORDER BY	conversationID ASC";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1, $this->conversationCount - 1 ? $this->generator->numberBetween(0, $this->conversationCount - 1) : 0);
		$statement->execute(array(0, 0));
		
		$conversation = $statement->fetchObject('\wcf\data\conversation\Conversation');
		$participants = unserialize($conversation->participantSummary);
		
		$conversationAuthor = array(
			'userID' => $conversation->userID,
			'username' => $conversation->username
		);
		
		$users = array_merge(array($conversationAuthor), $participants);
		$sender = $this->generator->randomElement($users);
		
		$messageData = array(
			'data' => array(
				'conversationID' => $conversation->conversationID,
				'message' => $this->generator->realText($this->generator->numberBetween(10, 10000)),
				'time' => $this->generator->numberBetween($conversation->lastPostTime, TIME_NOW),
				'userID' => $sender['userID'],
				'username' => $sender['username'],
				'enableBBCodes' => 0,
				'enableHtml' => 0,
				'enableSmilies' => 0,
				'showSignature' => 1
			)
		);
		
		$objectAction = new \wcf\data\conversation\message\ConversationMessageAction(array(), 'create', $messageData);
		$objectAction->executeAction();
	}
}
