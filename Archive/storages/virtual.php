<?php

Class ArchiveStoragesVirtual implements ArchiveStorageApi {
	public $storage = array();
	
	public function set($key, $value)
	{
		$storage = &$this -> storage;
		$list = explode(".", $key);
		$i = 0;
		
		while($list[$i+1]) {
			if(!array_key_exists($list[$i], $storage)) {
				$storage[$list[$i]] = array();
			}
			
			$storage = &$storage[$list[$i]];
			
			$i++;
		}
		
		$storage[$list[$i]] =  array("time" => time(), "data" => $value);;
		
		//$this -> storage[$key] = array("time" => time(), "data" => $value);
		
		return true;
	}

	public 	function get($key)
	{
		if($this->has($key)) {
			$storage = $this -> storage;
			
			eval ("\$result = \$storage['" . implode("']['", explode(".", $key)) . "']['data'];");
			
			return $result;
			
		}
		else return false;
	}
	
	public 	function remove($key)
	{
		if($this->has($key)) {
			$storage = &$this -> storage;
			
			eval ("unset(\$storage['" . implode("']['", explode(".", $key)) . "']);");
			
			return $result;
			
		}
		
		return true;
	}
	
	public 	function has($key)
	{
		$storage = $this -> storage;
		$list = explode(".", $key);
		$i = -1;

		while($list[$i++]) {
			if(!array_key_exists($list[$i], $storage)) 
				return false;
			$storage = $storage[$list[$i]];
		}
		
		return true;
	}
	
	public function last($key)
	{
		
		if($this->has($key)) {
			$storage = $this -> storage;

			eval ("\$result = \$storage['" . implode("']['", explode(".", $key)) . "']['time'];");
			
			return $result;

		}
		else return false;
	}
	
	
	public function getSize()
	{
		if(count($this -> storage) < 1) 
			return 0;
		
		return strlen(serialize($this -> storage));
	}
}

?>
