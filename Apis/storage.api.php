<?php
/**
 * Storoge for data
 *
 * @package inbiosis.apis.storage
 *
 */
interface InbiosisStorage {
	/**
	 * Write
	 *
	 * @param string $key key for access
	 * @param string $value data to write
	 * @return void
	 */
	public function set($key, $value);
	
	/**
	 * Read
	 *
	 * @param string $key key for access
	 * @return mixed
	 */
	public function get($key);
	
	/**
	 * Checks that key already exists
	 *
	 * @param string $key key for access
	 * @return bool exists or not
	 */
	public function has($key);
}