<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_Conference extends MMS_Db_Table_Abstract
{
	protected $_name = 'Conference';
	protected $_primary = 'ConferenceId';
	
	/**
	 * Get an array of conference names keyed on the ConferenceId field.
	 * 
	 * @return string[]
	 */
	public function getArrayByConferenceId()
	{
		$rows = $this->fetchAll()->toArray();

		$confs = array();
		foreach ($rows as $conference)
		{
			$index = $conference['ConferenceId'];
			$value = $conference['ConferenceName'];
			$confs[$index] = $value;
		}
		
		return $confs;
	}
}