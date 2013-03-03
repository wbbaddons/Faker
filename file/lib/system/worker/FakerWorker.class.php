<?php
namespace wcf\system\worker;

/**
 * Worker implementation for generating Fake data.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.worker
 */
class FakerWorker extends AbstractWorker {
	/**
	 * @see	wcf\system\worker\AbstractWorker::$limit
	 */
	protected $limit = 50;
	
	/**
	 * @see	wcf\system\worker\IWorker::validate()
	 */
	public function validate() {
		if (!isset($this->parameters['faker'])) {
			throw new SystemException("faker missing");
		}
		
		if (!class_exists($this->parameters['faker'])) {
			throw new SystemException("unable to find faker '".$this->parameters['faker']);
		}
		
		if (!\wcf\util\ClassUtil::isInstanceOf($this->parameters['faker'], '\wcf\system\faker\IFaker')) {
			throw new SystemException("'".$this->parameters['faker']."' does not implement '\wcf\system\faker\IFaker'");
		}
		
		if (!isset($this->parameters['amount'])) {
			throw new SystemException("amount missing");
		}
	}
	
	/**
	 * @see	wcf\system\worker\IWorker::countObjects()
	 */
	public function countObjects() {
		$this->count = intval($this->parameters['amount']);
	}
	
	/**
	 * @see	wcf\system\worker\IWorker::execute()
	 */
	public function execute() {
		$className = $this->parameters['faker'];
		$faker = new $className();
		for ($i = $this->limit * $this->loopCount, $j = 0; $i < $this->count && $j < $this->limit; $i++, $j++) {
			$faker->fake();
		}
	}
	
	/**
	 * @see	wcf\system\worker\IWorker::getProceedURL()
	 */
	public function getProceedURL() {
		return \wcf\system\request\LinkHandler::getInstance()->getLink('Faker');
	}
}
