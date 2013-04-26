<?php
class Navigation
{
	public function __construct()
	{
		
	}
	
	public function getLinks()
	{
		require_once '/MMS/Link.php';
		$links = array();

		$links[] = new MMS_Link(null, null, 'Home');

		/*
		 * This link provides the interface for editing the team conference
		 * and division information.
		 */
// 		$links[] = new MMS_Link('teamEdit', 'teamSeason', 'Edit Teams');

		return $links;
	}
	
	public function display()
	{
		require_once '/navigation/links.phtml';
	}
}