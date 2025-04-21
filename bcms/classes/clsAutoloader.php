<?php
    class clsAutoloader {
      public $all_class=array(); 
      public $root_directory=array("/var/www/html/",
      "/home/dino/Downloads/phpdesktop-linux-72.1/www/html/","./bcms/classes/");
		  
      function __construct(){
        //print "\n xx=>";
        
        //print "\n yy=>";

        spl_autoload_register(function ($class_name) {
          
          $this->load($class_name);
        });
        //print "\n yy2=>";
        try{
          
        }catch(Exception $e){
          print "\n Error: ".$e->getMessage();
        }
        
        
        //$this->load_classes();
      }

      public function load_classes() {
        
        
        //print "\n looaa=>";
        
        //$this->all_class=array($gproxy,$gproxy_array);
        $this->load_file("clsClassFactory");
        
        
        
        //print_r($this->all_class);
      }

      public function load_file($file_name) {
        
        $return=false;
        //$filename=$this->root_directory[1]."bcms/classes/" . $file_name . ".php";
        $filename="./bcms/classes/" . $file_name . ".php";
        //print "\n looaa=>".$filename."<br>";
        if (is_file($filename)) {
          //print "\n looo=>".$filename;
          //$return=include_once($filename);
          //$this->cls->clsRolling_Encrtyption->load_file($filename);
          //print "\n xxxyy=>".$filename;
        }else{
          print "\n File not found: " . $filename;
        }
        return $return;        
      }
      public function load($class_name) {
        
        //print $class_name . '.php xx3';
        
        $file_exists=$this->load_file($class_name);
        //if($file_exists){
            //clsClassFactory::$cf_cls->Add_Class($class_name);
            //clsClassFactory::Add_Class($class_name);
        //}      
      }
    }