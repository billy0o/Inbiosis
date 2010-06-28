<?php


class ArchiveTest extends UnitTestCase {
	
	private $archive = null;
	
	public function setUp()
	{
		if($_GLOBALS['ARCHIVE_STORAGE']) {
			$storage = $_GLOBALS['ARCHIVE_STORAGE'];
		} else {
			$storage = new ArchiveStoragesVirtual();
		}
		$this -> archive = new Archive($storage);
	}
	
	public function testSaving()
	{
		$this -> assertTrue($this -> archive -> save("Some data...", "it.is.a.path", "5 minutes"), "Normal data with path and lifetime");
		$this -> assertTrue($this -> archive -> save(array("some", "array"), "it.is.a.path.array", "15 days"), "Array as data");
		$this -> assertTrue($this -> archive -> save($this -> archive, "it.is.a.path.unfresh", "1 seconds"), "Instance as data");
		$this -> assertIsA($this -> archive -> save("Some data..."), "string", "w/o path");
		
		$this->expectException('ArchiveException');
		$this -> archive -> save("Some data...", "it.is.a.path", "WTF IS THIS A TIME??");
		
		$this->expectException('ArchiveException');
		$this -> archive -> save("Some data...", "wtf/with/this/path?");
		
		//$this -> expectError("Incorrect path");
		//$this -> archive -> save();
	}
	
	public function testReading()
	{
		$this -> archive -> save("Some data...", "it.is.a.path", "1 second");
		$this -> archive -> save("Some data1...", "unfresh", 1);
		
	//	sleep(2); # it gets fail
		
		$this -> assertEqual($this -> archive -> get("it.is.a.path"), "Some data...", "Read");
		$this -> assertFalse($this -> archive -> get("it.is.a.path.unfresh"), "False on not existsing");
		sleep(1);
		$this -> assertFalse($this -> archive -> get("unfresh"));
	}
	
	public function testSize()
	{
		$test = "startup size";
		
		if($this -> archive -> getCacheSize() < 10)
			$this -> pass($test);
		else
			$this -> fail($test);
			
		
		$this -> archive -> save("Some data...");
			
			
		$test = "size after add one record";
		
		if($this -> archive -> getCacheSize() > 10)
			$this -> pass($test);
		else
			$this -> fail($test);
			
		$i = 0;
		$data = "";
		
		while($i++ < 1000) $data .= " ";
		
		$this -> archive -> save($data);

		$test = "size after add one big record";

		if($this -> archive -> getCacheSize() > 1000)
			$this -> pass($test);
		else
			$this -> fail($test);
	}
	
	public function testRemove() {
		
		$this -> archive -> save("Main data", "1");
		$this -> archive -> save("Some data...", "1.2");
		$this -> archive -> save("Some data...", "1.2.3");
		$this -> archive -> save("Some data 2...", "1.2.2");
		$this -> archive -> save("Some data 6...", "1.2.6");
		
		$this -> assertIsA($this -> archive -> get("1.2.3"), "string");
		$this -> assertIsA($this -> archive -> get("1.2.2"), "string");
		$this -> assertIsA($this -> archive -> get("1.2.6"), "string");
		$this -> assertEqual($this -> archive -> get("1"), "Main data", "Read");
		
		$this -> archive -> remove("1.2");
		
		$this -> assertFalse($this -> archive -> get("1.2.3"));
		$this -> assertFalse($this -> archive -> get("1.2.2"));
		$this -> assertFalse($this -> archive -> get("1.2.6"));
	}
}