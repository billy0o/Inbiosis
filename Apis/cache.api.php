<?php

/**
 * This is inerface of cache
 *
 * @package inbiosis.cache
 * @author biLLy
 */
interface InbiosisCache {
	/**
	 * This function writes cache into system
	 *
	 * @param mixed $data
	 * @param string $path key to the data
	 * @param int $lifetime fresh time ex. "2 months", "10 seconds"
	 * @return void
	 */
	public function save($data, $path = null, $lifetime = 0);
	
	/**
	 * This function gets data of key
	 *
	 * @param string $path key to the data
	 * @return bool success or not
	 */
	public function get($path);
	
	/**
	 * Deletes data of key
	 *
	 * @param string $path key to the data
	 * @return void
	 */
	public function remove($path);
	
	/**
	 * Checks the freshness of data
	 *
	 * @param string $path 
	 * @param string $time fresh time ex. "2 months", "10 seconds"
	 * @return bool fresh or not
	 */
	public function isFresh($path, $time = null);
	
	/**
	 * Set config of system, files path, database config etc.
	 * 
	 * @notice I'm not sure, may it should be in __construct?
	 * 
	 * @return void
	 */
	public function config();
	
	/**
	 * Deletes old data
	 *
	 * @param string $maxlifetime 
	 * @return void
	 */
	public function tinyCache($maxlifetime);
	
	/**
	 * Gets size of all data
	 *
	 * @return int size in bytes
	 */
	public function getCacheSize();
}