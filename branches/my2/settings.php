<?php

$settings = array();

// DATABASE settings
$settings['driver'] = 'mysql';
$settings['host'] = 'localhost';
$settings['user'] = 'root';
$settings['password'] = '';
$settings['database'] = 'my2';
$settings['database_prefix'] = 'bs_';

// SITE settings
$settings['debug'] = true;

// LOCALE settings
//locale_storage = [db|fs]
$settings['locale_storage'] = 'db';
//work only for db
$settings['locale_auto_fill'] = true;

?>