<?php

    class clsProject_phar{
        use trtBasic;
        public $var=array();
        public $cls=array();
        function __construct(){
			
			
		}
		/*
		public function create_phar_file(){
			$phar = new Phar('..\includes\external\scripts\phar\website-helper.phar', 0, 'website-helper.phar');
        
			//$phar->setStub($phar->createDefaultStub('index.php'));

			// Include only the files you want
			$phar->buildFromDirectory('./');

			$phar->compressFiles(Phar::GZ); // Optional compression
			
		}
		*/
		public function create_phar_file(){
			$phar = new Phar('./website-helper.phar', 0, 'website-helper.phar');
	
			$phar->setStub($phar->createDefaultStub('index.php'));
	
			// Manually add files, specifying exact paths
			$phar->addFile('./index.php', 'index.php');
			$phar->addFile('./info.php', 'info.php');
			$phar->addFile('./main.php', 'main.php');
	
			// Optionally, include directories
			$phar->buildFromDirectory('./bcms/classes/', '/.*/');
			$phar->buildFromDirectory('./bcms/db/', '/.*/');
	
			$phar->compressFiles(Phar::GZ); // Optional compression
		}
	}

