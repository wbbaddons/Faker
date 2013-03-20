<?php
namespace wcf\system\faker;

/**
 * Creates fake users.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class UserFaker extends AbstractFaker {
	/**
	 * @see \wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$username = $this->generator->userName;
		$password = $username;
		$email = $this->generator->safeEmail;
		
		$data = array(
			'data' => array(
				'username' => $username,
				'email' => $email,
				'password' => $password,
				'registrationDate' => \wcf\util\MathUtil::getRandomValue(946681200, TIME_NOW)
			)
		);
		if (isset($this->parameters['groupIDs'])) {
			$data['groups'] = $this->parameters['groupIDs'];
		}
		
		$objectAction = new \wcf\data\user\UserAction(array(), 'create', $data);
		$objectAction->executeAction();
	}
}
