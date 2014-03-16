<?php
namespace wcf\system\faker;
use \wcf\system\WCF;

/**
 * Creates fake likes.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 - 2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
abstract class AbstractLikeFaker extends AbstractFaker {
	/**
	 * number of user accounts
	 * 
	 * @var	integer
	 */
	public $userCount = 0;
	
	/**
	 * object type name of the likeable object
	 * 
	 * @var	string
	 */
	public $objectTypeName = '';
	
	/**
	 * object type of the likeable object
	 * 
	 * @var	\wcf\data\object\type\ObjectType
	 */
	public $objectType = null;
	
	/**
	 * object type provider
	 * 
	 * @var	\wcf\data\object\type\AbstractObjectTypeProcessor
	 */
	public $objectTypeProvider = null;
	
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
		
		$this->objectType = \wcf\system\like\LikeHandler::getInstance()->getObjectType($this->objectTypeName);
		if ($this->objectType === null) {
			throw new UserInputException('objectType');
		}
		
		$this->objectTypeProvider = $this->objectType->getProcessor();
	}
	
	/**
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$likeableObjectID = $this->getLikeableObjectID();
		$likeableObject = $this->objectTypeProvider->getObjectByID($likeableObjectID);
		$likeableObject->setObjectType($this->objectType);
		
		$sql = "SELECT		userID, username
			FROM		wcf".WCF_N."_user
			ORDER BY	userID ASC";
		$statement = WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->userCount - 1));
		$statement->execute();
		$liker = $statement->fetchObject('\wcf\data\user\User');
		
		if (isset($this->parameters['likeValue'])) {
			switch ($this->parameters['likeValue']) {
				case '+':
					$value = \wcf\data\like\Like::LIKE;
				break;
				case '-':
					$value = \wcf\data\like\Like::DISLIKE;
				break;
				case '+-': 
					if ($this->generator->boolean) {
						$value = \wcf\data\like\Like::LIKE;
					}
					else {
						$value = \wcf\data\like\Like::DISLIKE;
					}
			}
		}
		else {
			$value = \wcf\data\like\Like::LIKE;
		}
		
		\wcf\system\like\LikeHandler::getInstance()->like($likeableObject, $liker, $value);
	}
	
	/**
	 * Returns the object id to like.
	 * 
	 * @return	integer
	 */
	abstract public function getLikeableObjectID();
}
