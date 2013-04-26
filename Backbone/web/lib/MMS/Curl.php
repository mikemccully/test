<?php

class MMS_cURL
{
	private $url;
	private $content;

	/**
	 * @param string $url
	 */
	public function setURL( $url )
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getURL()
	{
		return $this->url;
	}
	
	public function setContent( $content )
	{
		$this->content = $content;
	}
	
	public function getContent()
	{
		return $this->content;
	}

	public function __construct( $url )
	{
		$this->setURL( $url );
		$this->execute();
	}

	/**
	 * Execute the curl command and store the response in the content 
	 * property.
	 */
	protected function execute()
	{
		$ch = curl_init();
		$url = $this->getURL();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HEADER, FALSE );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		$this->setContent( curl_exec( $ch ) );
		curl_close( $ch );
	}
	
	public function getDOMDocument()
	{
		$currErrorLevel = error_reporting();
		error_reporting( E_ERROR );
		/* @var $dom DOMDocument */
		$dom = DOMDocument::loadHTML( $this->getContent() );
		error_reporting( $currErrorLevel );
		return $dom;
	}
}

?>