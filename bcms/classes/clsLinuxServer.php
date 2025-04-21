<?php
    class clsLinuxServer{
        use trtBasic;
        private $Base_Directory="";

        
        private $r;

        private $sess;

        private $return_array=array();
        private $return_text="";

        

        function __construct(){

        }

        public function Set_Log($log){
            $this->log=clsClassFactory::$cf_all_vars['log'];
            //print_r($this->log);
            ////$this->log->general('Boot Success: ',9,array());
                    
        }

        public function set_database($r=null)
        {
            $this->r=&clsClassFactory::$cf_all_vars['r'];
            
        }

        public function run_tests()
        {
            $this->return_array[]=$this->getInMemoryServices();
            $this->return_array[]=$this->getAvailableMemory();
            $this->return_array[]=$this->getHardDiskSize();
            $this->return_array[]=$this->Test_File_System();
            $this->return_array[]=$this->Test_Server_System();
            $this->return_array[]=$this->Test_Environmental_Variables();
            $this->return_array[]=$this->Test_PHP_Extensions();
            $this->return_array[]=$this->Test_Apache_Extensions();
            $this->return_array[]=$this->Test_PHP_Pear_Extensions();
            $this->return_array[]=$this->php_info();
            $this->return_array[]=$this->Test_Server_Details();
            $this->return_array[]=$this->Retrieve_All_Variables();
            $this->return_array[]=$this->getDirContents('/');
            $this->return_array[]=$this->Retrieve_All_Files();
            $this->return_text=var_export($this->return_array,true);
            return $this->return_text;
        }

        function getPermissions($path) {
            $output = "";
            // Check if the path exists
            if (file_exists($path)) {
                // Get permissions for the directory
                $permissions = substr(sprintf('%o', fileperms($path)), -4);
                $output .= "Permissions for $path: $permissions<br>";
        
                // Get permissions for each file and subdirectory (recursive)
                $files = scandir($path);
                foreach ($files as $file) {
                    if ($file != "." && $file != "..") {
                        $file_path = $path . DIRECTORY_SEPARATOR . $file;
                        if (is_dir($file_path)) {
                            $output .= getPermissions($file_path); // Recursive call for subdirectory
                        } else {
                            $permissions = substr(sprintf('%o', fileperms($file_path)), -4);
                            $output .= "Permissions for $file: $permissions<br>";
                        }
                    }
                }
            } else {
                $output .= "Path $path does not exist.";
            }
        
            return $output;
        }
        function getInMemoryServices() {
            // Execute the 'ps' command to list running processes
            exec('ps aux', $output);
        
            // Extract service information from the output
            $services = array();
            foreach ($output as $line) {
                $parts = preg_split('/\s+/', $line);
                // Assuming the service name is in the last column
                $serviceName = end($parts);
                // Add the service name to the list if it's not empty and not a header
                if (!empty($serviceName) && $serviceName !== "COMMAND") {
                    $services[] = $serviceName;
                }
            }
        
            return $services;
        }

             

        function getAvailableMemory() {
            // Execute the 'free' command to get memory information
            exec('free -m', $output);
        
            // Extract memory information from the output
            $availableMemory = "Unknown";
            foreach ($output as $line) {
                if (strpos($line, 'Mem:') !== false) {
                    $parts = preg_split('/\s+/', $line);
                    $availableMemoryMB = $parts[3]; // This value represents the available memory in MB
                    $availableMemory = $availableMemoryMB . " MB";
                    break;
                }
            }
        
            return $availableMemory;
        }


        function getHardDiskSize() {
            // Execute the 'df' command to get disk usage information
            exec('df -h', $output);
        
            // Extract the disk size from the output
            foreach ($output as $line) {
                if (strpos($line, '/dev/') !== false) {
                    $parts = preg_split('/\s+/', $line);
                    return $parts[1]; // This will return the disk size
                }
            }
        
            return "Unknown"; // Return this if disk size is not found
        }
        
        public function Test_File_System(){
            $output="";
            $current_dir=pathinfo(__DIR__);
            $output.="<br>\ncurrent dir<br>\n";
            $output.=var_export($current_dir,true)."<br>";
            $this->Base_Directory=$current_dir['dirname'].'\\'.$current_dir['basename'];
            $output.="<br>\ncurrent file<br>\n";
            $output.=$_SERVER['PHP_SELF'];
            return $output;
        }


        public function Test_Server_System(){
            $output="";
            $output.="<br>\ncurrent server<br>\n";
            $output.=$_SERVER['SERVER_NAME']."-<br>";
            $output.=gethostname();
            $output.="<br>\nserver hostname<br>\n";
            return $output;
        }

        public function Test_Environmental_Variables(){
            $output="";
            $php_ini=array();
            $php_ini[] = getenv('PHP_INI_SCAN_DIR');
            $php_ini[] = getenv('PHPRC');
            $output.=var_export($php_ini,true);
            return $output;
        }

        public function Test_PHP_Extensions(){
            $output="";
            $extensions_array=get_loaded_extensions();
	        $output.=var_export($extensions_array,true);
            return $output;
        }

        public function Test_Apache_Extensions(){
            $output="";
            $extensions_array=apache_get_modules();
	        $output.=var_export($extensions_array,true);
            return $output;
        }

        public function Test_PHP_Pear_Extensions(){
            $output="";
            $dir_name=realpath('../../../');
            $output=null;
	        $retval=null;

            $filename='pear';
            if (file_exists($filename)) {
                $output.="The file $filename exists";
            } else {
                $output.="The file $filename does not exist";
            }
            $exec_command=$filename.' list';
            //exec($exec_command, $output, $retval);
            $exec_output =shell_exec($exec_command);
            //$output.=var_export($extensions_array,true);
            $output.="<br>\n\n".$dir_name."<br>\n\n".$exec_command." <br>\n\nReturned with status $retval and output:\n";
            $output.=var_export($exec_output,true);
            return $output;
        }

        
        private function php_info()
        {
            $output="";
            ob_start();
            phpinfo();
            $info = ob_get_clean();
            $info = preg_replace("/^.*?\<body\>/is", "", $info);
            $info = preg_replace("/<\/body\>.*?$/is", "", $info);
            $output.=$info;
            return $output;
        }

        public function Test_Server_Details(){
            $output="";
            $output.=phpversion();
            $output.=php_sapi_name();
            $output.=$this->php_info();
            return $output;
        }

        public function Retrieve_All_Variables(){
            $output="";
            $output.=var_export($GLOBALS,true);
            return $output;
        }


        public function getDirContents($dir, &$results = array()) {
            $files = scandir($dir);
            foreach ($files as $key => $value) {
              $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
              if (!is_dir($path)) {
                $results[] = $path;
              } else if ($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
                $results[] = $path;
              }
            }
            return $results;
          }
          
                    
          public function Retrieve_All_Files(){
                $output="";
                $output.=var_export($this->getDirContents($this->Base_Directory),true);
                return $output;
           }
    }
