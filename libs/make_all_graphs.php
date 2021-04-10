<?php
function makeAllGraphs($results,$context){
	$elements=[];
	// RPS Benchmark
	$elements['rps']= make_graph($results,$context,'rps', 'Throughput', 'requests per second');
	
	// Exec Time Benchmark
	$elements['time'] = make_graph($results,$context,'time', 'Exec Time', 'ms');
	
	// Memory Benchmark
	$elements['memory'] = make_graph($results,$context,'memory', 'Memory', 'peak memory (MB)');
	
	// Included Files
	$elements['file'] = make_graph($results,$context,'file', 'Included Files', 'count');
	
	// DB queries
	$elements['queries'] = make_graph($results,$context,'queries', 'DB queries', 'count');
	
	// DB rows read
	$elements['rows'] = make_graph($results,$context,'rows', 'DB rows read', 'count');
	return $elements;
}

function createMenu($context,$elements){
	$result='<div class="ui secondary  menu">';
	foreach ($elements as $key=>$elm){
		$result.="<a href='#{$context}-{$key}' class='item'>{$key}</a>";
	}
	$result.="</div>";
	return $result;
}