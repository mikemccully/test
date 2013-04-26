<?php
require_once '/MMS/DOMParser/Abstract.php';

class MMS_DOMParser_Yahoo_Document extends MMS_DOMParser_Abstract
{
	/**
	 * (non-PHPdoc)
	 * @see MMS_DOMParser_Abstract::getBaseUrl()
	 */
	public function getBaseUrl()
	{
		return 'http://sports.yahoo.com';
	}
	
	/**
	 * @return string[]
	 */
	public function getWeekLinks()
	{
		$xpathQuery = '//*[@id="scoreboard"]/tr[2]/td[1]/table/tr[3]/td[1]/table[1]/tr/td/a';
		$list = $this->getXPath()->query( $xpathQuery );

		$links = array();
		for($i = 0; $i < $list->length; $i++)
		{
			$node = $list->item($i);
			$link = $this->nodeToString($node);
			$attributes = $node->attributes;
			$domAttr = $attributes->getNamedItem('href');
			$url = $domAttr->nodeValue;

			$links[] = $url;
		}
		return $links;
	}

	/**
	 * (non-PHPdoc)
	 * @see MMS_DOMParser_Abstract::getGameDays()
	 */
	public function getGameDays()
	{
		$xpathQuery = '//td[@class="yspdetailttl"]';
		$list = $this->getXPath()->query( $xpathQuery );
		$dates = array();

		for ($i = 0; $i < $list->length; $i++)
		{
			$dates[] = trim( $list->item($i)->nodeValue );
		}

		return $dates;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see MMS_DOMParser_Abstract::getScoreboardGameNode()
	 */
	public function getScoreboardGameNodes()
	{
		require_once '/MMS/DOMParser/Yahoo/ScoreboardGame.php';
		
		$xpathQuery = '//table[@class="ysptblclbg3"]';
		$list = $this->getXPath()->query( $xpathQuery );

		$nodes = array();
		for ($i = 0; $i < $list->length; $i++)
		{
			$nodes[] = new MMS_DOMParser_Yahoo_ScoreboardGame($list->item($i));
		}
		
		return $nodes;
	}
}