<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_TeamGame extends MMS_Db_Table_Abstract
{
	protected $_name = 'TeamGame';
	protected $_primary = 'TeamGameId';
	
	public function insertUnique($data)
	{
		$pk = false;
		if (isset($data['TeamId']) && isset($data['WeekId']))
		{
			$teamId = $data['TeamId'];
			$weekId = $data['WeekId'];
			$where = "TeamId={$teamId} AND WeekId='{$weekId}'";
			$row = $this->fetchRow($where);
			
			if (!$row)
			{
				$pk = $this->insert($data);
			}
			else 
			{
				$vals = $row->toArray();
				$pk = $vals['TeamGameId'];
			}
		}
		return $pk;
	}

	public function getArrayTeamByWeekNum($teamId)
	{
		$where	= 'tg.TeamId='.$teamId;

		$rows = $this->getAdapter()->select()
			->from(array('tg'=>'TeamGame'), array('TeamId', 'OpponentId', 'IsHome', 'Time'))
			->join(array('w'=>'Week'), 'tg.WeekId=w.WeekId', array('WeekNum'))
			->joinLeft(array('score'=>'TeamScore'), 'score.TeamGameId=tg.TeamGameId', array('IsWin'))
			->join(array('team'=>'TeamSeason'), 'team.TeamId=tg.TeamId', '')
			->join(array('opponent'=>'TeamSeason'), 'opponent.TeamId=tg.OpponentId', '')
			->where($where)
			->order('WeekNum ASC')
			->columns(array('(CASE WHEN team.DivisionId=opponent.DivisionId THEN 1 ELSE 0 END) AS IsDivision', '(CASE WHEN team.ConferenceId=opponent.ConferenceId THEN 1 ELSE 0 END) AS IsConference'))
			->query();
		
		$games = array();
		foreach ($rows as $row)
		{
			$game					= array();
			$game['TeamId']			= $row['TeamId'];
			$game['OpponentId']		= $row['OpponentId'];
			$game['IsHome']			= $row['IsHome'];
			$game['IsWin']			= $row['IsWin'];
			$game['IsDivision']		= $row['IsDivision'];
			$game['IsConference']	= $row['IsConference'];
			$game['Time']			= new DateTime($row['Time']);

			$games[$row['WeekNum']]	= $game;
		}

		return $games;
	}
	
	public function getTeamGameId($weekId, $teamId, $isHome)
	{
		static $data = array();
		if ( !isset( $data[ $weekId ] ) )
		{
			$where	= 'WeekId=' . $weekId;
			$rs		= $this->fetchAll($where);
			$week	= array();
			foreach ($rs as $row)
			{
				$week[ $row->TeamId ][ $row->IsHome ] = $row->TeamGameId;
			}
			$data[ $weekId ] = $week;
		}
		return $data[ $weekId ][ $teamId ][ $isHome ];
	}
	
	public function getHomeTeamGameIdForWeek($weekNum, $homeAlias)
	{
		require_once '/MMS/Db/Table/Football/Week.php';
		require_once '/MMS/Db/Table/Football/TeamAlias.php';
		
		$weekTable	= new MMS_Db_Table_Football_Week();
		$weekId		= $weekTable->getWeekId($weekNum);
		
		$aliasTable	= new MMS_Db_Table_Football_TeamAlias();
		$teamId		= $aliasTable->getTeamIdForAliasName( $homeAlias );
		
		$isHome = 1; // We are defaulting isHome = true for the query;
		
		return $this->getTeamGameId($weekId, $teamId, $isHome);
	}

	/**
	 * Given a TeamGameId, find the associated TeamGameId for the opponent of
	 * the supplied game.
	 * 
	 * @param int $teamGameId
	 * @return int || false
	 */
	public function getOpponentTeamGameIdForTeamGameId( $teamGameId )
	{
		$select	= $this->getAdapter()->select();
		$row	= $select->from( array( 'tg1'=>'TeamGame' ), null )
					->join( array( 'tg2'=>'TeamGame' ), 'tg2.TeamId=tg1.OpponentId AND tg2.WeekId=tg1.WeekId', 'TeamGameId' )
					->where('tg1.TeamGameId=' . $teamGameId )
					->query()->fetch();
		$gameId	= isset($row['TeamGameId']) ? $row['TeamGameId'] : false;
		
		return $row['TeamGameId'];
	}
}