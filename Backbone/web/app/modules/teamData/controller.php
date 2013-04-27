<?php
require_once '/MMS/Controller.php';

class TeamData_Controller extends MMS_Controller
{
	public function __construct()
	{
		parent::__construct();

		$req = $this->getRequest();
		$isRaw = $req->getVar('raw') !== false;
		
		if ($isRaw)
		{
			/*
			 * set the headers that are needed for a json return.
			*/
			header('Content-Type: application/json');
		}
	}
	
	public function conference()
	{
		require_once '/MMS/Db/Table/Football/Conference.php';
		$confTable = new MMS_Db_Table_Football_Conference();
		$rows = $confTable->fetchAll();

		$this->view->conferences = json_encode( $rows->toArray() );
	}
	
	public function division()
	{
		require_once '/MMS/Db/Table/Football/Division.php';
		$divTable = new MMS_Db_Table_Football_Division();
		$rows = $divTable->fetchAll();
		
		$this->view->divisions = json_encode( $rows->toArray() );
	}
	
	public function league()
	{
		require_once '/MMS/Db/Table/Football/League.php';
		$table = new MMS_Db_Table_Football_League();
		$rows = $table->fetchAll();
		
		$this->view->leagues = json_encode( $rows->toArray() );
	}
	
	public function season()
	{
		require_once '/MMS/Db/Table/Football/Season.php';
		$table = new MMS_Db_Table_Football_Season();
		$rows = $table->fetchAll();
		
		$this->view->seasons = json_encode( $rows->toArray() );
	}
	
	public function team()
	{
		require_once '/MMS/Db/Table/Football/Team.php';
		$table = new MMS_Db_Table_Football_Team();
		$rows = $table->fetchAll();
		
		$this->view->teams = json_encode( $rows->toArray() );
	}
	
	public function teamAlias()
	{
		require_once '/MMS/Db/Table/Football/TeamAlias.php';
		$table = new MMS_Db_Table_Football_TeamAlias();
		$rows = $table->fetchAll();
		
		$this->view->aliases = json_encode( $rows->toArray() );
	}
	
	public function teamGame()
	{
		require_once '/MMS/Db/Table/Football/TeamGame.php';
		$table = new MMS_Db_Table_Football_TeamGame();
		$rows = $table->fetchAll();
		
		$this->view->games = json_encode( $rows->toArray() );
	}
	
	public function teamSeason()
	{
		require_once '/MMS/Db/Table/Football/TeamSeason.php';
		$table = new MMS_Db_Table_Football_TeamSeason();
		$method = $this->getRequest()->getMethod();

		if ($method == MMS_Request::REQUEST_GET)
		{
			$rows = $table->fetchAll();
			$this->view->teams = json_encode( $rows->toArray() );
		}
		elseif ($method = MMS_Request::REQUEST_POST)
		{
			$data	= $this->getRequest()->getVar('data');
			$this->view->teams = $data;
			
			$where	= 'TeamSeasonId=' . $data['TeamSeasonId'];
			unset( $data['TeamSeasonId'] );

			$table->update($data, $where);
		}
	}
	
	public function week()
	{
		require_once '/MMS/Db/Table/Football/Week.php';
		$table = new MMS_Db_Table_Football_Week();
		$rows = $table->fetchAll();
		
		$this->view->weeks = json_encode( $rows->toArray() );
	}
}