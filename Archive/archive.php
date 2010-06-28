<?php
// Change
/**
 * Cache function
 *
 * @todo Fresh by file
 */
Class Archive implements InbiosisCache {
	
	private $storage;
	private $timeStorage;
	
	public function __construct(ArchiveStorageApi $storage)
	{
		$this -> storage = $storage;
	}
	
	public function save($data, $path = null, $lifetime = null) {
		$key = $path ? $path : md5(rand());
		
		if(!preg_match("/^([0-9a-z][0-9a-z\\.]*)?[0-9a-z]$/", $key))
			throw new ArchiveException("Incorrect path");
		
		$this -> storage -> set($key.".data", $data);

		if(!strtotime("-".$lifetime) && $lifetime != 0 && !is_int($lifetime)) 
			throw new ArchiveException("Incorrect lifetime");
		
		$this -> storage -> set($key.".lifetime", $lifetime);
		
		return $path ? true : $key;
	}
	
	/**
	 * This function gets data of key
	 *
	 * @param string $path key to the data
	 * @return bool success or not
	 */
	public function get($path) {
		$lifetime = $this -> storage -> get($path.".lifetime");
		
		
		if(is_int($lifetime)) 
			$lifetime = time() - $lifetime;
			
		else if ($lifetime)
			$lifetime = strtotime("-" . $this -> storage -> get($path . ".lifetime"));
		
		
		if($lifetime && $this -> storage -> last($path.".data") <= $lifetime) return false;
		
		return $this -> storage -> get($path.".data");
	}
	
	/**
	 * Deletes data of key
	 *
	 * @param string $path key to the data
	 * @return void
	 */
	public function remove($path) {
		$this -> storage -> remove($path);
	}
	
	/**
	 * Checks the freshness of data
	 *
	 * @param string $path 
	 * @param string $time fresh time ex. "2 months", "10 seconds"
	 * @return bool fresh or not
	 */
	public function isFresh($path, $time = null) {}
	
	/**
	 * Set config of system, files path, database config etc.
	 * 
	 * @notice I'm not sure, may it should be in __construct?
	 * 
	 * @return void
	 */
	public function config() {}
	
	/**
	 * Deletes old data
	 *
	 * @param string $maxlifetime 
	 * @return void
	 */
	public function tinyCache($maxlifetime) {}
	
	/**
	 * Gets size of all data
	 *
	 * @return int size in bytes
	 */
	public function getCacheSize() {
		return $this -> storage -> getSize();
	}
}

?>
