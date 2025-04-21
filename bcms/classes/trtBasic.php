<?php
    
    trait trtBasic{
       
        public $output;
        public $Message;
        public $data_banned=array();

        public $ErrorMessageArray=array();
        
        
        public $guid;

        public $log;
        public $db;
        public $adb;
        public $as;
        

        public $all_vars=array();
        public $var=array();
        public $cls=array();

        private $data=array();
        
        function __construct(){
            //print"\n S4FFF2233 \n";
            $this->Update_All_Vars();
			
		}

        function call_method($method_name,$input_variables=array()){
            //$this->Update_All_Vars();
            $this->output="";
			$this->output=call_user_func_array([$this, $method_name], $input_variables);
			return $this->output;
		}

        public function Export_All_Vars(){
            $out[]=var_export($this->get_class_details(get_class($this)),true);
            /*
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
            */
            //print_r($out);
		}

        public function Update_App_Vars(){
            //print_r($this->var);
            clsClassFactory::$vrs=$this->var;

            
        }

        public function Update_Globals(){
            $this->cls=&clsClassFactory::$cf_cls;
            $this->var=&clsClassFactory::$vrs;
        }
        
        public function Update_All_Vars(){
            //self::$cf_cls->Add_Class("clsAutoloader");
            //if(!isset($this->cls)){
                
            //}

            if(!isset($this->cls)){
                $this->Update_Globals();
            }
			
            $class_array=Array("clsAssortedFunctions"=>"as","clsSession"=>"sesh","clsDataStructures"=>"data","clsDatabaseInterface"=>"db"
        ,"clsDatabaseCRUD"=>"adb","clsLog"=>"log","clsError"=>"error");

            foreach($class_array as $key=>$val){
                //print $key;
                if(!isset($this->cls->$key)){
                    clsClassFactory::$cf_cls->Add_Class($key);
                    $this->Update_Globals();
                    //$this->cls->Add_Class($key);
                }
                if(!isset($this->$val)){
                    $this->$val=$this->cls->$key;
                }
            }
            /*
            if(!isset($this->db)){
				$this->as=$this->cls->clsAssortedFunctions;
                $this->sesh=$this->cls->clsSession;
                $this->data=$this->cls->clsDataStructures;
                $this->db=$this->cls->clsDatabaseInterface;
                $this->adb=$this->cls->clsDatabaseCRUD;
                $this->log=$this->cls->clsLog;
                $this->error=$this->cls->clsError;
			}
            */
            //print_r(clsClassFactory::$vrs);
        }

        public function set_logs($tag="",$number=0,$class="",$method="",$sql="",$exception="",$error=""){
            if($tag!="") $this->log->add_tag($tag);     
            if($number!=0) $this->log->add_unique_number($number);
            if($class=="") $class=get_class($this);
            $this->log->add_class_method($class,$method); 
            
		}


        public function Update_Static_Vars(){
            //print"\n Update Vars ".var_export($this->var,true)." \n";
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
        
        public function __call($name, $arguments) {
            echo"\n --DUMBO-2----------------------------$name----------------------------------------------\n";
            $this->output="";//"XXX $name No Method";
            //$this->Update_All_Vars();
            if($name!=""){
                if(method_exists($this, $name)){
                    $this->output=$this->call_method($name,$arguments);
                    //$this->output=call_user_func_array([$this, $name], $arguments);
                }else{
                    echo "\n Class->".get_class($this)." | No Method->".$name." | \n";
                }
            }
            //echo"\n --DUMBO-----------------------------$name----------------------------------------------\n";
            print $this->output;
            $this->Update_Static_Vars();
            return $this->output;
        }
        
        public function __set($name, $value)
        {
            //print "\n just xx".$name;
            if($name!="error"){
                $this->data[$name] = $value;
            }
            //$this->data[$name] = $value;
        }

        public function __get($name)
        {
            echo"--9887STARS-----------------------------$name----------------------------------------------\n";
            
            if (array_key_exists($name, $this->data)) {
                return $this->data[$name];
            }else{
                $this->cls->Add_Class($name);
                //$this->Update_All_Vars();
                return $this->data[$name];//"Error";
            }
        }

        public function recurse_array($variable_array)
        {
            $output=array();
            if (is_array($variable_array)) {
                foreach($variable_array as $key=>$val){
                    if(is_array($val)){
                        $output[$key]=array();
                        $recursive_output[]=$this->recurse_array($val);
                        $output[$key]=array_merge($output[$key],$recursive_output);
                        //$output[$key]=array_merge($output,$array_output);
                    }else{
                        $output[$key]=$val;
                    }
                }
            }
            //print_r($output);
            return $output;
        }
            
        public function get_class_details($class_name)
        {
            /*
            //clsClassFactory::export_class_factory_data();
            //print $class_name;
            $class_list_return=clsClassFactory::$class_list;
            //print_r($class_list_return);
            $return_array=array();
            if(in_array($class_name,$class_list_return)){
                
                $return_array=get_reflection_details($class_name);
            }else{
                //print_r(clsClassFactory::$cf_cls->$class_name);
                print "XX".$class_name;
                print_r($class_list_return);
            }
            return $return_array;
            */
        }

        public function get_reflection_details($class_name)
        {
            $return_array=array();
            $class_list_return=clsClassFactory::$class_list;
            
            
            
            if(in_array($class_name,$class_list_return)){
                //print_r($class_list_return);
                $reflector = new ReflectionClass($class_name);
                //$properties = $reflector->getProperties();
                //
                //print $class_name." \n";
                //$methods = get_class_methods(clsClassFactory::$cf_cls->get_class_object($class_name));//$reflector->getMethods();
                $methods[$class_name] = clsClassFactory::$cf_cls->get_class_object($class_name);//$reflector->getMethods();
                //print_r($methods);
                /*
                foreach($methods as $key=>$val){
                    print_r($val);
                    //$return_array[$class_name]["Methods"][]=$val["name"];
                }
                */
                //$return_array[$class_name]["Properties"][]=$properties["name"];
                
                $return_array=$methods;//array_merge($properties,$methods);
                /*
                print $class_name." \n";
                print_r($methods);
                print_r($properties);
                */
            }
            //print_r($return_array);
            return $return_array;
            
        }
        
        
    }