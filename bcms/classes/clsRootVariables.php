<?php

    //class clsRootVariables extends clsDebug{
        class clsRootVariables{
            use trtBasic;
        public $module_data=array();
        public $domain_data=array();
        public $template_data=array();
        public $content_data=array();
        public $text_data=array();
        public $content_domain_data=array();
        public $domain_user_data=array();
        public $app_data=array();
        public $bizcat_data=array();

        public $menu_data=array();
        public $a;

        public $r;


        //public $factory;
        
        function __construct(){
            //$className="\n Root Class=>".__CLASS__."  => \n";
            //print $className;
            //$this->Reset_App_Vars();
            //$this->Start_Setup();
            //parent::__construct();
			
            //print"\n Start Root Variables \n";
            //$this->export();
		}
        
        public function Start_Setup(){
            
            //print"\n Start Root Variables \n";
            //echo"--ttt555-------------------------aaa--------------------------------------------------\n";
            //$this->factory=new clsClassFactory();
            
            $this->vrs=&clsClassFactory::$vrs;
            $this->cls=&clsClassFactory::$cf_cls;
            /*
            $this->log=$this->log;
            $this->r=$this->db;
            $this->a=$this->cls->clsAssortedFunctions;
            */
            $this->log=$this->log;
            $this->r=$this->db;
            $this->a=$this->as;
            //$this->Reset_App_Vars();
        }

        
        
        private function Start_App_Vars(){
			
            $this->module_data=$this->vrs->module_data;
            $this->domain_data=$this->vrs->domain_data;
            $this->template_data=$this->vrs->template_data;
            $this->content_data=$this->vrs->content_data;
            $this->text_data=$this->vrs->text_data;
            $this->content_domain_data=$this->vrs->content_domain_data;
            $this->domain_user_data=$this->vrs->domain_user_data;
            $this->app_data=$this->vrs->app_data;
            $this->bizcat_data=$this->vrs->bizcat_data;
            $this->menu_data=$this->vrs->menu_data;
            
		}
        
        private function Update_App_Vars(){
			
            $this->vrs->module_data=$this->module_data;
            $this->vrs->domain_data=$this->domain_data;
            $this->vrs->template_data=$this->template_data;
            $this->vrs->content_data=$this->content_data;
            $this->vrs->text_data=$this->text_data;
            $this->vrs->content_domain_data=$this->content_domain_data;
            $this->vrs->domain_user_data=$this->domain_user_data;
            $this->vrs->app_data=$this->app_data;
            $this->vrs->bizcat_data=$this->bizcat_data;
            $this->vrs->menu_data=$this->menu_data;
            
		}
		
		private function Reset_App_Vars(){
			
            $this->module_data=array();
            $this->domain_data=array();
            $this->template_data=array();
            $this->content_data=array();
            $this->text_data=array();
            $this->content_domain_data=array();
            $this->domain_user_data=array();
            $this->app_data=array();
            $this->bizcat_data=array();
            $this->menu_data=array();
            
		}
        
    }