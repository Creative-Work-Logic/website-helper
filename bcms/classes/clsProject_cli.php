<?php
	class clsProject_cli {
		//use trtBasic;
		private $menu_request_input=array();
		private $menu_function=array();
		private $menu_array=array();
		private $menu_items=array();
		private $user_inputs=array();
		private $user_input_variables=array();
		private $current_user_input_variable=0;
		private $all_menu_items=array();
		private $initialSize=array();
		private $current_menu_level=0;
		private $current_menu_item=0;
		private $previous_menus_level=array();

		
		function __construct(){
			echo"xxx";
			//$this->set_menu();
			//$this->set_menu_functions();
			$this->get_current_menu_title();
		}

		

			public function runProcess($command)
			{
				$descriptors = [
					0 => ["pipe", "r"],  // STDIN
					1 => ["pipe", "w"],  // STDOUT
					2 => ["pipe", "w"],  // STDERR
				];

				$process = proc_open($command, $descriptors, $pipes);

				if (is_resource($process)) {
					stream_set_blocking($pipes[1], false); // Non-blocking for output
					stream_set_blocking($pipes[2], false); // Non-blocking for errors

					while (true) {
						$stdout = stream_get_contents($pipes[1]);
						$stderr = stream_get_contents($pipes[2]);

						if (!empty($stdout)) {
							echo "STDOUT: $stdout";
						}

						if (!empty($stderr)) {
							echo "STDERR: $stderr";
						}

						$status = proc_get_status($process);
						if (!$status['running']) {
							break;
						}

						usleep(100000); // Small delay to avoid CPU hogging
					}

					fclose($pipes[0]);
					fclose($pipes[1]);
					fclose($pipes[2]);
					proc_close($process);

					echo "Process completed.\n";
				}
			}

			
			public function execute_test_command(){	
				//$command='ping -c 3 google.com';
				$command='sudo apt upgrade';
				$this->runProcess($command); // Example command
			}

		public function execute_local_methods($variables=array()){
			/*
            "is_cli"
			"clearScreen"
			"getWindowsTerminalSize"
			"getTerminalSize"
			"moveCursor"
			"set_input_options"
			"set_menu_functions"
			"set_token_codes"
			"create_menu"
			"set_menu"
			"get_current_menu"
			"get_current_menu_title"
			"showMenu"
			"show_input_Menu"
			"show_standard_Menu"
			"set_terminal_details"
			"run_standard_choice"
			"run_user_inputs"
			"push_user_inputs"
			"capture_user_inputs"
			"repeat_cycle"
			"show_read_Menu"
			"execute_variable_structure"
			*/
			$this->clearScreen();
			if(isset($variables[0])){
				$target_method =$variables[0];
			}elseif(isset($variables["method"])){
				$target_method =$variables["method"];
			}
			//$target_method =$variables[0];//'moveCursor';
			$method_parameters =array();
			$method_parameter_matched =array();
			$refl = new ReflectionClass($this);

			$parameters = $refl->getMethod($target_method)->getParameters();
			//
			foreach($parameters as $key=>$val){
				$method_parameters[]=$val->name;
			}
			//print_r($method_parameters);
			for($x=0;$x<count($method_parameters);$x++){
				$method_parameter_matched[$method_parameters[$x]]=$variables[$x];
			}
			$row_count=0;
			$match_key="";
			foreach($variables as $key=>$val){
				if($row_count==0){
					$target_method=$val;
				}else{
					if(isset($method_parameters[$row_count-1])){
						$target_parameters=$method_parameters[$row_count-1];
					}
					if($target_parameters==$key){
						$match_key=$key;
					}else{
						$match_key=$target_parameters;
					}
					$method_parameter_matched[$match_key]=$val;
				}
				$row_count++;
			}
			call_user_func_array(array($this, $target_method),$method_parameter_matched);
			//echo"I AM Legend\n";
			//print_r($method_parameter_matched);
			//echo"Hello World";
        }
		
		public function is_cli(){
			return (php_sapi_name() === 'cli' || defined('STDIN')) &&
			empty($_SERVER['REMOTE_ADDR']) &&
			empty($_SERVER['HTTP_USER_AGENT']) &&
			count($_SERVER['argv']) > 0;
		}
		
		public function clearScreen() {
			echo "\033[2J\033[;H";
			/*
			if (PHP_OS_FAMILY === 'Windows') {
				system('cls');
			} else {
				system('clear');
			}
			*/
		}

		public function getWindowsTerminalSize() {
			$output = [];
			exec('mode', $output);
		
			$cols = null;
			$rows = null;
		
			// Parse the output from the 'mode' command to find rows and columns
			foreach ($output as $line) {
				if (preg_match('/Columns:\s+(\d+)/', $line, $matches)) {
					$cols = $matches[1];
				}
				if (preg_match('/Lines:\s+(\d+)/', $line, $matches)) {
					$rows = $matches[1];
				}
			}
		
			// Return an array with rows and columns
			return ['rows' => $rows, 'cols' => $cols];
		}

		public function getTerminalSize() {
			// Use stty to capture terminal size (works on Unix/Linux/Mac)
			$size = exec('stty size');
			list($rows, $cols) = explode(" ", $size);
		
			return ['rows' => $rows, 'cols' => $cols];
		}

		public function moveCursor($row, $col) {
			echo "\033[" . $row . ";" . $col . "H";
		}

		public function set_input_options() {
			$this->menu_request_input["standard_menu_input"]="Please choose an option: ";
			$this->menu_request_input["enter_table_input"]="Please enter table name: ";
			
		}

		

		
		
		public function goto_menu($menu_number){
			//$menu_level=$this->menu_array[$this->current_menu_level][$menu_number[2]];
			//print var_export($this->menu_items[$this->current_menu_level],true);
			//$menu_level=$this->menu_items[$this->current_menu_level][$menu_number];
			//print var_export($menu_number[2],true);
			
			$this->current_menu_level=$menu_number[2];
			//exit($this->current_menu_level);
			$this->show_read_Menu();
		}

		public function goto_menu_read($menu_number){
			//$menu_level=$this->menu_array[$this->current_menu_level][$menu_number[2]];
			//print var_export($this->menu_items[$this->current_menu_level],true);
			//$menu_level=$this->menu_items[$this->current_menu_level][$menu_number];
			//print var_export($menu_number[2],true);
			
			$this->current_menu_level=$menu_number[2];
			//exit($this->current_menu_level);
			$this->show_read_Menu();
		}

		public function goto_echo($menu_number){
			$menu_title=$this->menu_array[$this->current_menu_level][$menu_number][0];
			print $menu_title;
		}
		/*
		public function back_menu($menu_number){
			$prev_menu_number=$this->menu_array[$this->current_menu_level][$menu_number][2];
			$this->current_menu_level=$prev_menu_number;
			$this->show_read_Menu();
		}
		*/
		public function execute($menu_number){
			$this->clearScreen();
			$execute_command=$this->menu_array[$this->current_menu_level][$menu_number][2];
			//print $execute_command;
			eval($execute_command);
			
		}

		public function get_input($menu_number){
			$this->clearScreen();
			$execute_command=$this->menu_array[$this->current_menu_level][$menu_number][2];
			//print $execute_command;
			eval($execute_command);
			
		}

		//public function execute_class_method($class="",$method="",$method_input_variables=array()){
		public function execute_class_method($variables=array()){
			print var_export($variables,true);
			$class=$variables[2];
			$method=$variables[3];
			if(is_array($variables[4])){
				$method_input_variables=$variables[4];
			}else{
				$method_input_variables=array();
			}
			

			$return_array=$this->cls->$class->$method($method_input_variables);
			//exit();
			
			//$this->show_read_Menu();
			//$this->clearScreen();
			if(is_array($return_array)){
				$this->show_array($return_array);
			}
			
			return $return_array;
		}

		//public function execute_database_method($method="",$method_input_variables=array()){
		public function execute_database_method($variables=array()){
			$this->clearScreen();
			//print var_export($variables,true);
			//$class=$variables[2];
			$method=$variables[2];
			if(is_array($variables[4])){
				$method_input_variables=$variables[4];
			}else{
				$method_input_variables=array();
			}
			$return_array=$this->db->$method($method_input_variables);
			//print_r($return_array);
			if(is_array($return_array)){
				$this->show_array($return_array);
			}
			return $return_array;
		}

		public function execute_command($command="",$command_variables=array()){
			$this->clearScreen();
			$return_array=array();//$this->db->$method($method_input_variables);
			return $return_array;
		}

		public function execute_local_class_method($variables=array()){
			$this->clearScreen();
			$method=$variables[0];
			//if(is_array($method_input_variables[1])){
				$method_input_variables=$variables[0];
			//}else{
			//	$method_input_variables=array();
			//}
			
			$return_array=$this->$method($method_input_variables);
			return $return_array;
		}

		public function show_array($list_array=array()){
            foreach($list_array as $key=>$val){
				if(is_array($val)){
					print("\n".$val[0]);
				}else{
					print("\n".$val);
				}
				
                //print "\n".$val;
            }
        }

		
		private function set_menu_functions() {
			$this->menu_function["mt"]="menu_title";
			$this->menu_function["gm"]="goto_menu";
			$this->menu_function["ge"]="goto_echo";
			$this->menu_function["edm"]="execute_database_method";
			$this->menu_function["ecm"]="execute_class_method";
			$this->menu_function["elc"]="execute_local_class_method";
		}

		
		
		private function set_all_menu_items(){

			$menu_item=array();
			/*
			$menu_input_variables=array("menu_code"=>"main_menu","parent_code"=>"main_menu","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Main Menu","mt",$menu_input_variables);
			$menu_item[$mc][]=array("Install Wizard","gm","install_wizard");
			$menu_item[$mc][]=array("Website Helper Setup","gm","server_manager");
			$menu_item[$mc][]=array("Check Updates For Website Helper","gm","updates_manager");
			$menu_item[$mc][]=array("Execute Service Daemons","gm","daemons_manager");
			$menu_item[$mc][]=array("Install LAMP Server","gm","lamp_install");
			$menu_item[$mc][]=array("Install Extensions & Packages & Applications","gm","packages_manager");
			$menu_item[$mc][]=array("Website Helper Configuration","gm","website_helper_setup");

			$items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Main Menu","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"main_menu","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>1,"Description"=>"Install Wizard","alias"=>array("Step"=>"Order")),"item_execute"=>array("command"=>"gm","variables"=>array()),"item_code"=>array("main"=>"main_menu","self"=>"install_wizard"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>2,"Description"=>"Website Helper Setup"),"item_execute"=>array("command"=>"gm","variables"=>array()),"item_code"=>array("main"=>"main_menu","self"=>"Website_Helper_Setup"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>3,"Description"=>"Check Updates For Website Helper"),"item_execute"=>array("command"=>"gm","variables"=>array()),"item_code"=>array("main"=>"main_menu","self"=>"Updates_Website_Helper"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>4,"Description"=>"Execute Service Daemons"),"item_execute"=>array("command"=>"gm","variables"=>array()),"item_code"=>array("main"=>"main_menu","self"=>"Service_Daemons"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>4,"Description"=>"Install LAMP Server"),"item_execute"=>array("command"=>"gm","variables"=>array()),"item_code"=>array("main"=>"main_menu","self"=>"Install_LAMP"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>4,"Description"=>"Install Extensions & Packages & Applications"),"item_execute"=>array("command"=>"gm","variables"=>array()),"item_code"=>array("main"=>"main_menu","self"=>"install_extensions"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>4,"Description"=>"Website Helper Configuration"),"item_execute"=>array("command"=>"gm","variables"=>array()),"item_code"=>array("main"=>"main_menu","self"=>"website_helper_configuration"));
			
						
			$items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Install Wizard","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>1,"Description"=>"Detect Server","alias"=>array("Step"=>"Order")),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"detect_server"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>2,"Description"=>"Download Website Helper"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"download_website_helper"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>3,"Description"=>"Install Package Managers"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"package_managers"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>4,"Description"=>"Install Programming Languages)","item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"programming_languages"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>5,"Description"=>"Install Database Engines"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"databases"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>6,"Description"=>"Install Web Servers"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"web_server"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>7,"Description"=>"Install Browser Plugins"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"browser_plugins"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>8,"Description"=>"Install Backup Applications"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"backup_apps"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>9,"Description"=>"Install Online File Storage Applications"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"online_storage"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>10,"Description"=>"Install Security Applications"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"security_apps"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>11,"Description"=>"Install Utilized Packages"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"utilized_packages"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>12,"Description"=>"Install Usefull Applications"),"iitem_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"usefull_apps"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>13,"Description"=>"Install Code Libraries"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"code_library"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>14,"Description"=>"Install Local Windows File Library Organizers"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>"file_organizer"));
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Install Wizard",$menu_input_variables);
			
			$menu_item[$mc][]=array("Step 1: Detect Server",$menu_input_variables);
			
			$menu_item[$mc][]=array("Step 2: Download Website Helper",$menu_input_variables);
			
			$menu_item[$mc][]=array("Step 3: Install Package Managers"$menu_input_variables);
			
			$menu_item[$mc][]=array("Step 4: Install Programming Languages",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"databases");
			$menu_item[$mc][]=array("Step 5: Install Database Engines",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"web_server");
			$menu_item[$mc][]=array("Step 6: Install Web Servers",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"browser_plugins");
			$menu_item[$mc][]=array("Step 7: Install Browser Plugins",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"backup_apps");
			$menu_item[$mc][]=array("Step 8: Install Backup Applications",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"online_storage");
			$menu_item[$mc][]=array("Step 9: Install Online File Storage Applications",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"security_apps");
			$menu_item[$mc][]=array("Step 10: Install Security Applications",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"utilized_packages");
			$menu_item[$mc][]=array("Step 11: Install Utilized Packages",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"usefull_apps");
			$menu_item[$mc][]=array("Step 12: Install Usefull Applications",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"code_library");
			$menu_item[$mc][]=array("Step 13: Install Code Libraries",$menu_input_variables);
			$menu_input_variables=array("item_type"=>"ge","menu_code"=>"file_organizer");
			$menu_item[$mc][]=array("Step 14: Install Local Windows File Library Organizers",$menu_input_variables);
			

			
			$menu_input_variables=array("menu_code"=>"server_manager","parent_code"=>"main_menu","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Server Manager","mt");
			$menu_item[$mc][]=array("Server Type","ge",1);
			$menu_item[$mc][]=array("Server Details","ge",1);
			$menu_item[$mc][]=array("Show Colours","ecm",'clsAnsi','show_colours','');
			$menu_item[$mc][]=array("Show Characters","ecm",'clsAnsi','show_characters','');
			$menu_item[$mc][]=array("Show ANSI Characters","ecm",'clsAnsi','ansi_example','');
			$menu_item[$mc][]=array("PHPInfo","execute","phpinfo();");
			

			
			$menu_input_variables=array("menu_code"=>"updates_manager","parent_code"=>"main_menu","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Updates Manager","mt");
			$menu_item[$mc][]=array("Check For Updates","execute","echo 'Show Updates';");
			$end=count($menu_item)-1;
			$menu_input_variables["end"]=$end;

			
			$menu_input_variables=array("menu_code"=>"daemons_manager","parent_code"=>"main_menu","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Daemons Manager","mt");
			$menu_item[$mc][]=array("Telnet BBS","execute","echo 'Starting BBS';");
			$menu_item[$mc][]=array("PHP Web Server","execute","echo 'Starting Web Server';");
			$menu_item[$mc][]=array("PHP Worker Daemon","execute","echo 'Starting Worker Daemon';");
			

			
			$menu_input_variables=array("menu_code"=>"applications_manager","parent_code"=>"main_menu","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Applications Manager","mt");
			$menu_item[$mc][]=array("List Applications","execute","echo 'Show Applications';");
			

			
			$menu_input_variables=array("menu_code"=>"lamp_install","parent_code"=>"main_menu","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Lamp Install Manager","mt");
			$menu_item[$mc][]=array("Install Lamp Server","execute","echo 'Show Install Lamp';");
			
			
			
			$menu_input_variables=array("menu_code"=>"packages_manager","parent_code"=>"main_menu","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Packages Manager","mt");
			$menu_item[$mc][]=array("Composer","execute","echo 'Show Composer';");
			$menu_item[$mc][]=array("PHP Pear","execute","echo 'Show Pear';");
			$menu_item[$mc][]=array("PHP Pecl","execute","echo 'Show Pecl';");
			
			
			
			$menu_input_variables=array("menu_code"=>"website_helper_setup","parent_code"=>"main_menu","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Website Helper Setup Manager","mt");
			$menu_item[$mc][]=array("File System","gm",9);
			$menu_item[$mc][]=array("SQL Database","gm",10);
			$menu_item[$mc][]=array("PHP Classes","gm",11);
			$menu_item[$mc][]=array("Phar Creation","gm",12);
			

			
			$menu_input_variables=array("menu_code"=>"file_manager","parent_code"=>"website_helper_setup","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("File Manager","mt");
			//$menu_item[]=array("List All Directories","execute",'$return=$this->cls->clsFileInteraction->show_directory();$this->show_array($return);');
			//$menu_item[]=array("List All Files","execute",'$return=$this->cls->clsFileInteraction->show_files();$this->show_array($return);');

			$menu_item[$mc][]=array("List All Directories","ecm",'clsFileInteraction','show_website_helper_directories','');
			$menu_item[$mc][]=array("List All Files","ecm",'clsFileInteraction','show_website_helper_files','');
				
			
			$menu_input_variables=array("menu_code"=>"db_manager","parent_code"=>"website_helper_setup","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[]=array("SQL Database Manager","mt",$menu_input_variables);
			//$menu_item[]=array("List All SQL Tables","execute",'$return=$this->db->Retrieve_all_tables();$this->show_array($return);');
			$menu_input_variables=array("menu_target"=>'Retrieve_all_tables');
			$menu_item[$mc][]=array("List All SQL Tables","edm",$menu_input_variables);
			$menu_item[$mc][]=array("Return SQL Table Info","gm",$menu_input_variables,13);
						
			$menu_input_variables=array("menu_code"=>"class_manager","parent_code"=>"website_helper_setup","run_standard_input");
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("PHP Class Manager","mt",$menu_input_variables);
			//$menu_item[]=array("List All PHP Classes","execute",'$return=$this->cls->clsFileInteraction->show_class_files();$this->show_all_classes($return);');
			
			$menu_item[$mc][]=array("List All PHP Classes","ecm",'clsReflection','show_all_classes','');
			
			
			
			$menu_input_variables=array("menu_code"=>"phar_manager","parent_code"=>"website_helper_setup","run_standard_input","input_variables"=>$text_input_types);
			$mc=$menu_input_variables["menu_code"];
			$menu_item[$mc][]=array("Phar File Manager","mt",$menu_input_variables);
			$menu_item[$mc][]=array("Create PHAR File","ecm",'clsPhar','create_phar_file','');
						
			
			$menu_input_variables=array("menu_code"=>"db_return_table","input_type"=>"run_user_input","input_variables"=>array());
			$mc=$menu_input_variables["menu_code"];
			$menu_input_variables["input_variables"]=array("table_name");
			$menu_item[$mc][]=array("Return SQL Table Info","mt",$menu_input_variables);
			
			
			$return_array=array("Items"=>$menu_item,"Item_Ranges"=>array("Start"=>$start,"End"=>$end),"Item_IDs"=>array("MenuID"=>$menuID,"ParentID"=>$parentID));
			$this->all_menu_items=$return_array;
			*/
			//return $return_array;	
		}
			

			
		public function create_menu(){
			
			$menu_items=array();
			/*
			$items_array=$this->set_all_menu_items();
			$items=$items_array["Items"];
			$item_ranges=$items_array["Item_Ranges"];
			$item_ranges_start=$item_ranges["Start"];
			$item_ranges_end=$item_ranges["End"];
			$item_ids=$items_array["Item_IDs"];
			$menu_ids=$item_ids["MenuID"];
			$parent_ids=$item_ids["ParentID"];

			$current_item_pointer=0;
			/*
			for($item_group=0;$item_group<=count($item_ranges_start);$item_group++){
				//for($item_number=$item_ranges_start[$item_group];$item_number<=$item_ranges_end[$item_group];$item_number++){
				for($item_number=0;$item_number<=($item_ranges_end[$item_group]-$item_ranges_start[$item_group]);$item_number++){
					$menu_items[$item_group][$item_number]=$items[$current_item_pointer];
					$current_item_pointer++;
				}
			}
			
			*/
			$this->menu_items=$menu_items;
			
			return $this->menu_items;
		}
			
		
		public function set_menu(){
			if(!isset($this->menu_items[$this->current_menu_level])){
				$this->menu_items=$this->create_menu();
			}else{
				if(count($this->menu_items[$this->current_menu_level])==0){
					$this->menu_items=$this->create_menu();
				}
			}
			return $this->menu_items;
		}

		public function get_current_menu(){
			$menu_item_number=0;
			$menu_item_count=1;
			if(isset($this->menu_items[$this->current_menu_level])){
				for($menu_item_number=0;$menu_item_number<count($this->menu_items[$this->current_menu_level]);$menu_item_number++){
					$current_menu_item=$this->menu_items[$this->current_menu_level][$menu_item_number];
					//print_r($current_menu_item);
					$output.=$menu_item_count."-".$current_menu_item[0]."\n";//.". ".$item_command[1].". ".$item_command[2]." \n";
					$menu_item_count++;
				}
			}
			return $output;
		}
		
		public function get_current_menu_title(){
			$current_title="hello";//$this->menu_items[$this->current_menu_level][0][0];
			$output="====================================\n";
			$output.="  ".$current_title."\n";
			$output.="====================================\n";
			print $output;
			$user_inputs=trim(fgets(STDIN));
			print $user_inputs;
		}
		
		public function showMenu($menu_request="standard_menu_input"){
			$output="";
			/*
			$current_title=$this->menu_items[$this->current_menu_level][0][0];
			$output.="====================================\n";
			$output.="  ".$current_title."\n";
			$output.="====================================\n";
			$menu_item_number=0;
			//print_r($this->menu_items);
			*/
			//foreach($this->menu_items as $item_group=>$item_number){
			$output.=$this->get_current_menu_title();
			$output.=$this->get_current_menu();
			/*
			$menu_item_count=1;
			if(isset($this->menu_items[$this->current_menu_level])){
				for($menu_item_number=1;$menu_item_number<count($this->menu_items[$this->current_menu_level]);$menu_item_number++){
					$current_menu_item=$this->menu_items[$this->current_menu_level][$menu_item_number];
					//print_r($current_menu_item);
					$output.=$menu_item_count."-".$current_menu_item[0]."\n";//.". ".$item_command[1].". ".$item_command[2]." \n";
					$menu_item_count++;
				}
			}
			*/
			$output.=$this->menu_request_input[$menu_request];
			return $output;
		}
		
		public function show_input_Menu(){
			$output="";
			$this->clearScreen();
			$output=$this->showMenu("enter_table_input");
			return $output;
		}

		public function show_standard_Menu(){
			$output="";
			$this->clearScreen();
			$output=$this->showMenu();
			return $output;
		}

		public function set_terminal_details(){
			$output="";
			
			if(count($this->initialSize)>0){
				$newSize = $this->getWindowsTerminalSize();

				// Check if size changed
				if ($newSize['cols'] != $this->initialSize['cols']) {
					$output="Terminal resized to: {$newSize['cols']} columns, {$newSize['rows']} rows\n";
					$this->initialSize = $newSize;  // Update the initial size
				}
			}else{
				echo shell_exec('mode con: cols=120 lines=50');
				$this->initialSize = $this->getWindowsTerminalSize();
				$output="Initial Terminal Size: {$this->initialSize['cols']} columns, {$this->initialSize['rows']} rows\n";
			}
			
			return $output;
		}

		public function run_standard_choice($choice){
			$output="";
			$run_method=$this->menu_items[$this->current_menu_level][$choice][1];
			$method_variable_input=$this->menu_items[$this->current_menu_level][$choice];
			if(is_array($method_variable_input)){
				print "run=>".$run_method." choice=>".var_export($method_variable_input,true)." \n";
			}
			
			
			$this->$run_method($method_variable_input);
			//exit();
			echo "\n";
			print "run=>".$run_method." choice=>".$method_variable_input." \n";
			return $output;
		}

		public function run_user_inputs($variables=array()){
			$return_array=array();
			foreach($variables as $key=>$val){
				$return_array[$key]=$val;
			}
			return $return_array;
		}

		public function push_user_inputs($variables=array()){
			$return_array=array();
			foreach($variables as $key=>$val){
				$return_array[$key]=$val;
			}
			return $return_array;
		}

		public function capture_user_inputs($variables=array()){
			$return_value=true;
			$current_variable=$this->current_user_input_variable;
			if(isset($this->user_input_variables[$current_variable])){
				$this->user_inputs[$current_variable]=trim(fgets(STDIN));
				$return_value=false;
			}else{
				$this->push_user_inputs($this->user_inputs);
				$return_value=true;
			}
			return $return_value;
		}

		public function repeat_cycle($variables=array()){
			while (true) {
				//sleep(1);
				$this->set_terminal_details();
				$finished=$this->capture_user_inputs();
				
				if($finished){
					//$this->current_menu_level=
					//print_r($this->menu_items[$this->current_menu_level]);
					$this->run_standard_choice($choice);
					
					//$this->clearScreen();
					$this->showMenu();
				}else{
					if($choice=="x"){
						exit();
					}
					
				}
			}
		}
		
		public function show_read_Menu(){
			//$this->execute_local_methods(array("method"=>'moveCursor',"row"=>1,"col"=>2));
			//exit();
			//$this->showMenu();
			//$this->repeat_cycle();
			$this->get_current_menu_title();
		}
		
		public function execute_variable_structure($variables=array()){
			foreach($variables as $variable_key=>$variable_value){
				if(is_array($variable_value)){
					$this->execute_variable_structure($variable_value);
				}else{

				}
			}
		}

		
	}
	