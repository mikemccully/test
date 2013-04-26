<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_Week extends MMS_Db_Table_Abstract
{
	protected $_name = 'Week';
	protected $_primary = 'WeekId';
	
	public function getArrayWeeksForSeasonByWeekId($seasonId = 1)
	{
		$where = 'SeasonId=' . $seasonId;
		$order = 'WeekNum ASC';
		$rows = $this->fetchAll($where, $order)->toArray();
		
		$weeks = array();
		foreach ($rows as $row)
		{
			$weeks[$row['WeekId']] = $row;
		}
		return $weeks;
	}
	
	public function getCurrentWeekId()
	{
		/*
		 * Determine the current week and return the WeekId
		 */
	}
	
	public function getWeekId($weekNum, $year = 2012)
	{
		static $weekId = array();
		if ( !isset( $weekId[ $weekNum ] ) )
		{
			$rs = $this->getAdapter()->select()
				->from('Week', 'WeekId')
				->join('Season', 'Season.SeasonId=Week.SeasonId AND Season.Year=' . $year)
				->where('WeekNum=' . $weekNum)
				->query();
			$rows = $rs->fetchAll();
			$weekId[$weekNum] = $rows[0]['WeekId'];
		}
		return $weekId[$weekNum];
	}
	
	public function insertUniqueWeek($data)
	{
		$pk = false;
		if (isset($data['WeekNum']) && isset($data['StartDate']) && isset($data['SeasonId']))
		{
			$weekNum = $data['WeekNum'];
			$startDate = $data['StartDate'];
			$seasonId = $data['SeasonId'];
			$where = "WeekNum={$weekNum} AND StartDate='{$startDate}' AND SeasonId={$seasonId}";
			$row = $this->fetchRow($where);
			
			if (!$row)
			{
				$pk = $this->insert($data);
			}
			else 
			{
				$vals = $row->toArray();
				$pk = $vals['WeekId'];
			}
		}
		return $pk;
	}

}