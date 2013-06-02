<?php
require_once '/Zend/Db.php';

class MMS_Db extends Zend_Db
{
	public static function instance()
	{
		$adapterName	= static::getAdapterName();
		$config			= static::getConfig();
		$db				= static::factory($adapterName, $config);
		
		return $db;
	}

	/**
	 * Get the array that will be used to call the db factory.
	 * 
	 * @return multitype:string
	 */
	protected static function getConfig()
	{
		$config = array();

		/*
		 * Remote
		 */
// 		$config['dbname'] = 'mccully_football';
// 		$config['username'] = 'mccully_jkc';
// 		$config['password'] = 'LtLh2motM!';
// 		$config['host'] = 'mysql.mikemccully.com';

		/*
		 * Local
		 */
		$config['dbname'] = 'mccully_football';
		$config['username'] = 'mike';
		$config['password'] = 'LtLh2motM!';
		$config['host'] = 'Mike-PC';
		return $config;
	}

	/**
	 * Get the name of the adapter that we will use. I am choosing to use
	 * mysql pdo for this app.
	 * 
	 * @return string
	 */
	protected static function getAdapterName()
	{
		$adapterName = 'pdo_mysql';
		return $adapterName;
	}
}