<?php
require_once './../queries.php';
$config=include 'config.php';
$dsn=$config['dsn'];
$user=$config['user']??'sio2a';
$password=$config['password']??'sio2a';
$op=OPS[$config['op']];
$count=$config['count']??null;
if(\function_exists($op)) {
	$op(connect($dsn, $user, $password), $count);
}

require $_SERVER['DOCUMENT_ROOT'].'/libs/output_data.php';
