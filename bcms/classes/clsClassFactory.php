<?php

    class clsClassFactory{
                public  static  $project_type="full_install";
        public static $vrs;

        public static $cf_all_vars=array();

        public static $cf_cls;
        public static $class_list=array();
        
        
        private static $project_types=array("install","cli","worker","telnet","bbs",
        "phar","web","api","cron","ajax");
		
		

        private static $every_class_variable=array();

        private static $every_class_instantiated=array();

        function __construct($msg="hello"){

            include("bcms/classes/clsGenericProxyArray.php");
            self::$cf_cls=new clsGenericProxyArray();
            self::$cf_cls->Add_Class("clsAutoloader");
           
            $return=self::$cf_cls->load_file("trtBasic");
            self::$cf_cls->Add_Class("clsExceptionHandler");
            self::$cf_cls->Add_Class("clsAssortedFunctions");
            
            self::$cf_cls->Add_Class("clsSession");

            
            
            self::$cf_cls->Add_Class("clsSystem");
            
            
            
		}

        

		
       
    }
