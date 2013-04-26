<?php
class MMS_DOMParser_Node
{
	private $node;

	/**
	 * 
	 * @param DOMNode $node
	 */
	public function setNode($node)
	{
		$new = new DOMDocument();
		$new->appendChild(($new->importNode($node, true)));
		$this->node = $new;
	}

	/**
	 * 
	 * @return DOMDocument
	 */
	public function getNode()
	{
		return $this->node;
	}
	
	/**
	 * 
	 * @param DOMNode $node
	 */
	public function __construct($node)
	{
		$this->setNode($node);
	}

	/**
	 * This needs to be an extension of DOMNode abstract so that I don't have repeat
	 * code here.
	 * 
	 * @return DOMXPath
	 */
	protected function getXPath()
	{
		$xpath = new DOMXPath( $this->getNode() );
		return $xpath;
	}

}