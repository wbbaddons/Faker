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
	private $generator = null;
	
	public function __construct(\Faker\Generator $generator) {
		$this->generator = $generator;
	}
}
