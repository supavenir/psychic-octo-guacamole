<?php
const OP_SELECT_PK='selectPkQuery';
const OP_SELECT_NO_PK='selectNoPKQuery';
const OP_JOIN='joinQuery';
const OP_UPDATE='updateQuery';
const OPS=[OP_SELECT_PK,OP_SELECT_NO_PK,OP_JOIN,OP_UPDATE];

function connect($dsn,$user,$password){
	try {
		$db = new \PDO('pgsql:host=127.0.0.1;dbname=pgsqlbig', $user, $password);
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

	} catch (\PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		return false;
	}
	return $db;
}

function query(\PDO $db,string $sql){
	$st=$db->query($sql);
	return $st->fetchAll();
}

function executeQuery(\PDO $db,string $sql){
	return $db->exec($sql);
}

function selectPkQuery(\PDO $db,int $max){
	$id=\mt_rand(1, $max);
	return query($db,"select * from user_ where id='$id'");
}

function selectNoPKQuery(\PDO $db){
	return query($db,"select * from user_ where firstname='Allistair'");
}

function joinQuery(\PDO $db){
	return query($db,"select category.* from user_ inner join category on user_.idCategory=category.id where firstname='Allistair'");
}

function updateQuery(\PDO $db,int $max){
	$id=\mt_rand(1, $max);
	return executeQuery($db,"update user_ set lastname='aaa' where id='$id'");
}