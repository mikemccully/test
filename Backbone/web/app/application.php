<?php
class Application
{
	private $request;

	/**
	 * @param MMS_Request $request
	 */
	public function setRequest($request)
	{
		$this->request = $request;
	}

	/**
	 * @return MMS_Request
	 */
	public function getRequest()
	{
		return $this->request;
	}
	
	public function __construct()
	{
		set_include_path('./lib;./app/modules');
		
		// We need to have a default timezone to use date functions.
		date_default_timezone_set('America/Chicago');
		
		require_once '/MMS/Request.php';
		$request = MMS_Request::instance();
		$this->setRequest($request);
	}
	
	protected function content()
	{
		$controller	= $this->getRequest()->getControllerName();
		$module		= $this->getRequest()->getModuleName();

		$ctrlObj	= $this->buildController();

		require_once "/{$module}/view/{$controller}.phtml";
	}
	
	protected function navigation()
	{
		require_once './app/modules/navigation/navigation.php';
		$nav = new Navigation();
		$nav->display();
	}

	/**
	 * Instantiate the controller and call the function to build the view 
	 * parameters.
	 * 
	 * @return MMS_Controller
	 */
	protected function buildController()
	{
		$controller	= $this->getRequest()->getControllerName();
		$module		= $this->getRequest()->getModuleName();

		require_once "/{$module}/controller.php";
		$ctrlName	= ucfirst($module) . '_Controller';
		$ctrlObj	= new $ctrlName();

		/* @var $ctrlObj MMS_Controller */
		$ctrlObj->$controller();
		$this->populateViewVars($ctrlObj);
		
		return $ctrlObj;
	}
	
	/**
	 * Populate the variables from the controller that are the variables used
	 * in the view in the context of $this.
	 * 
	 * @param MMS_Controller $ctrlObj
	 */
	protected function populateViewVars($ctrlObj)
	{
		$ctrlView	= $ctrlObj->getView();
		$viewVars	= get_object_vars($ctrlView);
		foreach ($viewVars as $varName => $varValue)
		{
			$this->$varName = $varValue;
		}
	}
	
	public function display()
	{
		/*
		 * If the 'raw' variable is in the request, then I don't want to return 
		 * the frame. I just want to return the content. This is an option used
		 * for ajax requests.
		 */
		if ($this->getRequest()->getVar('raw') !== false)
		{
			$this->content();
		}
		else 
		{
			require_once './app/frame/frame.phtml';
		}
	}
}