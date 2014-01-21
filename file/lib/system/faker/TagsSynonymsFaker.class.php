<?php
namespace wcf\system\faker;
use \wcf\system\WCF;

/**
 * Creates fake synonyms.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 - 2014 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
class TagsSynonymsFaker extends AbstractFaker {
	/**
	 * number of user accounts
	 * 
	 * @var	integer
	 */
	public $tagCount = 0;
	
	/**
	 * @see	\wcf\system\faker\AbstractFaker::__construct()
	 */
	public function __construct(\Faker\Generator $generator, array $parameters) {
		parent::__construct($generator, $parameters);
		
		$sql = "SELECT	COUNT(*)
			FROM	wcf".WCF_N."_tag";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		
		$this->tagCount = $statement->fetchColumn();
	}
	
	/**
	 * @see	\wcf\system\faker\IFaker::fake()
	 */
	public function fake() {
		$sql = "SELECT		tagID
			FROM		wcf".WCF_N."_tag
			ORDER BY	tagID ASC";
		$statement = WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->tagCount - 1));
		$statement->execute();
		$target = $statement->fetchObject('\wcf\data\tag\Tag');
		
		$sql = "SELECT		tagID
			FROM		wcf".WCF_N."_tag
			WHERE		tagID <> ?
			ORDER BY	tagID ASC";
		$statement = WCF::getDB()->prepareStatement($sql, 1, $this->generator->numberBetween(0, $this->tagCount - 2));
		$statement->execute(array($target->tagID));
		$synonym = $statement->fetchObject('\wcf\data\tag\Tag');
		
		$editor = new \wcf\data\tag\TagEditor($target);
		$editor->addSynonym($synonym);
	}
}
