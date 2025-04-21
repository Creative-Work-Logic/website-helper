<?php
    
    trait trtCurrent{
       
        public $output;
        public $Message;

        public $ErrorMessageArray=array();
        
        
        public $guid;

        public $log;
        public $db;
        public $as;
        

        public $cf_all_vars=array();
        public $var=array();
        public $cls=array();

        private $data=array();
        
        function __construct(){
            
			$this->Update_All_Vars();
		}

        public function Export_All_Vars(){
            $this->Update_All_Vars();
            $out[]=var_export($this->output,true);
            $out[]=var_export($this->Message,true);
            $out[]=var_export($this->ErrorMessageArray,true);
            $out[]=var_export($this->guid,true);
            $out[]=var_export($this->log,true);
            $out[]=var_export($this->db,true);
            $out[]=var_export($this->as,true);
            $out[]=var_export($this->all_vars,true);
            $out[]=var_export($this->var,true);
            $out[]=var_export($this->cls,true);
            $out[]=var_export($this->data,true);
            //print_r($out);
		}
        
        public function Update_All_Vars(){
            
            print"\n S4FFF2233 \n";
            
			$this->cls=&clsClassFactory::$cf_cls;
            $this->var=&clsClassFactory::$vrs;
            $this->db=&clsClassFactory::$cf_cls->clsDatabaseInterface;
            $this->log=&clsClassFactory::$cf_cls->clsLog;
            $this->as=&clsClassFactory::$cf_cls->assorted;
		}

        public function Update_Static_Vars(){
            clsClassFactory::$vrs=$this->var;
            
		}

        public function Run_Class($target_class,$method){
            
            //print"\n S4FFF2233 \n".$target_class."->".$method;
            $return_html="";
            $return_html=$this->cls->$target_class->$method();
            //print"\n 55FFF223".$return_html." \n";
            return $return_html;
		}

        public function Set_Vars($var,$class){
            
            //print"\n S4FFF2233 \n";
            
			$this->data[$var]=$class;
		}
        
        
    }