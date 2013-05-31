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
	 * language matching fakers language
	 * @var	\wcf\data\language\Language
	 */
	protected $language = null;
	
	/**
	 * @see	\wcf\system\faker\IFaker::__construct()
	 */
	public function __construct(\Faker\Generator $generator, array $parameters) {
		$this->generator = $generator;
		$this->parameters = $parameters;
		
		$this->language = \wcf\system\language\LanguageFactory::getInstance()->getLanguageByCode(substr($this->parameters['fakerLocale'], 0, 2));
	}
}
