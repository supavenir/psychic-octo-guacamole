<?php
return array(
		"siteUrl"=>"https://db-benchmarks.sts-sio-caen.info",
		"database"=>[
				"type"=>"mysql",
				"dbName"=>"",
				"serverName"=>"127.0.0.1",
				"port"=>"3306",
				"user"=>"root",
				"password"=>"",
				"options"=>[],
				"cache"=>false
		],
		"sessionName"=>"php-db-benchmark",
		"namespaces"=>[],
		"templateEngine"=>'Ubiquity\\views\\engine\\Twig',
		"templateEngineOptions"=>array("cache"=>false),
		"test"=>false,
		"debug"=>false,
		"logger"=>function(){return new \Ubiquity\log\libraries\UMonolog("php-orm-benchmark-2",\Monolog\Logger::INFO);},
		"di"=>[
			"@exec"=>array("jquery"=>function ($controller){
				return \Ubiquity\core\Framework::diSemantic($controller);
			})
		],
		"cache"=>["directory"=>"cache/","system"=>"Ubiquity\\cache\\system\\ArrayCache","params"=>[]],
		"mvcNS"=>["models"=>"models","controllers"=>"controllers","rest"=>""]
);
