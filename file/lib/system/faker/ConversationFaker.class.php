<?php
namespace wcf\system\faker;
use \wcf\data\user\User;
use \wcf\system\WCF;

/**
 * Creates fake conversations.
 * 
 * @author	Maximilian Mader
 * @copyright	2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class ConversationFaker extends AbstractFaker {
	/**
	 * number of user accounts
	 * 
	 * @var	integer
	 */
	public $userCount = 0;
	
	public function __construct(\Faker\Generator $generator, array $parameters) {
		parent::__construct($generator, $parameters);
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_user";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		
		$this->userCount = $statement->fetchColumn();
	}
	
	/**
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$minParticipants = (isset($this->parameters['minParticipants']) && $this->parameters['minParticipants'] >= 1) ? $this->parameters['minParticipants'] : 1;
		$maxParticipants = (isset($this->parameters['maxParticipants']) && $this->parameters['maxParticipants'] >= 1) ? $this->parameters['maxParticipants'] : 4;
		
		$invisibleParticipantsPercentage = (isset($this->parameters['invisibleParticipantsPercentage'])) ? $this->parameters['invisibleParticipantsPercentage'] : 0;
		$participantCanInviteChance = (isset($this->parameters['participantCanInviteChance'])) ? $this->parameters['participantCanInviteChance'] : 20;
		
		$participantsCount = static::weightedRand($minParticipants, $maxParticipants, 2.2);
		$invisibleParticipantsCount = floor($participantsCount * $invisibleParticipantsPercentage / 100);
		$participantsCount -= $invisibleParticipantsCount;
		
		$sql = "SELECT		userID, username, registrationDate
			FROM		wcf".WCF_N."_user
			ORDER BY	userID ASC";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->userCount - 1));
		$statement->execute();
		
		$sender = $statement->fetchObject('\wcf\data\user\User');
		$minTime = $sender->registrationDate;
		
		$participants = array();
		$invisibleParticipants = array();
		for ($i = 0; $i < $participantsCount + $invisibleParticipantsCount; $i++) {
			$condition = new \wcf\system\database\util\PreparedStatementConditionBuilder();
			$condition->add('userID NOT IN (?)', array(array_merge(array($sender->userID), $participants, $invisibleParticipants)));
			
			$sql = "SELECT		userID, registrationDate
				FROM		wcf".WCF_N."_user
				".$condition."
				ORDER by	userID ASC";
				
			$statement = WCF::getDB()->prepareStatement($sql, 1, $this->userCount - 2 - $i ? $this->generator->numberBetween(0, $this->userCount - 2 - $i) : 0);
			$statement->execute($condition->getParameters());
			
			$user = $statement->fetchObject('\wcf\data\user\User');
			$minTime = max($minTime, $user->registrationDate);
			
			if ($i < $participantsCount) {
				$participants[] = $user->userID;
			}
			else {
				$invisibleParticipants[] = $user->userID;
			}
		}
		
		if (!empty($participants) || !empty($invisibleParticipants)) {
			$conversationData = array(
				'data' => array(
					'subject' => $this->generator->realText($this->generator->numberBetween(10, 255)),
					'time' => $this->generator->numberBetween($minTime, TIME_NOW),
					'userID' => $sender->userID,
					'username' => $sender->username,
					'isDraft' => 0,
					'participantCanInvite' => $this->generator->boolean($participantCanInviteChance) ? 1 : 0
				),
				'attachmentHandler' => null,
				'messageData' => array(
					'message' => $this->generator->realText($this->generator->numberBetween(10, 10000)),
					'enableBBCodes' => 0,
					'enableHtml' => 0,
					'enableSmilies' => 0,
					'showSignature' => 1
				),
				'participants' => $participants,
				'invisibleParticipants' => $invisibleParticipants
			);
			
			$objectAction = new \wcf\data\conversation\ConversationAction(array(), 'create', $conversationData);
			$objectAction->executeAction();
		}
	}
	
	/*
	 * Generates a weighted random number
	 *
	 * Choose a continuous random number between 0..1
	 * Raise to a power γ, to bias it. 1 is unweighted, lower gives more of the higher numbers and vice versa
	 * Scale to desired range and round to integer
	 *
	 * @author bobince <http://stackoverflow.com/a/445363/1112384>
	 */
	public static function weightedRand($min, $max, $gamma) {
		$offset = $max - $min + 1;
		return floor($min + pow(lcg_value(), $gamma) * $offset);
	}
}
