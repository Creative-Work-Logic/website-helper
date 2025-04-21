<?php

    class clsDebug{
        use trtBasic;

        
        function __construct(){
            $className="\n Class=>".__CLASS__."  => \n";
			//print $className;
			
		}

        public function export()
        {   
            $return_string="\n Class=>".__CLASS__."  => \n";
            /*
            if(is_array($this->var)){
                foreach($this->var as $key=>$val){
                    if(is_array($this->var)){
                        $return_string.="\n >".$key." = ".var_export($val,true)." \n";
                    }else{
                        $return_string.="\n >".$key." = ".$val." \n";
                    }
                }
            }else{
                $return_string.="\n =".$this->var." \n";
            }
            */
            return $return_string;
        }
    }