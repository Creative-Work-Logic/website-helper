<?php

    class clsRunScripts{
		use trtBasic;
        private $Base_Directory="";

		

        function __construct(){
			ini_set("extension", "pgsql");
        }
		
		static function callback($buffer)
		{
		  return $buffer;
		}

		function run_ruby_script($filename){
			
			$return_array=array();
			if(file_exists($filename)){
				$command='D:\Ruby30-x64\bin\ruby.exe '.$filename;

				$include_file=$filename;
				$exec_file=$command;
				$return_array=$this->execute_file($exec_file,$include_file);
				
			}
			return $return_array;
		}
		
		function run_go_script($filename){
			$return_array=array();
			return $return_array;
		}
		
		function run_php_script($filename){
			$return_array=array();
			if($filename!="./index.php"){
				if(file_exists($filename)){
					$include_file=$filename;
					$return_array=$this->execute_file("",$include_file);
				}
			}
			return $return_array;
		}
		
		function run_php_index_script($filename){
			$return_array=array();
			$include_file="";
			if($filename!="./index.php"){
				if(file_exists($filename)){
					$include_file=$filename;
				}
				$return_array=$this->execute_file("",$include_file);
			}
			return $return_array;
		}
		
		function run_php_index_file($filename){
			$return_array=array();
			if($filename!="./index.php"){
				if(file_exists($filename)){
					$include_file=$filename;
					$return_array=$this->execute_file("",$include_file);
				}
			}
			return $return_array;
		}
		
		function run_php_port_script($filename){
			$return_array=array();
			if(file_exists($filename)){
				return false;
				exit("");
			}
			return $return_array;
		}
		
		function run_html_script($filename){
			$return_array=array();
			if(file_exists($filename)){
				$include_file=$filename;
				$return_array=$this->execute_file("",$include_file);
			}
			
			return $return_array;
		}
		
		function run_cplusplus_script($filename){
			$return_array=array();
			return $return_array;
		}
		
		function run_python_script($filename){
			
			$return_array=array();
			if(file_exists($filename)){
				$command='python '.$filename;

				$include_file=$filename;
				$exec_file=$command;
				
				$return_array=$this->execute_file($exec_file,$include_file);
			}
			return $return_array;
		}
		
		function run_perl_script($filename){
			$return_array=array();
			if(file_exists($filename)){
				$command='C:\Strawberry\perl\bin\perl.exe '.$filename;

				$include_file=$filename;
				$exec_file=$command;
				$return_array=$this->execute_file($exec_file,$include_file);
				
			}
			return $return_array;
		}
		
		function run_lua_script($filename){
			$return_array=array();
			if(file_exists($filename)){
				$command='J:\Projects\Current\Easy-Bubble-CMS\GitHub\iCWLNet-Chrome-Extension\Chrome-Extension\Languages\Lua\5.1\lua.exe '.$filename;

				$include_file=$filename;
				$exec_file=$command;
				$return_array=$this->execute_file($exec_file,$include_file);
				
			}
			return $return_array;
		}
		
		function run_powershell_script($filename){
			$return_array=array();
			if(file_exists($filename)){
				$command='powershell '.$filename;

				$include_file=$filename;
				$exec_file=$command;
				$return_array=$this->execute_file($exec_file,$include_file);
				
			}
			return $return_array;
		}
		
		
		
		function run_asp_script($filename){
			$return_array=array();
			if(file_exists($filename)){
				$command='C:/Program%20Files/Mono/bin/mono.exe '.$filename;

				$include_file=$filename;
				$exec_file=$command;
				$return_array=$this->execute_file($exec_file,$include_file);
				
			}
			return $return_array;
		}
		
		function run_execute($exec_file){
			$output=null;
			$retval=null;
			//print $exec_file;
			exec($exec_file, $output, $retval);
			//print $exec_file."-".var_export($output,true)."-".var_export($retval,true);
			//print var_export($output,true);
			$return_array=array($output,$retval);
			return $return_array;
		}
		
		function run_include($include_file){
			//chdir('./db/adminer/');
			$output="";
			$include_file="../../".$include_file;
			if(file_exists($include_file)){
				$bo = ob_start ("self::callback") ;
				include($include_file);
				$output = ob_get_contents();
				ob_end_clean();
			}
			return $output;
		}
		
		function execute_file($exec_file="",$include_file=""){
		
			$output=null;
			$retval=null;
			$return_array=array();
			if($exec_file!=""){
				$return_array[]=$this->run_execute($exec_file);
				//print "-".var_export($return_array,true);
			}
			if($include_file!=""){
				$output =$this->run_include($include_file);
				$return_array[]=$output;
			}
			//print "-".var_export($return_array,true);
			return $return_array;
		}
		
		function detect_script_type(){
			$return_array=array();
			$include_file="";
			$exec_file="";
			$display="";

			$script_name=$_SERVER['SCRIPT_NAME'];
			$uri=$_SERVER["REQUEST_URI"];
			$original=$uri;
			if(strpos($uri,"?")>-1){
				$uri=$script_name;
			}
			$filename=".".$_SERVER["REQUEST_URI"];
			if (preg_match('/\.(?:pl)$/',$uri )) {
				$return_array=$this->run_perl_script($filename);
			}elseif(preg_match('/\.(?:lua)$/', $uri)) {	
				$return_array=$this->run_lua_script($filename);
			}elseif(preg_match('/\.(?:ps1)$/', $uri)) {	
				$return_array=$this->run_powershell_script($filename);
			}elseif(preg_match('/\.(?:py)$/', $uri)) { 
				$return_array=$this->run_python_script($filename);
			}elseif (preg_match('/\.(?:go)$/', $uri)) { 
				$return_array=$this->run_go_script($filename);
			}elseif (preg_match('/\.(?:rb)$/', $uri)) { 
				$return_array=$this->run_ruby_script($filename);
			}elseif (preg_match('/\.(?:html)$/', $uri)) { 
				$return_array=$this->run_html_script($filename);
			}elseif (preg_match('/\.(?:php)$/', $uri)) { 
				$return_array=$this->run_php_script($filename);
			}elseif(substr($uri, -1)=='/') { 
				$filename=".".$uri."index.php";
				$return_array=$this->run_php_index_script($filename);
			}elseif(substr($uri, -1)!='/') { 
				$filename=".".$original;
				$return_array=$this->run_php_port_script($filename);
			}else{
				$filename=".".$uri."index.php";
				$return_array=$this->run_php_index_file($filename);
			}
			$this->output_details($return_array);
		}
		
		function output_details($return_array){
			print_r($return_array);
		}
    }

?>