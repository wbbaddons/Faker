<?php
namespace wcf\system\faker;
use \wcf\system\WCF;

/**
 * Creates fake blocks.
 * 
 * @author	Maximilian Mader
 * @copyright	2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class UserIgnoreFaker extends AbstractFaker {
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
		$statement = WCF::getDB()->prepareStatement($sql, 1, $this->userCount - 2 ? $this->generator->numberBetween(0, $this->userCount - 2) : 0);
		$statement->execute(array($target->userID));
		$issuer = $statement->fetchObject('\wcf\data\user\User');
		
		\wcf\system\session\SessionHandler::getInstance()->changeUser($issuer, true);
		$objectAction = new \wcf\data\user\ignore\UserIgnoreAction(array(), 'ignore', array(
			'data' => array(
				'ignoreUserID' => $target->userID
			)
		));
		$objectAction->executeAction();
	}
}
