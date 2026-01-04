<?php
// define = vytvoreni konstanty
define('DB_NAME', 'd315069_cajovna');
define('DB_USER', 'a315069_cajovna');
define('DB_PASSWORD', 'LTchwQc7');
define('DB_HOST', 'md397.wedos.net');

global $db;
$db = new PDO(
        "mysql:host=" .DB_HOST. ";dbname=" .DB_NAME,DB_USER,DB_PASSWORD,
        array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        )
);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>