<?php

    class clsItemDefinitions{
        use trtBasic;
        public $var=array();
        public $cls=array();
        private $alias=array();
        private $alias_pipe=array();
        function __construct(){
			
			
		}

        public function retrieve_menu_items($type_code,$item_code){
            $return_array=array();
            $return_array=$this->$type_code."_".$item_code();
            //print_r($return_array);
        }

        private function set_token_codes() {
            $alias[0][0]="alias_expression_types";
            $alias[0][1]="alias_properties";
            $alias[0][2]="alias_property_recursion";
            $alias[0][3]="alias_commands";
            $alias[0][4]="alias_variables";
            $alias[0][5]="alias_operators";
            $alias[0][6]="alias_variable_types";
            $alias[0][7]="alias_dimension_definitions";

            $alias[$alias[0][1]][0]="base_type";
			$alias[$alias[0][1]][1]="item_type"; // "display_mode" / "type_code"
            $alias[$alias[0][1]][2]="item_title";
            $alias[$alias[0][1]][3]="item_execute";
            $alias[$alias[0][1]][4]="item_code";
			$alias[$alias[0][1]][5]="display_mode";// after: "input" | "variable" | "multiple"
			$alias[$alias[0][1]][6]="type_code";
			$alias[$alias[0][1]][7]="Code";
			$alias[$alias[0][1]][8]="run_type_vars";
			$alias[$alias[0][1]][9]="main";
			$alias[$alias[0][1]][10]="parent_code";
            $alias[$alias[0][1]][11]="command";
            $alias[$alias[0][1]][12]="variables";
            $alias[$alias[0][1]][13]="Step";
            $alias[$alias[0][1]][14]="description";
            $alias[$alias[0][1]][15]="current_executing_line_number";
            $alias[$alias[0][1]][16]="length";
            $alias[$alias[0][1]][17]="Menu_Item_Number";

            $alias[$alias[0][2]][0][0]=1;
            $alias[$alias[0][2]][1][0]=2;
            $alias[$alias[0][2]][2][0]=3;
            $alias[$alias[0][2]][3][0]=4;
            $alias[$alias[0][2]][4][1]=5;
            $alias[$alias[0][2]][5][1]=6;
            $alias[$alias[0][2]][6][2]=13;
            $alias[$alias[0][2]][7][2]=14;
            $alias[$alias[0][2]][8][2]=17;
            $alias[$alias[0][2]][9][3]=11;
            $alias[$alias[0][2]][20][3]=12;

			$alias[$alias_commands][1]="alias";
            $alias[$alias_commands][2]="return";
            $alias[$alias_commands][3]="variable"; // "multiple"
            $alias[$alias_commands][4]="next_command";
            $alias[$alias_commands][5]="start_commands";
            $alias[$alias_commands][6]="sub_commands";
            $alias[$alias_commands][7]="previous_command_level";
            $alias[$alias_commands][8]="end";
            $alias[$alias_commands][9]="if";
            $alias[$alias_commands][10]="then";
            $alias[$alias_commands][11]="else";
            $alias[$alias_commands][12]="equate";
            $alias[$alias_commands][13]="input";
            $alias[$alias_commands][14]="multiple";
            $alias[$alias_commands][15]="end";
            $alias[$alias_commands][16]="target"; // "line_number" | "input" | 
            $alias[$alias_commands][17]="set";
            $alias[$alias_commands][18]="name";
            $alias[$alias_commands][19]="line_number";
            $alias[$alias_commands][20]="self";
            

            $alias[$alias_variables][1]="new var"; // "set" | "name" | "set" | 
            $alias[$alias_variables][2]="new counter";
            
            $alias[$alias_operators][1]="==";
            $alias[$alias_operators][2]=">=";
            $alias[$alias_operators][3]="<=";
            $alias[$alias_operators][4]="!=";

            $alias[$alias_operators][5]="++";
            $alias[$alias_operators][6]="--";
            $alias[$alias_operators][7]="*=";

            $alias[$alias_variable_types][5]="integer";
            $alias[$alias_variable_types][6]="string";
            $alias[$alias_variable_types][7]="decimal";

            $alias[$alias[0][7]][0]="self_alias_expression_types";
            $alias[$alias[0][7]][1]="alias_expression_types";
            $alias[$alias[0][7]]["="]="alias expression descriptions";
            $alias[$alias[0][1]][0]="alias_expression_types";
            $alias[$alias[0][1]][1]="alias_item_numbers";
            $alias[$alias[0][1]]["="]="alias item descriptions";
            $alias[$alias[0][2]][0]="alias_expression_types";
            $alias[$alias[0][2]][1]="alias_item_numbers";
            $alias[$alias[0][2]][2]="alias_properties_item_target_numbers";
            $alias[$alias[0][2]]["="]="alias_properties_item_numbers";

            $alias_commands=0;
            $alias_properties=1;
            $alias_variables=2;
            $alias_operators=3;
            $alias_variable_types=4;

            $this->alias[0]=$alias;

            $this->alias[1]=$alias;
		}

        private function set_alias(){
            $this->alias_pipe["execute_method"][0]=18;//"start_commands";
            $this->alias_pipe["execute_method"][1]=19;//"sub_commands";
            $this->alias_pipe["execute_method"][1]=19;//"set";
            $this->alias_pipe["execute_method"][1]=16;//"variable";
            $this->alias_pipe["execute_method"][1]=16;//"name";
            $this->alias_pipe["execute_method"][1]=16;//"assign";
            $this->alias_pipe["execute_method"][1]=16;//"assign";
            
            $this->alias_pipe["execute_method"][1]=16;//"variable";
            $this->alias_pipe["execute_method"][1]=19;//"return";
            $this->alias_pipe["execute_method"][2]=1; //"display_mode";
            $this->alias_pipe["execute_method"][3]=16;//"input_variable";
            $this->alias_pipe["execute_method"][3]=27;//"input_multiple";
            $this->alias_pipe["execute_method"][4]=3;//"item_title";
            $this->alias_pipe["execute_method"][5]=2;//"type_code"
            $this->alias_pipe["execute_method"][6]=7;//"item_code"
            $this->alias_pipe["execute_method"][7]=28;//"end_input"
            $this->alias_pipe["execute_method"][8]=29;//"target_line"
            $this->alias_pipe["execute_method"][9]=26;//"target_line"
            $this->alias_pipe[]=array(1,2,3);
        }
        
        private function main_menu_menu_group_heading(){
            $alias[0]="display_mode";
            $alias[1]="show_main_heading";
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Main Menu","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"main_menu","self"=>array("item_code"=>"main_menu")),"parent_code"=>"main_menu");
			return $items;
        }

        private function main_menu_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>1,"Description"=>"Install Wizard","alias"=>array("Step"=>"Order")),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"install_wizard")),"item_code"=>array("main"=>"main_menu","self"=>"install_wizard"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>2,"Description"=>"Website Helper Setup"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"server_manager")),"item_code"=>array("main"=>"main_menu","self"=>"Website_Helper_Setup"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>3,"Description"=>"Check Updates For Website Helper"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"updates_manager")),"item_code"=>array("main"=>"main_menu","self"=>"Updates_Website_Helper"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>4,"Description"=>"Execute Service Daemons"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"daemons_manager")),"item_code"=>array("main"=>"main_menu","self"=>"Service_Daemons"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>5,"Description"=>"Install LAMP Server"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"lamp_install")),"item_code"=>array("main"=>"main_menu","self"=>"Install_LAMP"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>6,"Description"=>"Install Extensions & Packages & Applications"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"packages_manager")),"item_code"=>array("main"=>"main_menu","self"=>"install_extensions"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>7,"Description"=>"Website Helper Configuration"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"website_helper_setup")),"item_code"=>array("main"=>"main_menu","self"=>"website_helper_configuration"));
            return $items;
        }

        private function install_wizard_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Install Wizard","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"install_wizard","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			return $items;
        }

        private function install_wizard_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>1,"Description"=>"Detect Server","alias"=>array("Step"=>"Order")),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"detect_server"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>2,"Description"=>"Download Website Helper"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"download_website_helper"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>3,"Description"=>"Install Package Managers"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"package_managers"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>4,"Description"=>"Install Programming Languages"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"programming_languages"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>5,"Description"=>"Install Database Engines"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"databases"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>6,"Description"=>"Install Web Servers"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"web_server"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>7,"Description"=>"Install Browser Plugins"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"browser_plugins"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>8,"Description"=>"Install Backup Applications"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"backup_apps"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>9,"Description"=>"Install Online File Storage Applications"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"online_storage"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>10,"Description"=>"Install Security Applications"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"security_apps"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>11,"Description"=>"Install Utilized Packages"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"utilized_packages"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>12,"Description"=>"Install Usefull Applications"),"iitem_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"usefull_apps"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>13,"Description"=>"Install Code Libraries"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"code_library"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Step"=>14,"Description"=>"Install Local Windows File Library Organizers"),"item_execute"=>array("command"=>"ge","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"install_wizard","self"=>"file_organizer"));
			return $items;
        }

        private function server_manager_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Server Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"server_manager","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			return $items;
        }
        
        private function server_manager_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"Server Type"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"server_manager","self"=>"detect_server"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>2,"Description"=>"Server Details"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"server_manager","self"=>"download_website_helper"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>3,"Description"=>"Show Colours"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsAnsi','method'=>'show_colours')),"item_code"=>array("main"=>"server_manager","self"=>"package_managers"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>4,"Description"=>"Show Characters"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsAnsi','method'=>'show_characters')),"item_code"=>array("main"=>"server_manager","self"=>"programming_languages"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>5,"Description"=>"Show ANSI Characters"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsAnsi','method'=>'ansi_example')),"item_code"=>array("main"=>"server_manager","self"=>"databases"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>6,"Description"=>"PHPInfo"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsServerDetails','method'=>'get_phpinfo')),"item_code"=>array("main"=>"server_manager","self"=>"web_server"));
			return $items;
        }

        private function updates_manager_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Updates Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"updates_manager","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			return $items;
        }
        
        private function updates_manager_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"Check For Updates"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"updates_manager","self"=>"Check_For_Updates"));
			return $items;
        }

        private function daemons_manager_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Daemons Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"daemons_manager","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			return $items;
        }
        
        private function daemons_manager_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"Telnet BBS"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"daemons_manager","self"=>"Telnet_BBS"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>5,"Description"=>"PHP Web Server"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsAnsi','method'=>'ansi_example')),"item_code"=>array("main"=>"daemons_manager","self"=>"PHP_Web_Server"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>6,"Description"=>"PHP Worker Daemon"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsServerDetails','method'=>'get_phpinfo')),"item_code"=>array("main"=>"daemons_manager","self"=>"PHP_Worker_Daemon"));
			return $items;
        }

        private function applications_manager_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Applications Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"applications_manager","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			return $items;
        }
        
        private function applications_manager_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"List Applications"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"applications_manager","self"=>"List_Applications"));
			return $items;
        }

        private function lamp_install_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Lamp Install Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"lamp_install","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			return $items;
        }
        
        private function lamp_install_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"Install Lamp Server"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"lamp_install","self"=>"Telnet_BBS"));
            return $items;
        }
			
        private function packages_manager_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Daemons Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"packages_manager","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			return $items;
        }
        
        private function packages_manager_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"Composer"),"item_execute"=>array("command"=>"ge","variables"=>array()),"item_code"=>array("main"=>"packages_manager","self"=>"Telnet_BBS"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>5,"Description"=>"PHP Pear"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsAnsi','method'=>'ansi_example')),"item_code"=>array("main"=>"packages_manager","self"=>"PHP_Web_Server"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>6,"Description"=>"PHP Pecl"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsServerDetails','method'=>'get_phpinfo')),"item_code"=>array("main"=>"packages_manager","self"=>"PHP_Worker_Daemon"));
			return $items;
        }
			
		private function website_helper_setup_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Website Helper Setup Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"website_helper_setup","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			return $items;
        }
        
        private function website_helper_setup_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"File System"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"file_manager")),"item_code"=>array("main"=>"website_helper_setup","self"=>"detect_server"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>2,"Description"=>"SQL Database"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"db_manager")),"item_code"=>array("main"=>"website_helper_setup","self"=>"download_website_helper"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>3,"Description"=>"PHP Classes"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"class_manager")),"item_code"=>array("main"=>"website_helper_setup","self"=>"package_managers"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>4,"Description"=>"Phar Creation"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"phar_manager")),"item_code"=>array("main"=>"website_helper_setup","self"=>"programming_languages"));
			return $items;
        }
					
		private function file_manager_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"File Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"file_manager","self"=>array("item_code"=>"main")),"parent_code"=>"main_menu");
			return $items;
        }
        
        private function file_manager_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"List All Directories"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsFileInteraction','method'=>'show_website_helper_directories')),"item_code"=>array("main"=>"file_manager","self"=>"List_All_Directories"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>2,"Description"=>"List All Files"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsFileInteraction','method'=>'show_website_helper_files')),"item_code"=>array("main"=>"file_manager","self"=>"List_All_Files"));
			return $items;
        }

        private function db_manager_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"SQL Database Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"db_manager","self"=>array("item_code"=>"main")),"parent_code"=>"website_helper_setup");
			return $items;
        }
        
        private function db_manager_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"List All SQL Tables"),"item_execute"=>array("command"=>"edm","variables"=>array('method'=>'Retrieve_all_tables')),"item_code"=>array("main"=>"db_manager","self"=>"List_All_Directories"));
			$items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>2,"Description"=>"Return SQL Table Info"),"item_execute"=>array("command"=>"gm","variables"=>array("target_menu"=>"db_return_table")),"item_code"=>array("main"=>"db_manager","self"=>"List_All_Files"));
			return $items;
        }

        private function class_manager_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"PHP Class Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"class_manager","self"=>array("item_code"=>"main")),"parent_code"=>"website_helper_setup");
			return $items;
        }
        
        private function class_manager_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"List All PHP Classes"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsReflection','method'=>'show_all_classes')),"item_code"=>array("main"=>"class_manager","self"=>"List_All_Classes"));
			return $items;
        }

        private function phar_manager_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Phar File Manager","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"phar_manager","self"=>array("item_code"=>"main")),"parent_code"=>"website_helper_setup");
			return $items;
        }
        
        private function phar_manager_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"Create PHAR File"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsReflection','method'=>'show_all_classes')),"item_code"=>array("main"=>"phar_manager","self"=>"Create_PHAR_File"));
			return $items;
        }

        private function db_return_table_menu_group_heading(){
            $items[]=array("item_type"=>array("display_mode"=>"show_main_heading","type_code"=>"menu_group_heading"),"item_title"=>"Return SQL Table Info","item_type"=>array("Code"=>"mt","run_type_vars"=>array()),"item_code"=>array("main"=>"db_return_table","self"=>array("item_code"=>"main")),"parent_code"=>"website_helper_setup");
			return $items;
        }
        
        private function db_return_table_menu_group_item(){
            $items[]=array("item_type"=>array("display_mode"=>"show_menu_item","type_code"=>"menu_group_item"),"item_title"=>array("Menu_Item_Number"=>1,"Description"=>"Return SQL Table Info"),"item_execute"=>array("command"=>"ecm","variables"=>array('class'=>'clsReflection','method'=>'show_all_classes')),"item_code"=>array("main"=>"db_return_table","self"=>"SQL_Table_Info"));
			return $items;
        }
			
			
			
						

			
}

