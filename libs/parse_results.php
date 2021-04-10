<?php

function parse_results($file)
{
    $lines = file($file);

    $results = [];
    $min_rps    = INF;
    $min_memory = INF;
    $min_time   = INF;
    $min_file   = INF;
    $min_queries= INF;
    $min_rows	= INF;

    foreach ($lines as $line) {
        $column = explode(':', $line);
        $fw = $column[0];
        $rps    = (float) trim($column[1]);
        $memory = (float) trim($column[2])/1024/1024;
        $time   = (float) trim($column[3])*1000;
        $file   = (int) trim($column[4]);
        $queries= (int) trim($column[5]);
        $rows	= (int) trim($column[6]);

        $min_rps    = min($min_rps, $rps);
        $min_memory = min($min_memory, $memory);
        $min_time   = min($min_time, $time);
        $min_file   = min($min_file, $file);
        $min_queries= min($min_queries, $queries);
        $min_rows= min($min_rows, $rows);

        $results[$fw] = [
            'rps'    => $rps,
            'memory' => round($memory, 2),
            'time'   => $time,
            'file'   => $file,
        	'queries'=> $queries,
        	'rows'   => $rows,
        ];
    }

    foreach ($results as $fw => $data) {
    	if($min_rps!=0)
        	$results[$fw]['rps_relative']    = $data['rps'] / $min_rps;
        if($min_memory!=0)
        	$results[$fw]['memory_relative'] = $data['memory'] / $min_memory;
        if($min_time!=0)
        	$results[$fw]['time_relative'] = $data['time'] / $min_time;
        if($min_file!=0)
        $results[$fw]['file_relative'] = $data['file'] / $min_file;
        if($min_queries!=0)
        	$results[$fw]['queries_relative'] = $data['queries'] / $min_queries;
        if($min_rows!=0)
        	$results[$fw]['rows_relative'] = $data['rows'] / $min_rows;
    }

    array_multisort(array_column($results, 'rps'), SORT_DESC, $results);
//    var_dump($results);

    return $results;
}
