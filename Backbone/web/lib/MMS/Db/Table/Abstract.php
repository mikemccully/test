<?php
require_once '/Zend/Db/Table/Abstract.php';

class MMS_Db_Table_Abstract extends Zend_Db_Table_Abstract
{
	public function __construct()
	{
		require_once '/MMS/Db.php';
		$db = MMS_Db::instance();
		parent::__construct($db);
	}
}