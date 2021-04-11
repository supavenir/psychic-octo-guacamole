<?php
const OP_SELECT_PK='selectPkQuery';
const OP_SELECT_NO_PK='selectNoPKQuery';
const OP_JOIN='joinQuery';
const OP_UPDATE='updateQuery';
const OP_LIKE='updateQuery';
const OP_COUNT='updateQuery';
const OPS=[OP_SELECT_PK,OP_SELECT_NO_PK,OP_JOIN,OP_UPDATE,OP_LIKE,OP_COUNT];

function connect($dsn,$user,$password){
	try {
		$db = new \PDO('pgsql:host=127.0.0.1;dbname=pgsqllarge', $user, $password,
		[
			\PDO::ATTR_PERSISTENT => true,
			\PDO::ATTR_EMULATE_PREPARES => false
		]);
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
	$st->execute([$id]);
	return $st->fetchAll();
}

function selectNoPKQuery(\PDO $db){
	$st=prepare($db,'select * from user_ where firstname= ?');
	$st->execute(['Winter']);
	return $st->fetchAll();
}

function joinQuery(\PDO $db){
	$st=prepare($db,'select category_.* from user_ inner join category_ on user_.idCategory=category_.id where firstname= ?');
	$st->execute(['Winter']);
	return $st->fetchAll();
}

function updateQuery(\PDO $db,int $max){
	$st=prepare($db,'update user_ set lastname= ? where id= ?');
	$id=\mt_rand(1, $max);
	return $st->execute(['aaa',$id]);
}

function likeQuery(\PDO $db){
	$st=prepare($db,'select * from user_ where firstname like ?');
	$st->execute(['%Winter%']);
	return $st->fetchAll();
}

function countQuery(\PDO $db){
	$st=prepare($db,'select count(*) from user_');
	$st->execute();
	return $st->fetchAll();
}