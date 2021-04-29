<?php
require_once './../queries.php';
$config=include 'config.php';
$user=$config['user'];
$password=$config['password'];
$op=OPS[$config['op']];
$count=$config['count']??null;
if(\function_exists($op)) {
	$op(connect( $user, $password), $count);
}

require $_SERVER['DOCUMENT_ROOT'].'/php-orm-benchmark/libs/output_data.php';
