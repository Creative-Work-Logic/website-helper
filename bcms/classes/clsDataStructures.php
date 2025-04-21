<?php

    class clsDataStructures{
       
        use trtBasic;

        public $banned=array("trtBasic","clsGenericProxy","clsClassFactory");

        function __construct(){
			
			
		}

        public function return_property($property_name){
			return $property_name;
			
		}
        
    }

