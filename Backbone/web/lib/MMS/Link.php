<?php
class MMS_Link
{
	private $module;
	private $controller;
	private $label;

	public function setModule($module)
	{
		$this->module = $module;
	}
	
	public function getModule()
	{
		return $this->module;
	}
	
	public function setController($controller)
	{
		$this->controller = $controller;
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	public function setLabel($label)
	{
		$this->label = $label;
	}
	
	public function getLabel()
	{
		return $this->label;
	}
	
	public function __construct($module, $controller, $label)
	{
		$this->setModule($module);
		$this->setController($controller);
		$this->setLabel($label);
	}
}