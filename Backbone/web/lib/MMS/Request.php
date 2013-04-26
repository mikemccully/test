<?php
class MMS_Request
{
	private $moduleName;
	private $controllerName;
	private $method;
	
	const REQUEST_GET		= 'GET';
	const REQUEST_POST		= 'POST';
	const REQUEST_PUT		= 'PUT';
	const REQUEST_DELETE	= 'DELETE';
	
	public function setModuleName($moduleName)
	{
		$this->moduleName = $moduleName;
	}
	
	public function getModuleName()
	{
		return $this->moduleName;
	}
	
	public function setControllerName($controllerName)
	{
		$this->controllerName = $controllerName;
	}
	
	public function getControllerName()
	{
		return $this->controllerName;
	}

	/**
	 * @param string $method
	 */
	public function setMethod($method)
	{
		$this->method = strtoupper($method);
	}

	/**
	 * The request method that was used.
	 * 	i.e. [GET, POST, PUT, DELETE]
	 * 
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}
	
	protected function __construct()
	{
		$method		= $_SERVER['REQUEST_METHOD'];

		/*
		 * PHP currently doesn't recognize the PUT request. I read a bug 
		 * report on this. A hack work-around is to read the input,
		 * parse the string and insert it into the $_REQUEST global.
		 */
		if (strtolower($method) == 'put')
		{
			parse_str(file_get_contents("php://input"),$put_vars);
			
			foreach ($put_vars as $key => $var)
			{
				$_REQUEST[$key] = $var;
			}
		}

		$controller	= isset($_REQUEST['controller']) ? $_REQUEST['controller'] : 'index';
		$module		= isset($_REQUEST['module']) ? $_REQUEST['module'] : 'default';
		
		$this->setControllerName($controller);
		$this->setModuleName($module);
		$this->setMethod($method);
	}
	
	public static function instance()
	{
		static $instance = null;
		if (is_null($instance))
		{
			$instance = new MMS_Request();
		}
		return $instance;
	}

	/**
	 * Returns the named variable from the request, if it exists, else returns
	 * false.
	 * 
	 * @param string $name
	 * @return string|boolean
	 */
	public function getVar($name)
	{
		$value = false;
		if (isset($_REQUEST[$name]))
		{
			/*
			 * At some point, I should do some checking and sanitizing of the 
			 * variables before I process them.
			 */
			$value = $_REQUEST[$name];
		}

		return $value;
	}
}