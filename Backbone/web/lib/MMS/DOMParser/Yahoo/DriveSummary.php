<?php
require_once '/MMS/DOMParser/Yahoo/Document.php';

class MMS_DOMParser_Yahoo_DriveSummary extends MMS_DOMParser_Yahoo_Document
{
	const HOME_CLASS_NAME = 'home';
	const AWAY_CLASS_NAME = 'away';

	/**
	 * Parses and returns the requested team name from the box score area. This
	 * is the full team name (ex. Houston Texans).
	 * 
	 * @param string $className
	 * @return string
	 */
	public function getTeamName( $className )
	{
		$xpathQuery = './/div[@id="ysp-reg-box-line_score"]//div[@class="' . $className . '"]/h6';
		$list = $this->getXPath()->query( $xpathQuery );
		$teamName = trim( $list->item( 0 )->nodeValue );

		return $teamName;
	}

	/**
	 * Parses and returns the final score for the requested team.
	 * 
	 * @param string $className
	 * @return string
	 */
	public function getTeamScore( $className )
	{
		$xpathQuery	= './/div[@id="ysp-reg-box-line_score"]//div[@class="board"]/div/table/tbody/tr';
		$list		= $this->getXPath()->query( $xpathQuery );
		$node		= null;
		switch ( $className )
		{
			case self::HOME_CLASS_NAME:
				$node = $list->item(1);
				break;
			case self::AWAY_CLASS_NAME:
				$node = $list->item(0);
				break;
		}
		$xpathQuery		= './/td[@class="period"]';
		$quarterList	= $this->getXPath()->query( $xpathQuery, $node );
		$points			= array();
		for ( $period = 0; $period < $quarterList->length; $period++ )
		{
			$points[$period]	= $quarterList->item($period)->nodeValue;
		}
		
		return $points;
	}
	
	/**
	 * Returns an array of drive summary arrays. There are 4 elements, each
	 * element contains the drive summary array for that quarter (1,2,3,4).
	 *
	 * @param string $className
	 * @return string[][]
	 */
	public function getTeamDriveSummaryByQuarter( $className )
	{
		$quarterList = $this->getTeamDriveSummaryNodes( $className );
		$xpathQuery = './/tr';
		$summary = array();
		$quarter = 1;
		foreach ( $quarterList as $quarterNode )
		{
			$list = $this->getXPath()->query( $xpathQuery, $quarterNode );
			for ( $i = 0; $i < $list->length; $i++ )
			{
				$rowNode = $list->item( $i );
				$summary[ $quarter ][ $i ][ 'StartTime' ]		= '0:' . $this->getDriveSummaryValue( $rowNode, 'start title' );
				$summary[ $quarter ][ $i ][ 'TimeOfPossession' ]= '0:' . $this->getDriveSummaryValue( $rowNode, 'time title' );
				$summary[ $quarter ][ $i ][ 'BeginYard' ]		= $this->getDriveSummaryValue( $rowNode, 'began' );
				$summary[ $quarter ][ $i ][ 'NumberOfPlays' ]	= $this->getDriveSummaryValue( $rowNode, 'plays' );
				$summary[ $quarter ][ $i ][ 'YardsGained' ]		= $this->getDriveSummaryValue( $rowNode, 'yards' );
				$summary[ $quarter ][ $i ][ 'Result' ]			= $this->getDriveSummaryValue( $rowNode, 'result' );
			}
			$quarter++;
		}

		return $summary;
	}
	
	/**
	 * Get the drive summary nodes. This will return a node for each quarter
	 * (i.e. 4 nodes). These nodes will have to be broken down further for the
	 * actual statistics.
	 *
	 * @return DOMNodeList
	 */
	protected function getTeamDriveSummaryNodes( $className )
	{
		switch( $className )
		{
			case self::AWAY_CLASS_NAME:
				$className = 'yui-u first';
				break;
	
			case self::HOME_CLASS_NAME:
			default:
				$className = 'yui-u';
				break;
	
		}
	
		$xpathQuery = './/div[@class="' . $className . '"]/table/tbody';
		$list = $this->getXPath()->query( $xpathQuery );

		return $list;
	}
	
	/**
	 * Return the value of the requested Drive Summary metric.
	 *
	 * @param DOMNode $parentNode
	 * @param string $valueName
	 *
	 * @return string
	 */
	protected function getDriveSummaryValue( $parentNode, $valueName )
	{
		$xpathQuery = './/td[@class="' . $valueName . '"]';
		$valueList = $this->getXPath()->query( $xpathQuery, $parentNode );
		return $valueList->item( 0 )->nodeValue;
	}
}