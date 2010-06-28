<?php

final class Inbiosis {
	
	public $inbiosisPath = null;
	
	private $services = array();
	
	/**
	 * undocumented function
	 *
     *
     * 
	 * @return void
	 * @author biLLy
	 **/
	public function __construct()
	{
		$this -> inbiosisPath = dirname(__FILE__);
	}
	
	/**
	 * description|class/function name
	 * 
	 * description
	 *
	 * @tag value
	 */
	public function loadClass($name)
	{
		$path = array();
		dssdf
		$offset = 0;

		while(preg_match("/[A-Z][a-z_]+/", $name, $match, null, $offset) && $match) {
			array_push($path, !$offset ? $match[0] : strtolower($match[0]));
			$offset += strlen($match[0]);
		}
		
		
		if($offset == 0) return false;
		
		if($path[0] == "Inbiosis") {
			$path[0] = "Apis";  // InbiosisInterface --> Apis/interface.api.php
			array_push($path, "api");
		}
		
		$last = array_pop($path); 
		
		if(! "" == preg_replace("/^api|test|exception|abstract$/", "", $last)) {
			array_push($path, $last);
			$last = null;
		}
		
		if(count($path) < 2) array_push($path, strtolower($path[0])); // Service --> Service/service.php

		$classFile = implode($path, "/");
		
		if($last) {
			$classFile .= "." . $last; // ServiceSubserviceClassAbstract --> Service/subservice/class.abstract.php
		} 
		
		
		$classFile .= ".php";
		
		if(file_exists($this -> inbiosisPath . "/" . $classFile)) {
			return require_once($this -> inbiosisPath . "/" . $classFile);
		}
		
		return false;
	}
	
	
	public function service ($service)
	{
		if(!in_array($service, $this -> services)) {
			$this -> services[strtolower($service)] = new $service;
		} 
		
		return $this -> services[$service];
	}
}


function Inbiosis () {
	static $inbiosis = null;
	
	if($inbiosis == null) $inbiosis = new Inbiosis;
	
	if($service != null) $imbiosis -> service($service);
	
	return $inbiosis;
	 
}
?>