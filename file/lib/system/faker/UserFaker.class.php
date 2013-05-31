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
				'registrationDate' => \wcf\util\MathUtil::getRandomValue(946681200, TIME_NOW)
			)
		);
		if (isset($this->parameters['groupIDs'])) {
			$parameters['groups'] = $this->parameters['groupIDs'];
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
					$options[\wcf\data\user\User::getUserOptionID('gender')] = \wcf\util\MathUtil::getRandomValue(0, 2);
				break;
			}
		}
		
		// handle aboutMe
		if (isset($this->parameters['userRandomAboutMe']) && $this->parameters['userRandomAboutMe']) {
			$options[\wcf\data\user\User::getUserOptionID('aboutMe')] = $this->generator->text(500);
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
