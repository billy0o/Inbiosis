<?php
/**
 * Storoge for drivers (files, sql, etc)
 *
 * @package inbiosis.archive.
 * @author biLLy
 */
interface ArchiveStorageApi extends InbiosisStorage {	
	public function remove($key);
	
	public function last($key);
	
	
	/**
	 * Gets size of storage
	 *
	 * @return int size in bytes
	 */
	public function getSize();
}