<?php

class clsGenericVariables {
use trtBasic;

    public $new_variables = array();
    
    

    public function __set($name, $value) {
        try{
            
            foreach($value as $key=>$val){
                foreach($val as $key2=>$val2){
                    $this->variables[$key][$key2]=$val2;
                }
            }
            
            //print($name);
            //$this->variables=$this->recurse_arrays($value);
            //print"\n Set Print_R ->".$name." - ".var_export($value,true)." | \n";
            //print_r($this->variables);

            $this->variables=array_merge($this->variables[$name], $value);

            //$this->export_data();
        }catch(Exception $e){
            print"\n Set ->".$name."".$value." | \n";
            //$this->trackAccess($name);
            return $this->export_data();
        }
        //$this->trackAccess($name);
        
        
        //$this->variables =array_merge($value,$this->variables);
        //$this->variables =$value;

        
    }
    
    
    public function set_vars($value) {
        try{
            //$this->new_variables=array_merge_recursive($this->new_variables, $value);
            
            //$this->new_variables=array_merge($this->new_variables, $value);
            $this->new_variables=array_merge($this->new_variables, $value);
        }catch(Exception $e){
            //print"\n Set ->".$name."".$value." | \n";
            //$this->trackAccess($name);
            return $this->export_data();
        }
    }

    public function get_vars() {
        return $this->new_variables;
    }
    
        
    public function recurse_arrays($value) {
        try{
            $var_array="";
            $temp_var="";
            if(is_array($value)){
                foreach($value as $key=>$val){
                    if(is_array($val)){
                        $temp_var=$this->recurse_arrays($val);
                        $var_array[$key]=array_merge($temp_var,$var_array[$key]);
                    }else{
                        $var_array[$key]=$val;
                    }
                    
    
                }
                return $var_array;
            }
            
            //$this->export_data();
        }catch(Exception $e){
            
            return $this->export_data();
        }
        //$this->trackAccess($name);
        
        
        //$this->variables =array_merge($value,$this->variables);
        //$this->variables =$value;

        
    }
    

    
    public function __get($name) {
        //$this->trackAccess($name);
        //$this->export_data();
        try{
            if(isset($this->variables[$name])){
                return $this->variables[$name];
            }else{
                return null;
            }
            
        }catch(Exception $e){
            $this->trackAccess($name);
            //print_r($this->variables);
            //$this->variables[$name]
            return $this->export_data();
        }
    }

    private function trackAccess($name) {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        $caller = isset($trace[1]) ? $trace[1] : null;

        if ($caller !== null) {
            $class = isset($caller['class']) ? $caller['class'] : 'Unknown';
            $method = isset($caller['function']) ? $caller['function'] : 'Unknown';
            echo "Accessed property '$name' in method '$method' of class '$class'.\n";
        }
    }
    
    public function export_data()
    {
        /*
        foreach($this->variables as $key=>$val){
            //print "\n ============= ";
            print var_export($key,true);
            print "\n ============= \n ";
            print var_export($val,true);
            print " ============= \n";
        }       
        */
        print var_export($this->new_variables,true);
        print "\n ============= \n ";
    }
    
}
