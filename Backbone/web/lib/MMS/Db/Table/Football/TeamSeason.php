<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_TeamSeason extends MMS_Db_Table_Abstract
{
	protected $_name = 'TeamSeason';
	protected $_primary = 'TeamSeasonId';
	
	/**
	 * Get a nested array of TeamId's keyed on ConferenceId and then DivisionId.
	 * 
	 * @return mixed[][]
	 */
	public function getArrayOfTeamsByConferenceAndDivision()
	{
		$rows = $this->fetchAll()->toArray();
		
		$teams = array();
		foreach($rows as $team)
		{
			$confId = $team['ConferenceId'];
			$divId = $team['DivisionId'];
			$teamId = $team['TeamId'];
			$teams[$confId][$divId][$teamId] = null;
		}
		
		return $teams;
	}
}