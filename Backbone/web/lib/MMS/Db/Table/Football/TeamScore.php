<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_TeamScore extends MMS_Db_Table_Abstract
{
	protected $_name = 'TeamScore';
	protected $_primary = 'TeamScoreId';

	/**
	 * (non-PHPdoc)
	 * @see Zend_Db_Table_Abstract::insert()
	 * 
	 * Check to see if this is a duplicate before we perform the insert. If 
	 * the TeamGameId is not present, the we will return false. This is the 
	 * column used to determine the duplicate status. Otherwise, we will 
	 * return the PK.
	 */
	public function insert( $data )
	{
		$pk	= false;
		// Check if it is a duplicate.
		if ( isset($data['TeamGameId']) )
		{
			$gameId		= $data['TeamGameId'];
			$where		= "TeamGameId={$gameId}";
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
				$pk = $row->TeamScoreId;
			}
		}
		return $pk;
	}
	
	public function getSeasonResultsByTeamId($season = 2012)
	{
		$rs	= $this->getAdapter()->select()
			->from(array('score'=>'TeamScore'), '')
			->join(array('tg'=>'TeamGame'), 'tg.TeamGameId=score.TeamGameId', array('TeamId'))
			->group('tg.TeamId')
			->columns(array("SUM(CASE WHEN score.IsWin=1 THEN 1 ELSE 0 END) AS Win", "SUM(CASE WHEN score.IsWin=0 THEN 1 ELSE 0 END) AS Loss"))
			->query()->fetchAll();
		
		$result = array();
		foreach ( $rs as $row )
		{
			$result[ $row['TeamId'] ][ 'W' ] = $row[ 'Win' ];
			$result[ $row['TeamId'] ][ 'L' ] = $row[ 'Loss' ];
		}

		return $result;
	}
}