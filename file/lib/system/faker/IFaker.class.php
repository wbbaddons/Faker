<?php
namespace wcf\system\faker;

/**
 * All Fakers must implement this interface.
 * 
 * @author	Tim Düsterhus
 * @copyright	2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.faker
 * @subpackage	system.faker
 */
interface IFaker {
	/**
	 * Initializes faker with given generator.
	 * 
	 * @param \Faker\Generator $generator
	 */
	public function __construct(\Faker\Generator $generator);
	
	/**
	 * Creates fake and inserts it into database.
	 */
	public function fake();
}
