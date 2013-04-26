<?php
require_once '/MMS/DOMParser/Node.php';
require_once '/MMS/DOMParser/IScoreboardGameNode.php';

class MMS_DOMParser_Yahoo_ScoreboardGame extends MMS_DOMParser_Node
	implements MMS_DOMParser_IScoreboardGameNode
{
	/**
	 * @return string
	 */
	public function getAwayTeam()
	{
		return $this->getTeam(0);
	}

	/**
	 * @return string
	 */
	public function getHomeTeam()
	{
		return $this->getTeam(1);
	}
	
	protected function getTeam($index)
	{
		$xpathQuery = '//td[@class="yspscores"]/b/a | //td[@class="yspscores team"]/b/a';
		$list = $this->getXPath()->query( $xpathQuery );
		
		$team = $list->item($index)->nodeValue;
		return $team;
	}
	
	/**
	 * A game that has been played will have a box score link. If this is present,
	 * then return the Url, else return false.
	 */
	public function getBoxScoreUrl()
	{
		$url 		= false;
		$xpathQuery	= '//a[@class="yspmore"]';
		$list 		= $this->getXPath()->query( $xpathQuery );
		$node		= $list->item(0);
		if (trim($node->nodeValue) == 'Box Score')
		{
			$url		= $node->attributes->getNamedItem('href')->nodeValue;
		}
		return $url;
	}
	
	/**
	 * Before the week is played, the game has an 'add to calendar' node that has
	 * the date in the url provided. If that node is present, parse the date out
	 * of it, else return false.
	 * 
	 * @return string
	 */
	public function getCalendarDate()
	{
		$xpathQuery = '//a[@class="yspmore"]';
		$list = $this->getXPath()->query( $xpathQuery );

		/*
		 * On a week that is in the future, the first item is the date node. This is
		 * not the case for the current week, and it doesn't exist on past games.
		 */
		$node	= $list->item(0);
		$href	= $node->attributes->getNamedItem('href')->nodeValue;
		$start	= stripos($href, '&ST=') + 4;
		$date	= strtotime( substr( $href, $start, 16 ) );

		return $date;
	}
	
}