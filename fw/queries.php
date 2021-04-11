<?php
const OP_SELECT_PK='selectPkQuery';
const OP_SELECT_NO_PK='selectNoPKQuery';
const OP_JOIN='joinQuery';
const OP_UPDATE='updateQuery';
const OPS=[OP_SELECT_PK,OP_SELECT_NO_PK,OP_JOIN,OP_UPDATE];

function connect($dsn,$user,$password){
	try {
		$db = new \PDO('pgsql:host=127.0.0.1;dbname=pgsqllarge', $user, $password);
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(\PDO::ATTR_PERSISTENT, true);

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

function prepare(\PDO $db,$sql):\PDOStatement{
	return $db->prepare($sql);
}

function executeQuery(\PDO $db,string $sql){
	$st=prepare($db,$sql);
	return $st->execute();
}

function selectPkQuery(\PDO $db,int $max){
	$st=prepare($db,'select * from user_ where id= ?');
	$id=\mt_rand(1, $max);
	return $st->execute([$id]);
}

function selectNoPKQuery(\PDO $db){
	$st=prepare($db,'select * from user_ where firstname= ?');
	return $st->execute(['Winter']);
}

function joinQuery(\PDO $db){
	$st=prepare($db,'select category_.* from user_ inner join category_ on user_.idCategory=category_.id where firstname= ?');
	return $st->execute(['Winter']);
}

function updateQuery(\PDO $db,int $max){
	$st=prepare($db,'update user_ set lastname= ? where id= ?');
	$id=\mt_rand(1, $max);
	return $st->execute(['aaa',$id]);
}