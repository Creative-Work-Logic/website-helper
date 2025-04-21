<?php

    class clsSystem{
        use trtBasic;
        //private $sess;
        

        private $e;
        
       // public static $vars;

        private $bc;

        private $membersID;
        private $template_code="";

        private $content_output_html="";
        public $factory;

        public $project_type="full_install";

        public $output_code="";

        
        function __construct(){
            
            //echo "\n 666 \n";
            //$this->var=&clsClassFactory::$vrs;
            //$this->cls=&clsClassFactory::$cf_cls;
            
            $this->Initialize();
            
		}
        
        private function Initialize() {
            
            //$this->set_logs("system",6667,"clsSystem","Initialize");
            //exit("hello");
            //$this->Export_All_Vars();
            //$this->Run_Init_Functions();
            //
            
            $this->Run_Standard_Execution();
            $this->Output_HTML();
            
        }
        
        private function Run_Init_Functions() {
            $this->project_type=clsClassFactory::$project_type;
            
            //$this->Run_Init_Functions_Full_Server();
            switch($this->project_type){
                case "full_install":
                    $this->Run_Init_Functions_Full_Server();
                break;
                case "remote_install":
                    $this->Run_Init_Functions_Remote_Server();
                break;
                case "new_install":
                    $this->Run_Init_Functions_Install_Server();
                break;
                case "cli_run":
					$this->cls->clsCLI->show_read_Menu();
					
                break;
				
            }
            
            
            
            
        }

        private function Run_Init_Functions_Remote_Server() {
            /*
            if (isset($this->cls->clsDCMS)) {
                $this->output_code=$this->cls->clsDCMS->export_data();
            }else{
                echo "666";
                $this->output_code=$this->cls->export_data();
            }
            */
            if(!isset(clsClassFactory::$cf_cls->clsDCMS)){
                clsClassFactory::Add_Class("clsDCMS");
            }
            //$this->output_code=$this->cls->export_data();
            $this->output_code=$this->cls->clsDCMS->Return_Output($_SERVER['REQUEST_URI']);
            
        }
        private function Run_Standard_Execution() {
            //echo "\n 66678 \n";
            $this->Update_All_Vars();
            $this->log->set_logs("system_init",4567,"clsSystem","Run_Standard_Execution");
            //echo "456";
            $this->Update_All_Vars();
            //echo "76665";
            //$this->Export_All_Vars();
           //$this->as->Export_All_Class_Vars();
            //$this->as->Find_Current_Directory();
            
            $this->as->Set_Asset_Servers();
            //echo "766699";
            $this->as->Set_Base_Constants();
            //echo " \n12x \n";
            //$this->cls->clsError->SetErrorHandler();
            //print_r($this->sesh);
            //$this->sesh->Set_Session();
            
            $this->Set_Memebers();
            //echo " \n123x \n";
            $this->cls->clsDomain->Domain_Init();
            //clsClassFactory::$cf_cls->clsDomain->Domain_Init();
            //print_r(clsClassFactory::$cf_cls->clsDomain);
            //$this->cls->export_data();
            //print_r($this->var);
            //echo " \n1234x \n";
            $this->cls->clsContent->Content_Init();
            
            
            //echo " \n12345x \n";
            
            //$this->content_output_html=$this->cls->clsContent->Display_Total();
            $this->content_output_html=$this->cls->clsContent->Display();
            //echo " \n123456x \n";
            //print "gfd".$this->content_output_html;
            $this->cls->clsLanguage->Language_Init();
            
            $this->cls->clsTemplate->Template_Init();
            
            $this->cls->clsModules->Find_Module_View();
            
            $this->template_code=$this->cls->clsTemplate->Run_Template();
            $this->cls->clsSession->session_set_globals();
            //clsClassFactory::export_data();
            //clsClassFactory::$cf_cls->export_data();
            //print_r($this->var);
            //echo " \n1234567x \n";
            $this->log->show_messages();
            print $this->All_Outputs();
            //exit("ii");
            //$this->output_code=
        }

        private function Set_Session() {
            /*
            $handler = new clsSessionHandler();
            session_set_save_handler($handler, true);
            //session_save_path("bcms/sessions/"); // Set the path where session files will be stored
            session_start();
            */
            //$guid=$this->cls->$this->db->make_guid();
            //print($guid);
            //$this->cls->clsSession->set_new_guid($guid);
            //$this->cls->clsSession
            $this->cls->clsSession->session_start();

            //$_SESSION['username'] = 'john_doe';
            //print_r($_SESSION);
        }

        
        private function Run_Init_Functions_Install_Server() {
            
           
            
        }
        
        
        private function Set_Memebers(){
            
            if(isset($_SESSION['membersID'])){
                $this->membersID=$_SESSION['membersID'];
            }else{
                
                $this->membersID=0;
            }
        }

        private function All_Outputs(){
            //"full_install","remote_install"
            
            switch($this->project_type){
                case "full_install";
                    $html=$this->Output_HTML();
                break;
                case "remote_install";
                    $html=$this->Remote_Output_HTML();
                break;
                case "install_system";
                    $html=$this->Remote_Output_HTML();
                break;
            }
            //print "--".$html;
            
            return $html;
        }

        private function Remote_Output_HTML(){
           // $this->var['app']['asset_servers'][11]
            return $this->output_code;
        }

        private function classes_db_update(){
            $this->cls->clsSystemUpdate->create_database_class_list();
            $this->cls->clsSystemUpdate->create_database_class_methods_list();
        }

        
        
        private function Output_HTML(){
            //print_r($this->var);
            //$this->cls->clsMenu->XXX();
            //echo"--6888---------------------------------------------------------------------------\n";
            
            //$this->Start_App_Vars();
            //$time_data=$this->cls->clsStatistics->retrieve_time_samples();
            
            ////$this->log->general("Time Statistics",8,$time_data);

            //print("GGGXX11");
            //print_r(clsClassFactory::$cf_all_vars);
            //$this->var=&clsClassFactory::$vrs;
            //exit("fserve");
            $this->Update_All_Vars();
            
            $output_code="";
            $keywords=array();
            if(isset($this->var)){
                //print_r($this->var['template']);
                //if(is_array($this->var)){
                if(isset($this->var['template'])){
                    $output_code=base64_decode($this->var['template']['db']['filedata']);
                    $keywords=$this->var['content']["db"];
                }else{
                    $output_code="";
                    $keywords=array();
                }
                

            }else{
                $output_code="";
            }
            
            //$this->content_output_html=$this->template_code;
            
        //echo"--763gggaaa-------------------------|-".$output_code."-|------------------------------------------------\n";
            //if(isset($this->var['content']["db"]))
            
            if(!count($keywords)>0){
                $keywords['title']="";
                $keywords['meta_title']="";
                $keywords['meta_description']="";
                $keywords['meta_keywords']="";
                $keywords['meta_title']="";
                $keywords['title']="";
            }
            if(is_array($this->var)){
                if(!isset($this->var['app']['current_asset_server'])){
                    $this->var['app']['current_asset_server']="";
                }
            }
            //exit("fff");
            if(is_array($this->var)){
                $main_menu=$this->cls->clsMenu->Horizontal_Rounded();
                //echo"--473gggaaa-------------------------|-".$output_code."-|------------------------------------------------\n";
                //print_r($main_menu);
                
                $main_content=$this->var['module']["db"]['HTML'];//$this->content_output_html;
                //clsClassFactory::Add_Class("clsServerDetails");
                //$server_content="<pre>".var_export($this->cls->clsServerDetails->get_all_server_details(),true)."</pre>";
                //$server_content=$this->cls->clsServerDetails->get_all_server_details();
                //print_r($server_content);
                $this->content_output_html.=$server_content;//var_export($server_content,true);
                $side_bar=$this->cls->clsMenu->Vertical_Sub_Page();
                $tag_match_array=array("asset-sever"=>$this->var['app']['current_asset_server'],"html-title"=>$keywords['title'],"dc-title"=>$keywords['meta_title'],
                "meta_description"=>$keywords['meta_description'],"meta_keywords"=>$keywords['meta_keywords'],"main-menu"=>$main_menu,"meta-title"=>$keywords['meta_title'],
                "main-title"=>$keywords['title'],"main-content"=>$this->content_output_html,"side-bar"=>$side_bar);
                //print_r($tag_match_array);
                
                $output_arrays=$this->as->modify_tags($output_code,$tag_match_array);
                //echo"--666gggaaa-------------------------|-".var_export($output_arrays,true)."-|------------------------------------------------\n";
                if(!isset($output_arrays)){
                    $output_arrays=array();
                }else{
                    $output_code=$this->as->swap_tags($output_code,$output_arrays[0],$output_arrays[1],$output_arrays[2]);
                }
            }else{
                $output_code="";
            }
            ///print_r($output_arrays);
            
            //$this->a->modify_tags($this->template_code,$tag_match_array);
            //$this->Update_App_Vars();
            //print $output_code;
            
            $this->log->add_static_variables();
            $this->log->display_all();
            //$return_array=$this->cls->output_export_data();
            //$this->classes_db_update();
            //clsClassFactory::export_class_factory_data();
            //print_r($output_code);
            $output_code=$this->as->swap_asset_servers_ids($output_code,11,12);

            $this->output_code=$output_code;
            return $output_code;
            //print_r(base64_decode($this->var['template']["db"]['filedata']));
        }
        
        
        
        
    }
