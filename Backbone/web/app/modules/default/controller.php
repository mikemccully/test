<?php
require_once '/MMS/Controller.php';

class Default_Controller extends MMS_Controller
{
	public function index()
	{
		$this->view->message = 'You have entered the default page.';
	}
}