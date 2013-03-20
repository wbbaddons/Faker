<?php
namespace wcf\system\faker;

/**
 * Base implementation for fakers.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
abstract class AbstractFaker implements IFaker {
	/**
	 * instance of faker generator
	 * @var \Faker\Generator
	 */
	protected $generator = null;
	
	/**
	 * parameters used to fake the content
	 * @var	array
	 */
	protected $parameters = array();
	
	/**
	 * @see	\wcf\system\faker\IFaker::__construct()
	 */
	public function __construct(\Faker\Generator $generator, array $parameters) {
		$this->generator = $generator;
		$this->parameters = $parameters;
	}
}
