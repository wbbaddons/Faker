<?php
namespace wcf\system\faker;
use \wcf\system\WCF;

/**
 * Creates fake likes on comments.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 - 2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class CommentLikeFaker extends AbstractLikeFaker {
	/**
	 * number of comments
	 * 
	 * @var	integer
	 */
	public $commentCount = 0;
	
	/**
	 * @see	\wcf\system\faker\AbstractLikeFaker::$objectTypeName
	 */
	public $objectTypeName = 'com.woltlab.wcf.comment';
	
	/**
	 * For which object types should likes be generated?
	 * 
	 * @var	\wcf\system\database\util\PreparedStatementConditionBuilder
	 */
	public $condition = null;
	
	/**
	 * @see	\wcf\system\faker\AbstractFaker::__construct()
	 */
	public function __construct(\Faker\Generator $generator, array $parameters) {
		parent::__construct($generator, $parameters);
		
		$this->condition = new \wcf\system\database\util\PreparedStatementConditionBuilder();
		if (isset($this->parameters['objectTypeIDs']) && !empty($this->parameters['objectTypeIDs'])) {
			$this->condition->add('objectTypeID IN(?)', array($this->parameters['objectTypeIDs']));
		}
		else {
			$this->condition->add('1=1');
		}
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_comment
			".$this->condition;
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute($this->condition->getParameters());
		
		$this->commentCount = $statement->fetchColumn();
	}
	
	/**
	 * @see	\wcf\system\faker\AbstractLikeFaker::getLikeableObject()
	 */
	public function getLikeableObjectID() {
		$sql = "SELECT		commentID
			FROM		wcf".WCF_N."_comment
			".$this->condition;
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1, $this->commentCount - 1 ? $this->generator->numberBetween(0, $this->commentCount - 1) : 0);
		$statement->execute($this->condition->getParameters());
		
		return $statement->fetchColumn();
	}
}
