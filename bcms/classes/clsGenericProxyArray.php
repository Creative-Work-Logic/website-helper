<?php


class clsGenericProxyArray
{
    //use trtBasic;
    
    public $obj=array();
    public $object_names=array();
    private $handler;

    private $stats=false;

    
    
    //public function __construct($target, callable $exceptionHandler = null)
    //public function __construct($target=null, callable $exceptionHandler = null)
    public function __construct()
    {
        $this->load_file("clsGenericProxy");
        $this->Add_Class("clsAutoloader");
        
    }

    public function set_stats()
    {
        //if(isset(clsClassFactory::$cf_cls->clsStatistics)){
            //$this->stats=&clsClassFactory::$cf_cls->clsStatistics;
        //}
        
    }

    public function set_class_object($target)
    {
        $return_var=false;
        //echo"--XX11222STARS----------------$name-----------------------------------------------------------\n";
        $name=get_class($target);
        if(!isset($this->obj[$name])){
            $this->obj[$name] = $target;
            $this->object_names[]=$name;
            $return_var=true;
        }
        return $return_var;
    }

    public function set_class($name,$target)
    {
        //echo"--XX11222STARS----------------$name-----------------------------------------------------------\n";
        if(!isset($this->obj[$name])){
            $this->obj[$name] = $target;
            $this->object_names[]=$name;
        }
        
    }

    public function check_class($name)
    {
        $return_var=false;
        if(!isset($this->obj[$name])){
            
            $return_var=true;
        }else{
            
            $return_var=false;
        }
        /*
        if($name=="clsDatabaseInterface"){
            $return_var=false;
        }
            */
        return $return_var;
    }

    public function run_class_method($class,$method, $arguments)
    {
        //$this->log->add_class_method($class,$method);
        
        //echo"--88STARS---------------------------------------------------------------------------\n";
        $retrieve_class_method=false;
        $this->output="";
        if (isset($this->obj[$class])) {
            if(method_exists($this->obj[$class], $method)){
                $retrieve_class_method=true;
            }else{
                echo "\n No Method->".$method." | \n";
            }
            
        }elseif(!isset($this->obj[$class])){
            $this->Add_Class($class);
           $retrieve_class_method=true;
        }
        
        if($retrieve_class_method){
            try{
                $this->obj[$class]->Update_All_Vars();
                $this->output=call_user_func_array([$this->obj[$class], $method], $arguments);
                $this->obj[$class]->Update_Static_Vars();
            }catch(Exception $e){
                $this->log->add_exception($e);
                //print_r($e);
            }
        }
        $this->log->add_static_variables();
        return $this->output;
    }

    public function get_class($name)
    {
        //echo "\nXXX No Method->".$name." | \n";
        $return="";
        if(!isset($this->obj[$name])){
            //echo "\n No Method->".$name." | \n";
            $this->Add_Class($name);
        }
        $return=$this->obj[$name];
        return $return;
        
    }

    public function Add_Class($class=""){
        $return_class=false;
        $return_file=false;
        //throw new \ErrorException("error", 0, 123, __FILE__, __LINE__);
        //echo"\n FFF hello->".$class." \n";
        try{
            
            if($this->check_class($class)){
                
                if($class=="clsExceptionHandler"){
                    //$return_class=new clsGenericProxy();
                    //self::$cf_cls->$class=$return_class;
                }elseif($class=="clsGenericProxy"){
                    //$return_class=new clsGenericProxy();
                    //self::$cf_cls->$class=$return_class;
                }else{
                    //echo"\n new class->".$class;
                    $return_file=$this->load_file($class);
                    if($return_file){
                        $return_class=new clsGenericProxy(new $class());
                        //self::Set_Class($class,$return_class);
                        $this->set_class($class,$return_class);
    
                        //self::$cf_cls->$class=$return_class;
                    }else{
                        echo"file doesnt exist";
                    }
                }
                
            }else{
                //echo"class exists";
            }
        }catch(Exception $e){
            echo"class error";
        }
        //echo"\n 1888xxx->".var_export($return_class,true)." \n";
        return $return_class;
        
    }

    public function load_file($file_name) {
        //print "\n looaa=>".$file_name;
        $return=false;
        $filename="./bcms/classes/" . $file_name . ".php";
        if (is_file($filename)) {
            
            if (is_readable($filename)) {
                
                //$return=include($filename);
                $return=$this->Load_Code($filename);
                //echo 'The file is readable';
                //echo 'The file is readable';
            } else {
                echo 'The file is not readable '."\n";
                echo substr(sprintf('%o', fileperms($filename)), -4);
            }
            
          //print "\n file exits=>".$filename;
          
          if($return){
              //print "\n file loaded=>".$filename;
          }else{
            print "\n File error: " . $filename;
          }
          //print "\n xxxyy=>".$filename;
        }else{
          print "\n File not found: " . $filename;
        }
        return $return;        
      }

      public function Load_Code($filename){
        //$return=include($filename);
        //echo 'The file is readable';
        $return=false;
        try{
            //self::$cf_cls->output_export_classes();
            //print_r(self::$cf_cls);
            $return=include($filename);
            //if(!isset(self::$cf_cls->clsRolling_Encryption)){
             //   echo 'The file is readable';
              //  self::Add_Class("clsRolling_Encryption");
            //}
            //$return=self::$cf_cls->clsRolling_Encryption->load_file($filename);
        }catch(Exception $e){
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
        
        //echo 'The file is readable';
        return $return;
    }
    
    public function __get($name)
    {
        
        $return=$this->get_class($name);
        
        return $return;
    }
    
    public function __set($name,$target)
    {
        //echo"--STARS---------------$name------------------------------------------------------------\n";
        $this->set_class($name,$target);        
    }

    public function get_class_object($name)
    {
        //echo"--STARS---------------$name------------------------------------------------------------\n";
        return $this->obj[$name]->get_class_methods();       
    }

    
    
    
    public function output_export_data()
    {
        //print_r($this->object_names);
        $class_reflection=array();
        foreach($this->object_names as $name_key=>$name_value){
            //print $name_value;

            //$class_reflection[]=$this->get_reflection_details($name_value);
            
        }
        
        
        return $class_reflection;
    }

    public function output_export_classes()
    {
        print_r($this->obj);
        
    }

    public function test()
    {
        
        $class_reflection=array("XXX");
        //print_r($class_reflection);
        return $class_reflection;
    }
}
