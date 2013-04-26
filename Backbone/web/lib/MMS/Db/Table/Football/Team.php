<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_Team extends MMS_Db_Table_Abstract
{
	protected $_name = 'Team';
	protected $_primary = 'TeamId';

	/**
	 * Get an array of team names keyed on the TeamId field.
	 * 
	 * @return string[]
	 */
	public function getArrayNameByTeamId()
	{
		$rows = $this->fetchAll()->toArray();
		
		$teams = array();
		foreach ($rows as $team)
		{
			$index = $team['TeamId'];
			$value = $team['TeamName'];
			$teams[$index] = $value;
		}
		
		return $teams;
	}
}