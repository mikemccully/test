<?php
class MMS_Controller
{
	protected $view;
	private $request;
	
	public function getView()
	{
		return $this->view;
	}

	/**
	 * 
	 * @param MMS_Request $request
	 */
	public function setRequest($request)
	{
		$this->request = $request;
	}
	
	/**
	 * 
	 * @return MMS_Request
	 */
	public function getRequest()
	{
		return $this->request;
	}
	
	public function __construct()
	{
		$this->view = new stdClass();

		require_once '/MMS/Request.php';
		$request = MMS_Request::instance();
		$this->setRequest($request);
	}
}