<?php

namespace libs;

use controllers\Main;

class BuildResults {
	private static $index=1;
	private static $barColors=array(
			'#14485f', 'DarkCyan', 'DarkGoldenRod', 'DarkGray', 'DarkGreen',
			'DarkKhaki', 'DarkMagenta', 'DarkOliveGreen', 'DarkOrange', 'DarkOrchid',
			'DarkRed', 'DarkSalmon', 'DarkSeaGreen', 'DarkSlateBlue', 'DarkSlateGray',
			'DarkBlue', 'DarkCyan', 'DarkGoldenRod', 'DarkGray', 'DarkGreen',
			'DarkKhaki', 'DarkMagenta', 'DarkOliveGreen', 'DarkOrange', 'DarkOrchid',
			'DarkRed', 'DarkSalmon', 'DarkSeaGreen', 'DarkSlateBlue', 'DarkSlateGray',
	);
	
	private static $fwBarColors=[];
	
	public static function getBarColor($fw){
		if(!isset(self::$fwBarColors[$fw])){
			self::$fwBarColors[$fw]=array_shift(self::$barColors);
		}
		return self::$fwBarColors[$fw];
	}
	
	public static function parseResults($file){
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
			if ($min_rps != 0) {
				$results[$fw]['rps_relative'] = $data['rps'] / $min_rps;
			}
			if ($min_memory != 0) {
				$results[$fw]['memory_relative'] = $data['memory'] / $min_memory;
			}
			if ($min_time != 0) {
				$results[$fw]['time_relative'] = $data['time'] / $min_time;
			}
			if ($min_file != 0) {
				$results[$fw]['file_relative'] = $data['file'] / $min_file;
			}
			if ($min_queries != 0) {
				$results[$fw]['queries_relative'] = $data['queries'] / $min_queries;
			}
			if ($min_rows != 0) {
				$results[$fw]['rows_relative'] = $data['rows'] / $min_rows;
			}
		}
		
		\array_multisort(\array_column($results, 'rps'), SORT_DESC, $results);
		return $results;
	}
	
	public static function makeAllGraphs($dataCallback,$context,$chartType = 'ColumnChart'){
		$elements=[];
		$elements['rps']= self::make_graph($dataCallback,$context,'rps', 'Throughput', 'requests per second',$chartType);
		$elements['time'] = self::make_graph($dataCallback,$context,'time', 'Exec Time', 'ms',$chartType);
		$elements['memory'] = self::make_graph($dataCallback,$context,'memory', 'Memory', 'peak memory (MB)',$chartType);
		$elements['file'] = self::make_graph($dataCallback,$context,'file', 'Included Files', 'count',$chartType);
		$elements['queries'] = self::make_graph($dataCallback,$context,'queries', 'DB queries', 'count',$chartType);
		$elements['rows'] = self::make_graph($dataCallback,$context,'rows', 'DB rows read', 'count',$chartType);
		return $elements;
	}
	
	public static function make_graph($dataCallback,$context,$id, $title, $hAxis_title,$type = 'ColumnChart'){
		$graphWidth  = 1000;
		$graphHeight = 400;
		
		$data = $dataCallback($id);
		
		$options = array(
				'title'  => $title,
				'titleTextStyle' => array('fontSize' => 16),
				'hAxis'  => array('title' => $hAxis_title,
						'titleTextStyle' => array('bold' => true)),
				'vAxis'  => array('minValue' => 0, 'maxValue' => 0.01),
				'width'  => $graphWidth,
				'height' => $graphHeight,
				'bar'    => array('groupWidth' => '90%'),
				'legend' => array('position' => 'none'),
				'fontName'=>"Lato,'Helvetica Neue',Arial,Helvetica,sans-serif"
		);
		$hidden="";
		if(!Main::displayField($id)){
			$hidden="style='display:none;'";
		}
		$result= self::makeChartPart($data, $options, $type);
		$result["div"]='<div '.$hidden.' id="'.$context.'-'.$id.'" class="_field '.$id.'">'.$result["div"]."</div>";
		return $result;
	}
	
	private static function makeChartPart($data, $options,$type){
		$index=self::$index;
		$jsData = json_encode($data);
		$jsonOptions = json_encode($options);
		
		$chart = <<<CHART_FUNC
    function drawChart{$index}() {
      var data = {$jsData};
      var chartData = new google.visualization.arrayToDataTable(data);
      var options = {$jsonOptions};
      var chartDiv = document.getElementById('chart{$index}');
      var chart = new google.visualization.{$type}(chartDiv);
      chart.draw(chartData, options);
    }\n
CHART_FUNC;
    
    $div = '<div id="chart' . $index . '"></div>';
    
    self::$index++;
    return compact("chart", "div");
	}
	
	public static function loadGoogleChart($type){
		$package = 'corechart';
		$special_type = array('GeoChart', 'AnnotatedTimeLine','TreeMap', 'OrgChart',
				'Gauge', 'Table', 'TimeLine', 'GeoMap', 'MotionChart');
		if (in_array($type, $special_type)) {
			$package = strtolower($type);
		}
		
		$callback="";
		for($index=1;$index<self::$index;$index++){
			$callback.="drawChart{$index}();";
		}
		$load = 'google.load("visualization", "1", {packages:["' . $package . '"],callback: function (){'.$callback.'}});';
    	return $load;
	}
}

