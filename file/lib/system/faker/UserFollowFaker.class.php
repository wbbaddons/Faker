<?php
namespace wcf\system\faker;
use \wcf\system\WCF;

/**
 * Creates fake follower.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class UserFollowFaker extends AbstractFaker {
	/**
	 * number of user accounts
	 * 
	 * @var	integer
	 */
	public $userCount = 0;
	
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
	}
	
	/**
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$sql = "SELECT		userID
			FROM		wcf".WCF_N."_user
			ORDER BY	userID ASC";
		$statement = WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->userCount - 1));
		$statement->execute();
		$target = $statement->fetchObject('\wcf\data\user\User');
		
		$sql = "SELECT		userID
			FROM		wcf".WCF_N."_user
			WHERE		userID <> ?
			ORDER BY	userID ASC";
		$statement = WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->userCount - 2));
		$statement->execute(array($target->userID));
		$follower = $statement->fetchObject('\wcf\data\user\User');
		
		\wcf\system\session\SessionHandler::getInstance()->changeUser($follower, true);
		$objectAction = new \wcf\data\user\follow\UserFollowAction(array(), 'follow', array(
			'data' => array(
				'userID' => $target->userID
			)
		));
		$objectAction->executeAction();
	}
}
