<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_TeamAlias extends MMS_Db_Table_Abstract
{
	protected $_name = 'TeamAlias';
	protected $_primary = 'TeamAliasId';
	
	public function insertUniqueAlias($data)
	{
		$pk = false;
		if (isset($data['AliasName']))
		{
			$data['AliasName'] = trim( $data['AliasName'] );
			
			$alias = trim( $data['AliasName'] );
			$where = "AliasName='{$alias}'";
			$row = $this->fetchRow($where);
			
			if (!$row)
			{
				$teamId = $this->createDummyTeamRow($alias);
				$data['TeamId'] = $teamId;
				$pk = $this->insert($data);
			}
			else 
			{
				$vals = $row->toArray();
				$pk = $vals['TeamAliasId'];
				$teamId = $vals['TeamId'];
			}
		}
		return $teamId;
	}
	
	private function createDummyTeamRow($alias)
	{
		require_once '/MMS/Db/Table/Football/Team.php';
		$teamTable = new MMS_Db_Table_Football_Team();
		$data = array();
		$data['TeamName'] = $alias;
		$data['City'] = 'unknown';
		$data['State'] = 'unknown';
		return $teamTable->insert($data);
	}

	public function getTeamIdForAliasName($aliasName)
	{
		$data = $this->fetchTeamIdsIndexedOnAlias();
		$teamId = false;
		if ( isset( $data[ $aliasName ] ) )
		{
			$teamId = $data[ $aliasName ];
		}
		return $teamId;
	}
	
	public function fetchTeamIdsIndexedOnAlias()
	{
		static $result = null;
		if ( is_null( $result ) )
		{
			$result = array();
			$rs = $this->fetchAll();
			foreach ($rs as $row)
			{
				$alias = $row->AliasName;
				$teamId = $row->TeamId;
				$result[ $alias ] = $teamId;
			}
		}
		return $result;
	}
	
	public function getAliasNamesByTeamId()
	{
		static $result = null;
		if ( is_null($result) )
		{
			$result = array();
			$rs = $this->fetchAll();
			foreach ( $rs as $row )
			{
				$result[ $row->TeamId ][] = $row->AliasName;
			}
		}
		return $result;
	}
}