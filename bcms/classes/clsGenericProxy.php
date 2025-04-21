<?php

class clsGenericProxy
{
    //use trtBasic;

    

    

    
    private $output="";
    public $class_obj;
    private $handler;
    private $stats=false;
    private $banned=array("trtBasic","clsGenericProxy");
    

    
    public function __construct($target=null, callable $exceptionHandler=null)
    {
        

        if(!is_null($target)){
            if(is_object($target)){

            
                //print("\n 11134".get_class($target)." \n ");
                if(!in_array(get_class($target),$this->banned)){
                    //$this->class_obj = $target;
                    
                        if(is_object($target)){
                            
                            $this->set_object($target);
                        }
                    
                    
                    //$this->class_obj->cls=&clsClassFactory::$cf_cls;
                    //$this->class_obj->all_vars->methods=array();
                    $this->set_globals();
                    //$this->class_obj->__construct();
                }
            }
        }else{
            print("\n 11134 \n ");
        }
        //print("\n proxy doine \n ");
    }

    public function update_globals()
    {
        //clsClassFactory::$vrs=array_merge(clsClassFactory::$vrs, $this->class_obj->all_vars);
        //$this->class_obj->set_vars($this->class_obj->all_vars);
        //clsClassFactory::$vrs->set_vars($this->class_obj->all_vars);
        
        //clsClassFactory::$vrs->new_variables=array_replace(clsClassFactory::$vrs->new_variables, $this->class_obj->all_vars);
        //print("1113 \n ");
        //print_r($this->class_obj->all_vars);
        //clsClassFactory::$vrs->new_variables = $this->mergeArraysRecursively(clsClassFactory::$vrs->new_variables, $this->class_obj->all_vars);

        clsClassFactory::$cf_all_vars = $this->mergeArraysRecursively(clsClassFactory::$cf_all_vars, $this->class_obj->all_vars);
        
        //print("1112 \n ");
        //print_r($result);
        //print(" \n ");
        //clsClassFactory::$vrs->new_variables = $this->recurse_arrays($value);
    }

    public function set_globals(){
        //$this->class_obj->Export_All_Vars();
        /*
        if (method_exists($this->class_obj,'Update_All_Vars')){
            $this->class_obj->Update_All_Vars();
        }
        */
        
        //$this->class_obj->cls=&clsClassFactory::$cf_cls;
        //$this->class_obj->var=&clsClassFactory::$vrs;
        
    }

    public function set_object($class){
        ///print $class.' \n';
        $this->class_obj = $class;
    }


    public function set_method($method,$arguments){
        $current_meth=array();
        $current_meth['current_class']=get_class($this->class_obj);
        $current_meth['current_arguments']=$arguments;
        $current_meth['current_method']=$method;
        /*
        if(isset($this->output)>0){
            print $this->output;
            $current_meth['current_output']=base64_encode($this->output);

        }
        */
        //if(!isset($this->class_obj->all_vars->methods)) $this->class_obj->all_vars->methods=array();
        $this->class_obj->all_vars['methods'][]=$current_meth;
        $this->update_globals();
    }

    function mergeArraysRecursively($array1, $array2) {
        foreach ($array2 as $key => $value) {
            // Check if both arrays have an array at this key
            if (is_array($value) && isset($array1[$key]) && is_array($array1[$key])) {
                $array1[$key] = $this->mergeArraysRecursively($array1[$key], $array2[$key]);
            } else {
                // Otherwise, set the value from the second array
                $array1[$key] = $value;
            }
        }
        return $array1;
    }

    public function set_stats()
    {
        if(isset($this->clss->clsStatistics)){
            $this->stats=$this->cls->clsStatistics;
        }
        
    }
    
    public function __get($name)
    {
        //if($this->stats) $this->stats->take_time_sample();
        return $this->class_obj;
        
    }
    /*
    public function __set($name,$target)
    {
        echo"\n --987X----------Class->$name-$target--------------------------------------------\n";
        
        $this->class_obj[$name] = $target;
    }
    */
    public function __call($method="", $arguments=array())
    {
        $current_class=get_class($this->class_obj);
        if($current_class=="clsMembers"){
            //echo"\n --123X----------Class->".$current_class."----------------Method=>-$method------\n".var_export($arguments,true)."--------------------------------------------\n";
            //echo"\n --123X----\n";
        }else{
            //echo"other";
        }
        
        $this->output="";
        if(isset($method)){
            if($method!=""){
                try{
                    $this->output=$this->run_class_method($method, $arguments);
                }catch(Exception $e){
                    print_r($e);
                }
            }
        }
        return $this->output;
    }

    public function run_class_method($method="", $arguments=array())
    {
       // echo"\n --Run---Class->".get_class($this->class_obj)."------------------------$method-------------------------------------------------\n";
        //var_dump(debug_backtrace());
        
        $this->output="";
        $current_class=get_class($this->class_obj);
        try{
            if(isset($method)){
                if($method!=""){
                    if(method_exists($this->class_obj,$method)){
                        $this->set_globals();
                        if(isset($this->class_obj)){
                            $this->output=call_user_func_array([$this->class_obj, $method], $arguments);
                            if($current_class=="clsMembers"){
                                //print_r($this->output);
                            }
                        }                    
                        
                        $this->update_globals();
                        
                    }else{
                        $this->output="Uknown Method ->".$method;
                    }
                }else{
                    print $method;
                }
            }
            
            
            
            
            return $this->output;

        }catch(Exception $e){
            print_r($e);
        }
        return $this->output;
    }

    public function output_export_classes()
    {
        print_r($this->class_obj->cls);
        
    }

    public function export_data()
    {
        print_r($this->class_obj->all_vars);
        print_r($this->class_obj->var);
        print_r($this->class_obj->cls);
    }

    public function get_class_methods()
    {
        return get_class_methods($this->class_obj);       
    }

    
}
