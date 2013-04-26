<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_DriveSummary extends MMS_Db_Table_Abstract
{
	protected $_name = 'DriveSummary';
	protected $_primary = 'DriveSummaryId';

	/**
	 * (non-PHPdoc)
	 * @see Zend_Db_Table_Abstract::insert()
	 * 
	 * Check to see if this is a duplicate before we perform the insert. If the
	 * TeamGameId, Quarter or StartTime columns are not present, the we will 
	 * return false. These are the columns used to determine the duplicate 
	 * status. Otherwise, we will return the PK.
	 */
	public function insert( $data )
	{
		$pk	= false;
		// Check if it is a duplicate.
		if ( isset($data['TeamGameId']) && isset($data['Quarter']) && isset($data['StartTime']) )
		{
			$gameId		= $data['TeamGameId'];
			$quarter	= $data['Quarter'];
			$startTime	= $data['StartTime'];
			$where		= "TeamGameId={$gameId} AND Quarter={$quarter} AND StartTime='{$startTime}'";
			$row		= $this->fetchRow( $where );
			
			/*
			 * If the rows does not exist, then we will insert it, otherwise, 
			 * we will pull the PK from the existing row.
			 */
			if ( !$row )
			{
				$pk	= parent::insert( $data );
			}
			else 
			{
				$pk = $row->DriveSummaryId;
			}
		}
		return $pk;
	}
	
	public function getOffenseDriveSummary($teamId, $weekNum=false)
	{
		return $this->getDriveSummary($teamId, false, $weekNum);
	}
	
	public function getDefenseDriveSummary($teamId, $weekNum = false)
	{
		/*
		 * If we get the drives for the opponent team, this 
		 * is the defense drive summary.
		 */
		return $this->getDriveSummary(false, $teamId, $weekNum);
	}
	
	/**
	 * Get the specified drive summaries.
	 * 
	 * @param int $teamId
	 * @param int $weekNum
	 */
	private function getDriveSummary($teamId = false, $opponentId = false, $weekNum = false)
	{
		$w = array();
		if ( $teamId ){$w[] = "tg.TeamId={$teamId}";}
		if ( $opponentId ){$w[] = "tg.OpponentId={$opponentId}";}
		if ( $weekNum ){$w[] = "w.WeekNum={$weekNum}";}
		$where = implode(' AND ', $w);
		
		$sql	= $this->getAdapter()->select()
				->from(array('ds'=>'DriveSummary'))
				->join(array('tg'=>'TeamGame'), 'ds.TeamGameId=tg.TeamGameId', '')
				->join(array('w'=>'Week'), 'w.WeekId=tg.WeekId', '')
				->join(array('ts'=>'TeamSeason'), 'ts.TeamId=tg.TeamId', '')
				->join(array('s'=>'Season'), 's.SeasonId=ts.SeasonId', '')
				->where($where)
				->order('ds.Quarter ASC', 'ds.StartTime DESC');
		$rs = $sql->query(PDO::FETCH_ASSOC);
		return $rs->fetchAll();
	}
}