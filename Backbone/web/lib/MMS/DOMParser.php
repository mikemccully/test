<?php
class MMS_DOMParser
{
	const SITE_YAHOO = 'yahoo';
	
	const SCRAPE_SCHEDULE = 'schedule';
	const SCRAPE_BOXSCORE = 'boxscore';
	
	
	/**
	 * At this time, $site can only be 'yahoo'.
	 * 
	 * @param string $site
	 * 
	 * @return MMS_DOMParser_Abstract
	 */
	public static function factory($site = self::SITE_YAHOO, $scrape = self::SCRAPE_SCHEDULE)
	{
		$document = false;
		switch($site)
		{
			case self::SITE_YAHOO:
			default:
				$document = self::yahooFactory($scrape);
				break;
		}
		
		return $document;
	}
	
	private static function yahooFactory($scrape)
	{
		$document = false;
		switch($scrape)
		{
			case self::SCRAPE_BOXSCORE:
				require_once '/MMS/DOMParser/Yahoo/DriveSummary.php';
				$document = new MMS_DOMParser_Yahoo_DriveSummary();
				break;
			case self::SCRAPE_SCHEDULE:
			default:
				require_once '/MMS/DOMParser/Yahoo/Document.php';
				$document = new MMS_DOMParser_Yahoo_Document();
				break;
		}
		
		return $document;
	}
}