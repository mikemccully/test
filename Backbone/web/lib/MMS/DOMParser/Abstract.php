<?php
abstract class MMS_DOMParser_Abstract
{
	private $document;
	
	/**
	 * @param DOMDocument $document
	 */
	public function setDocument($document)
	{
		$this->document = $document;
	}
	
	/**
	 * @return DOMDocument
	 */
	public function getDocument()
	{
		return $this->document;
	}
	
	/**
	 * 
	 */
	public function __construct()
	{
	}
	
	/**
	 * @return DOMXPath
	 */
	protected function getXPath()
	{
		static $xpath = null;
		if ( !$xpath )
		{
			$xpath = new DOMXPath( $this->getDocument() );
		}
		return $xpath;
	}

	/**
	 * Convert a DOMNode to a string and return.
	 * 
	 * @param DOMNode $node
	 */
	public function nodeToString( $node )
	{
		return $this->getDocument()->saveXML( $node );
	}
	
	/**
	 * @return string
	 */
	public abstract function getBaseUrl();



	/**
	 * These following abstract classes need to be put into a new class that extends
	 * this one, or represented in an interface. This class is the base for things other
	 * than the schedule parsing
	 */

	/**
	 * @return string[]
	 */
	public abstract function getWeekLinks();
	/**
	 * @return string[]
	 */
	public abstract function getGameDays();
	/**
	 * @return MMS_DOMParser_IScoreboardGameNode
	 */
	public abstract function getScoreboardGameNodes();
}