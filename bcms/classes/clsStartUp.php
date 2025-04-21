<?php

    class clsStartUp{
        use trtBasic;
        
        function __construct(){
            //echo"//XXX";
            $this->registerAutoloader();
			$this->Set_Exception_Handler();
            $this->Set_System_bindings();
            $this->Set_Headers();
            //echo"//YYY";
            //$this->var=&clsClassFactory::$vrs;
            //$this->cls=&clsClassFactory::$cf_cls;
			
		}

        private function Set_Headers(){
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                $http_origin = $_SERVER['HTTP_ORIGIN'];
                header("Access-Control-Allow-Origin: $http_origin");
            }
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        }
        
        
        
        private function Set_System_bindings(){
            //error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            
            //$this->Set_Error_Handler();
        }

        private function Set_Exception_Handler(){
            //set_exception_handler([$this->cls->clsExceptionHandler, 'handle']);
            //print clsClassFactory::$cf_cls->export();
            /*
            if(isset($this->cls->clsExceptionHandler)){
                set_exception_handler([$this->cls->clsExceptionHandler, 'handle']);
            }
                */
            
		}
        
        
        

        private function myErrorHandler($errno, $errstr, $errfile, $errline)
        {
            //$this->e->myErrorHandler($errno, $errstr, $errfile, $errline);
        }


        private function myAutoloader($className) {
            //print $className;
            if(strlen($className)>0){
                // Define your autoloading logic here
                // For example, if your classes follow PSR-4 naming conventions:
                $file = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
                if (file_exists($file)) {
                    include_once $file;
                }
            }
            
        }
        
        private function registerAutoloader() {
            // Register the autoloader method
           
            spl_autoload_register([$this, 'myAutoloader']);
        }
        
    }

