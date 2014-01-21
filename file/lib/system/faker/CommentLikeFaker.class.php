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
	 * @see	\wcf\system\faker\AbstractFaker::__construct()
	 */
	public function __construct(\Faker\Generator $generator, array $parameters) {
		parent::__construct($generator, $parameters);
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_comment";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		
		$this->commentCount = $statement->fetchColumn();
	}
	
	/**
	 * @see	\wcf\system\faker\AbstractLikeFaker::getLikeableObject()
	 */
	public function getLikeableObjectID() {
                $sql = "SELECT		commentID
			FROM		wcf".WCF_N."_comment";
		$statement = \wcf\system\WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->commentCount - 1));
		$statement->execute();
		
		return $statement->fetchColumn();
	}
}
