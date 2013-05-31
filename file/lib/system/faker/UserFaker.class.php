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
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$username = $this->generator->userName;
		$password = $username;
		
		$parameters = array(
			'data' => array(
				'languageID' => \wcf\system\language\LanguageFactory::getInstance()->getLanguageByCode(substr($this->parameters['fakerLocale'], 0, 2))->languageID,
				'username' => $username,
				'email' => $this->generator->safeEmail,
				'password' => $password,
				'registrationDate' => $this->generator->numberBetween(strtotime('2000-01-01 GMT'), TIME_NOW)
			)
		);
		if (isset($this->parameters['groupIDs'])) {
			$parameters['groups'] = $this->parameters['groupIDs'];
		}
		
		// handle old name
		if (isset($this->parameters['userRandomOldUsername']) && $this->parameters['userRandomOldName']) {
			// 2 percent chance
			if ($this->generator->boolean(2)) {
				$parameters['data']['oldUsername'] = $this->generator->userName;
			}
		}
		
		// handle signature
		if (isset($this->parameters['userRandomSignature']) && $this->parameters['userRandomSignature']) {
			$parameters['data']['signature'] = $this->generator->text($this->generator->numberBetween(10, 500));
		}
		
		// handle options
		$options = array();
		
		// handle gender
		if (isset($this->parameters['userGender'])) {
			switch ($this->parameters['userGender']) {
				case 0:
				case 1:
				case 2:
					$options[\wcf\data\user\User::getUserOptionID('gender')] = $this->parameters['userGender'];
				break;
				
				default:
					$options[\wcf\data\user\User::getUserOptionID('gender')] = $this->generator->numberBetween(0, 2);
				break;
			}
		}
		
		// handle aboutMe
		if (isset($this->parameters['userRandomAboutMe']) && $this->parameters['userRandomAboutMe']) {
			$options[\wcf\data\user\User::getUserOptionID('aboutMe')] = $this->generator->text($this->generator->numberBetween(50, 1500));
		}
		
		// handle birthday
		if (isset($this->parameters['userRandomBirthday']) && $this->parameters['userRandomBirthday']) {
			$options[\wcf\data\user\User::getUserOptionID('birthday')] = $this->generator->dateTimeBetween("-90 years", "-14 years")->format('Y-m-d');
		}
		
		// handle location
		if (isset($this->parameters['userRandomLocation']) && $this->parameters['userRandomLocation']) {
			$options[\wcf\data\user\User::getUserOptionID('location')] = $this->generator->address;
		}
		
		// handle homepage
		if (isset($this->parameters['userRandomHomepage']) && $this->parameters['userRandomHomepage']) {
			$options[\wcf\data\user\User::getUserOptionID('homepage')] = $this->generator->url;
		}
		
		if (!empty($options)) {
			$parameters['options'] = $options;
		}
		
		$objectAction = new \wcf\data\user\UserAction(array(), 'create', $parameters);
		$objectAction->executeAction();
	}
}
