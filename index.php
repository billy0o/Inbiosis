<?php
require "../simpletest/autorun.php";
require "inbiosis.php";

spl_autoload_register(array(Inbiosis(), "loadClass"));

new ArchiveTest();




class AllTests extends TestSuite {
    function AllTests() {
        $this->TestSuite('All tests');
        $this->addFile(Inbiosis() -> inbiosisPath . '/Archive/archive.test.php');
    }
}
?>
