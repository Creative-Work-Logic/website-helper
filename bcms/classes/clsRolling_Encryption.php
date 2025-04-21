<?php

    class clsRolling_Encryption{
       
        use trtBasic;
        
        function __construct(){
			echo"hello";
			
		}
        
        public function load_file($file_home){
            echo"hello".$file_home;
			$return=include($file_home);
			return $return;
		}

        
    }

