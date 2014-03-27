<?php
namespace wcf\system\faker;
use \wcf\data\user\User;

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
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$username = $tmpName = $this->generator->userName;
		$username = str_replace(',', '', $username);
		
		while (!\wcf\util\UserUtil::isAvailableUsername($tmpName)) {
			$tmpName = $username . $this->generator->randomNumber(4);
		}
		
		$username = $tmpName;
		$password = $username;
		$email = $username . '@' . $this->generator->safeEmailDomain;
		
		// shouldn't happen
		if (!\wcf\util\UserUtil::isValidEmail($email)) {
			$email = $this->generator->safeEmail;
		}
		
		while (!\wcf\util\UserUtil::isAvailableEmail($email)) {
			$email = $this->generator->safeEmail;
		}
		
		$registrationDate = $this->generator->dateTimeBetween('2000-01-01 GMT', 'now')->getTimestamp();
		$lastActivityTime = $this->generator->optional($weight = 0.7)->numberBetween($registrationDate, TIME_NOW);
		$parameters = array(
			'data' => array(
				'languageID' => $this->language->languageID,
				'username' => $username,
				'email' => $email,
				'password' => $password,
				'registrationDate' => $registrationDate,
				'lastActivityTime' => ($lastActivityTime === null) ? 0 : $lastActivityTime
			)
		);
		
		if (isset($this->parameters['groupIDs'])) {
			$parameters['groups'] = $this->parameters['groupIDs'];
		}
		
		// handle old name
		if (isset($this->parameters['userRandomOldUsername']) && $this->parameters['userRandomOldUsername']) {
			// 2 percent chance
			if ($this->generator->boolean(2)) {
				$parameters['data']['oldUsername'] = $this->generator->userName;
			}
		}
		
		// handle signature
		if (isset($this->parameters['userRandomSignature']) && $this->parameters['userRandomSignature']) {
			$parameters['data']['signature'] = $this->generator->realText($this->generator->numberBetween(10, 500));
		}
		
		// handle options
		$options = array();
		
		// handle gender
		if (isset($this->parameters['userGender'])) {
			switch ($this->parameters['userGender']) {
				case 0:
				case 1:
				case 2:
					$options[User::getUserOptionID('gender')] = $this->parameters['userGender'];
				break;
				
				default:
					$options[User::getUserOptionID('gender')] = $this->generator->numberBetween(0, 2);
				break;
			}
		}
		
		// handle aboutMe
		if (isset($this->parameters['userRandomAboutMe']) && $this->parameters['userRandomAboutMe']) {
			$options[User::getUserOptionID('aboutMe')] = $this->generator->realText($this->generator->numberBetween(50, 1000));
		}
		
		// handle birthday
		if (isset($this->parameters['userRandomBirthday']) && $this->parameters['userRandomBirthday']) {
			$options[User::getUserOptionID('birthday')] = $this->generator->dateTimeBetween("-90 years", "-14 years")->format('Y-m-d');
		}
		
		// handle location
		if (isset($this->parameters['userRandomLocation']) && $this->parameters['userRandomLocation']) {
			$options[User::getUserOptionID('location')] = $this->generator->address;
		}
		
		// handle homepage
		if (isset($this->parameters['userRandomHomepage']) && $this->parameters['userRandomHomepage']) {
			$options[User::getUserOptionID('homepage')] = $this->generator->url;
		}
		
		if (!empty($options)) {
			$parameters['options'] = $options;
		}
		
		$objectAction = new \wcf\data\user\UserAction(array(), 'create', $parameters);
		$objectAction->executeAction();
	}
}
