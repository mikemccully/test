<?php

// require_once '/MMS/Db.php';
// $db = MMS_Db::instance();
// $tables = $db->listTables();

// echo nl2br(print_r($tables, true));

require_once './app/application.php';
$app = new Application();
$app->display();
