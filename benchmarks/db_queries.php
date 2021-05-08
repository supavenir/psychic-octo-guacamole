<?php
if(\strpos(@$argv[1],'queries')!==-1) {
	$dsn = 'mysql:dbname=innodb-large;host=127.0.0.1';
	$user = 'sio2a';
	$password = 'sio2a';

	try {
		$db = new \PDO($dsn, $user, $password);
		$clear = @$argv[2];
		$st = $db->query("Show session status like 'Queries';");
		$q = $st->fetchColumn(1);
		$st->closeCursor();
		$st = $db->query("show session status like 'Innodb_rows_read';");
		$r = $st->fetchColumn(1);
		echo $q . ':' . $r;
		$st->closeCursor();
		if (isset($clear)) {
			$db->exec("RESET QUERY CACHE;");
		}
	} catch (\PDOException $e) {
		echo $e->getMessage();
	}
}else {
	echo '0:0';
}