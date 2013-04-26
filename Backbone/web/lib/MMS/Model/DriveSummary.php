<?php
class MMS_Model_DriveSummary
{
	public $BeginYard;
	public $DriveSummaryId;
	public $TeamGameId;
	public $YardsGained;
	public $NumberOfPlays;
	public $Quarter;
	public $Result;
	public $StartTime;
	public $TimeOfPossession;
	public $Points;

	/**
	 * @return string
	 */
	public function getBeginYard()
	{
		return $this->BeginYard;
	}

	/**
	 * @return int
	 */
	public function getDriveSummaryId()
	{
		return $this->DriveSummaryId;
	}

	/**
	 * @return int
	 */
	public function getTeamGameId()
	{
		return $this->TeamGameId;
	}

	/**
	 * @return int
	 */
	public function getYardsGained()
	{
		return $this->YardsGained;
	}

	/**
	 * @return int
	 */
	public function getNumberOfPlays()
	{
		return $this->NumberOfPlays;
	}

	/**
	 * @return int
	 */
	public function getQuarter()
	{
		return $this->Quarter;
	}

	/**
	 * @return string
	 */
	public function getResult()
	{
		return $this->Result;
	}

	/**
	 * @return string
	 */
	public function getStartTime()
	{
		return $this->StartTime;
	}

	/**
	 * @return string
	 */
	public function getTimeOfPossession()
	{
		return $this->TimeOfPossession;
	}
	
	/**
	 * @return int
	 */
	public function getPoints()
	{
		return $this->Points;
	}
	
	/**
	 * 
	 * @param string newVal
	 */
	public function setBeginYard($newVal)
	{
		$this->BeginYard = $newVal;
	}

	/**
	 * 
	 * @param int newVal
	 */
	public function setDriveSummaryId($newVal)
	{
		$this->DriveSummaryId = $newVal;
	}

	/**
	 * 
	 * @param int newVal
	 */
	public function setTeamGameId($newVal)
	{
		$this->TeamGameId = $newVal;
	}

	/**
	 * 
	 * @param int newVal
	 */
	public function setYardsGained($newVal)
	{
		$this->YardsGained = $newVal;
	}
	
	/**
	 * 
	 * @param int newVal
	 */
	public function setNumberOfPlays($newVal)
	{
		$this->NumberOfPlays = $newVal;
	}

	/**
	 * 
	 * @param int newVal
	 */
	public function setQuarter($newVal)
	{
		$this->Quarter = $newVal;
	}

	/**
	 * 
	 * @param string newVal
	 */
	public function setResult($newVal)
	{
		$this->Result = $newVal;
	}

	/**
	 * 
	 * @param string newVal
	 */
	public function setStartTime($newVal)
	{
		$this->StartTime = $newVal;
	}

	/**
	 * 
	 * @param string newVal
	 */
	public function setTimeOfPossession($newVal)
	{
		$this->TimeOfPossession = $newVal;
	}

	/**
	 * @param int $points
	 */
	public function setPoints( $points )
	{
		$this->Points = $points;
	}

	function __construct( $row )
	{
		$this->setBeginYard( $row['BeginYard'] );
		$this->setDriveSummaryId( $row['DriveSummaryId'] );
		$this->setTeamGameId( $row['TeamGameId'] );
		$this->setNumberOfPlays( $row['NumberOfPlays'] );
		$this->setQuarter( $row['Quarter'] );
		$this->setResult( $row['Result'] );
		$this->setStartTime( $row['StartTime'] );
		$this->setTimeOfPossession( $row['TimeOfPossession'] );
		$this->setYardsGained( $row['YardsGained'] );
		$this->determinePoints();
	}
	
	public function determinePoints()
	{
		$result	= $this->getResult();
		$points	= 0;
		/*
		 * If the result was a td, then add 7 points.
		 */
		if ( stristr( $result, 'TD' ) !== false )
		{
			$points = 7;
		}
		/*
		 * Else if the result was a fg, then add 3 points.
		 */
		elseif ( stristr( $result, 'FG' ) !== false )
		{
			$points = 3;
		}
		$this->setPoints( $points );
	}

	/**
	 * With the information provided, determine if a drive is a value drive. A
	 * value drive is defined as starting on the far side of the 50 yard line 
	 * and crossing the opponents 30 yard line.
	 * 
	 * @return boolean
	 */
	public function AnalyzeDrive( $teamId, $aliasArray )
	{
		/*
		 * Get the necessary properties from the drive summary.
		 */
		$startSplit		= explode( ' ', $this->getBeginYard() );
		$yardsGained	= $this->getYardsGained();

		/*
		 * Determine the starting yard line.
		 */
		$startAlias = trim( $startSplit[0] );
		if ( isset( $startSplit[1] ) )
		{
			$startYard = (int)trim( $startSplit[1] );
		}
		else 
		{
			$startYard = 50;
		}
		
		$isValueDrive = 0;
		
		/*
		 * Create the analysis object that will be saved. Set all values with
		 * defaults. Some values will need to be changed later in this method.
		 */
		require_once '/MMS/Model/DriveSummaryAnalysis.php';
		$anaObj	= array();
		$anaObj['DriveSummaryId']	= $this->getDriveSummaryId();
		$anaObj['TeamId']			= $teamId;
		$anaObj['BeginYard']		= $startYard;
		$anaObj['BeginSide']		= MMS_Model_DriveSummaryAnalysis::BEGIN_SIDE_OPPONENT;
		$anaObj['Points']			= $this->getPoints();
		$anaObj['IsValueDrive']		= 0;

		/*
		 * The startSide should be a team alias. If it is one of the target
		 * team's aliases, then the start was past the 50 yard line, which is
		 * the first requirement in a value drive.
		 */
		if ( in_array( $startAlias, $aliasArray ) )
		{
			$anaObj['BeginSide']	= MMS_Model_DriveSummaryAnalysis::BEGIN_SIDE_OWN;
			/*
			 * If the starting yard plus yards gained passes the 30 yard line,
			 * then this is a value drive.
			 */
			$endYard = 50 - ( $yardsGained - ( 50 - $startYard ) );
			if ( $endYard <= 30 )
			{
				$anaObj['IsValueDrive']	= 1;
			}
		}

		return $anaObj;
	}
}