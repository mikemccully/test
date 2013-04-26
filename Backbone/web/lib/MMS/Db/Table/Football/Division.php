<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_Division extends MMS_Db_Table_Abstract
{
	protected $_name = 'Division';
	protected $_primary = 'DivisionId';
	
	public function getArrayByDivisionId()
	{
		$rows = $this->fetchAll()->toArray();
		
		$divs = array();
		foreach ($rows as $division)
		{
			$index = $division['DivisionId'];
			$value = $division['DivisionName'];
			$divs[$index] = $value;
		}
		
		return $divs;
	}
}