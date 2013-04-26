<?php
interface MMS_DOMParser_IScoreboardGameNode
{
	/**
	 * @return string
	 */
	public function getHomeTeam();
	/**
	 * @return string
	 */
	public function getAwayTeam();
	/**
	 * @return string
	 */
	public function getCalendarDate();
}