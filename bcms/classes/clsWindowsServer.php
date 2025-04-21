<?php
    class clsWindowsServer{
        use trtBasic;
        private $Base_Directory="";

        
        private $r;

        private $sess;

        private $return_array=array();
        private $return_text="";

        
        function __construct($classes=array()){
            $this->cls=$classes;
            
		}

        

        public function Set_Log($log){
            //$this->log=clsClassFactory::$cf_all_vars['log'];
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
        
                // Use RecursiveDirectoryIterator to iterate through files and subdirectories recursively
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
                foreach ($iterator as $file) {
                    $file_path = $file->getPathname();
                    // Skip . and .. directories
                    if ($file_path !== "." && $file_path !== "..") {
                        $permissions = substr(sprintf('%o', fileperms($file_path)), -4);
                        $output .= "Permissions for $file_path: $permissions<br>";
                    }
                }
            } else {
                $output .= "Path $path does not exist.";
            }
        
            return $output;
        }

        function getInMemoryServices() {
            // Execute the 'tasklist' command to get service information
            exec('tasklist /FI "STATUS eq RUNNING" /FO CSV /NH', $output);
        
            // Extract memory usage information from the output
            $totalMemory = 0;
            foreach ($output as $line) {
                $parts = str_getcsv($line);
                // Memory usage is available in the 5th column
                $memory = (int) str_replace(',', '', $parts[4]); // Remove commas and convert to integer
                $totalMemory += $memory;
            }
        
            return $totalMemory . " KB";
        }

        function getAvailableMemory() {
            // Execute the WMIC command to get memory information
            exec('wmic OS get FreePhysicalMemory /Value', $output);
        
            // Extract memory information from the output
            $availableMemory = "Unknown";
            foreach ($output as $line) {
                if (strpos($line, 'FreePhysicalMemory') !== false) {
                    $parts = explode('=', $line);
                    $availableMemoryBytes = trim($parts[1]);
                    $availableMemoryGB = round($availableMemoryBytes / 1024 / 1024, 2); // Convert bytes to gigabytes
                    $availableMemory = $availableMemoryGB . " GB";
                    break;
                }
            }
        
            return $availableMemory;
        }

        function getHardDiskSize() {
            // Execute the WMIC command to get disk size information
            exec('wmic logicaldisk get size,freespace,caption', $output);
        
            // Extract disk size information from the output
            $diskSize = "Unknown";
            foreach ($output as $line) {
                if (strpos($line, 'C:') !== false) { // Assuming you want to get the size of the C: drive
                    $parts = preg_split('/\s+/', $line);
                    $diskSize = round($parts[1] / 1024 / 1024 / 1024, 2); // Convert bytes to gigabytes
                    break;
                }
            }
        
            return $diskSize . " GB";
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
            $output = "";
            $output .= "<br>\nCurrent Server<br>\n";
            $output .= $_SERVER['SERVER_NAME'] . "-<br>";
            $output .= gethostname();
            $output .= "<br>\nServer Hostname<br>\n";
            return $output;
        }

        public function Test_Environmental_Variables(){
            $output = "";
            $php_ini = array();
            $php_ini[] = getenv('PHP_INI_SCAN_DIR');
            $php_ini[] = getenv('PHPRC');
            $output .= var_export($php_ini, true);
            return $output;
        }

        public function Test_PHP_Extensions(){
            $output = "";
            $extensions_array = get_loaded_extensions();
            $output .= var_export($extensions_array, true);
            return $output;
        }

        public function Test_Apache_Extensions(){
            $output = "";
            
            if (function_exists('apache_get_modules')) {
                $extensions_array = apache_get_modules();
                $output .= var_export($extensions_array, true);
            } else {
                $output .= "apache_get_modules function is not available.";
            }
        
            return $output;
        }

        public function Test_PHP_Pear_Extensions(){
            $output = "";
            $dir_name = realpath('../../../');
            $output .= null;
            $retval = null;
        
            $filename = 'pear.bat'; // On Windows, PEAR commands are typically executed through a .bat file
            $pear_path = 'C:\path\to\pear'; // Update this with the actual path to your PEAR installation
            $pear_command = $pear_path . DIRECTORY_SEPARATOR . $filename;
        
            if (file_exists($pear_command)) {
                $output .= "The file $filename exists";
            } else {
                $output .= "The file $filename does not exist";
            }
        
            $exec_command = $pear_command . ' list';
            $exec_output = shell_exec($exec_command);
            
            // Display directory name, command executed, and output
            $output .= "<br>\n\nDirectory: $dir_name<br>\n\nCommand Executed: $exec_command <br>\n\nOutput:\n";
            $output .= var_export($exec_output, true);
        
            return $output;
        }

        
        private function php_info()
{
            $output = "";
            ob_start();
            phpinfo();
            $info = ob_get_clean();
            
            // Remove everything before the <body> tag
            $info = preg_replace("/^.*?<body[^>]*>/is", "", $info);
            
            // Remove everything after the </body> tag
            $info = preg_replace("/<\/body>.*?$/is", "", $info);
            
            // Remove any HTML comments
            $info = preg_replace("/<!--(.*?)-->/is", "", $info);
            
            $output .= $info;
            return $output;
        }

        public function Test_Server_Details(){
            $output = "";
            
            // Retrieve PHP version
            $output .= "PHP Version: " . phpversion() . "<br>";
            
            // Retrieve PHP SAPI name (Server API)
            $output .= "Server API: " . php_sapi_name() . "<br>";
            
            // Additional server details (using phpinfo)
            ob_start();
            phpinfo();
            $phpinfo_output = ob_get_clean();
            $output .= "Additional PHP Info: " . $phpinfo_output . "<br>";
            
            return $output;
        }
        public function Retrieve_All_Variables(){
            $output = "";
            $output .= var_export($GLOBALS, true);
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
                }
            }
            
            return $results;
        }
          
                    
          public function Retrieve_All_Files(){
            $output = "";
            $output .= $this->getDirContents($this->Base_Directory);
            return $output;
        }
        
        /*
        private function getDirContents($dir){
            $files = scandir($dir);
            $result = array();
        
            foreach($files as $file){
                if($file != "." && $file != ".."){
                    $path = $dir . DIRECTORY_SEPARATOR . $file;
                    if(is_dir($path)){
                        $result = array_merge($result, $this->getDirContents($path));
                    } else {
                        $result[] = $path;
                    }
                }
            }
        
            return $result;
        }
        */
    }
