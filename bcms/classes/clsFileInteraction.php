<?php



    class clsFileInteraction{
        use trtBasic;

        private $directories=array();
        private $files=array();
        private $current_directories=array();
        private $current_files=array();
        private $class_files=array();
        private $class_file_details=array();
        private $root_directory='C:\Program Files\\';
        
        function __construct(){
			
			
		}

        public function recurse_directory($path = './') {
            $this->files = array();
            $this->directories = array();
            $current=array();
            $result = array('files' => array(), 'directories' => array());
        
            try {
                $directoryIterator = new RecursiveDirectoryIterator($path);
                $iterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);
        
                foreach ($iterator as $file) {
                    $filePath = $file->getRealPath();
                    if ($file->isDir()) {
                        $result['directories'][] = $filePath;
                    } elseif ($file->isFile()) {
                        $result['files'][] = $filePath;
                    }
                }
            } catch (UnexpectedValueException $e) {
                echo "Error: " . $e->getMessage();
            }
            $current=array($result['directories'],$result['files']);
            //$this->current_files = $result['files'];
            //$this->current_directories = $result['directories'];
            return $current;
           
        }

        public function retrieve_directory($path = './') {
            $this->files = array();
            $this->directories = array();
            $result = array('files' => array(), 'directories' => array());
        
            try {
                $directoryIterator = new DirectoryIterator($path);
        
                foreach ($directoryIterator as $file) {
                    if ($file->isDot()) continue; // Skip . and ..
                    $filePath = $file->getRealPath();
                    if ($file->isDir()) {
                        $result['directories'][] = $filePath;
                    } elseif ($file->isFile()) {
                        $result['files'][] = $filePath;
                    }
                }
            } catch (UnexpectedValueException $e) {
                echo "Error: " . $e->getMessage();
            }
        
            
            $current=array($result['directories'],$result['files']);
            return  $current;//$this->class_files;
            //$this->directories = $result['directories'];
        }
        
        

        public function show_directory($path='./',$recurse=true){
            //if(count($this->directories)==0){
            $current=array();
            if($recurse){
                $current=$this->recurse_directory($path);
            }else{
                $current=$this->retrieve_directory($path);
            }
            //$current=$this->retrieve_directory($path,$recurse);
            $current_directories=$current[0];
            $rest=array();
            //}
            
            $prev=array();
            foreach($current_directories as $key=>$val){
                
                if(!in_array($val,$prev)){
                    
                    $rest[] = $val;//substr($val, strlen($this->root_directory));  
                    //print "\n".$rest;
                    $prev[]=$val;
                }
                
            }
            
            return $rest;
        }

        public function show_website_helper_files($variables=array()){
            $return=array();
            $current=array();
            $current[0]=$this->show_files('./',false);
            $current[1]=$this->show_files('./bcms/classes/',false);
            $current[2]=$this->show_files('./bcms/db/',false);
            $return=array_merge($current[0][1],$current[1][1],$current[2][1]);
            //print_r($return);
            return $return;
        }

        public function show_website_helper_directories($variables=array()){
            $current=array();
            //$root_directory_files=$this->show_directory('./',false);
            $current=$this->show_directory('./bcms/',false);
            //$db_directory_files=$this->show_directory('./bcms/db/',false);
            //$this->directories=array_merge($root_directory_files,$bcms_directory_files,$db_directory_files);
            //print_r($current);
            $this->directories=$current;//array_merge($bcms_directory_files);
            //print_r($this->files);
            return $this->directories;
        }

        public function show_files($path='./bcms/',$recurse=true){
            $current=array();
            if($recurse){
                $current=$this->recurse_directory($path);
            }else{
                $current=$this->retrieve_directory($path);
            }
            //print_r($current);
            //}
            /*
            $prev=array();
            foreach($this->current_files as $key=>$val){
                
                if(!in_array($val,$prev)){
                    //print "\n".$val;
                    $prev[]=$val;
                }
                
            }
            */
            return $current;
        }

        public function show_class_files($path = 'C:/Program Files/Ampps/www/bcms/classes/'){
            $this->class_file_details=array();
            $this->class_files=$this->retrieve_directory($path);
            foreach($this->class_files as $key=>$val){
                $this->class_file_details[]=$this->retrieve_class_details($val);
            }
            //print_r($this->class_file_details);
            return $this->class_file_details;
        }

        public function retrieve_class_details($path){
            
            $fileContent = file_get_contents($path);
            // Match class names
            preg_match_all('/class\s+(\w+)/', $fileContent, $classMatches);
            $classNames = $classMatches[1];

            // Match methods with visibility
            preg_match_all('/(public|protected|private)?\s*function\s+(\w+)\s*\(/', $fileContent, $methodMatches);
            $methodDetails = array_map(function($visibility, $name) {
                return [
                    'visibility' => $visibility ?: 'public', // Default to public if not specified
                    'name' => $name
                ];
            }, $methodMatches[1], $methodMatches[2]);

            // Match properties with default values
            preg_match_all('/(public|protected|private)\s+\$([\w]+)\s*=\s*([^;]+);/', $fileContent, $propertyMatches);
            $propertyDetails = array_map(function($visibility, $name, $default) {
                return [
                    'visibility' => $visibility,
                    'name' => $name,
                    'default' => trim($default)
                ];
            }, $propertyMatches[1], $propertyMatches[2], $propertyMatches[3]);

            // Match method parameters with default values
            preg_match_all('/function\s+\w+\s*\(([^)]*)\)/', $fileContent, $methodVarMatches);
            $methodVariables = array_map(function($paramString) {
                preg_match_all('/\$\w+\s*=\s*[^,]+/', $paramString, $paramMatches);
                return array_map(function($param) {
                    list($name, $default) = explode('=', $param);
                    return [
                        'name' => trim($name),
                        'default' => trim($default)
                    ];
                }, $paramMatches[0]);
            }, $methodVarMatches[1]);

            // Match traits
            preg_match_all('/trait\s+(\w+)/', $fileContent, $traitMatches);
            $traitNames = $traitMatches[1];

            // Match interfaces
            preg_match_all('/interface\s+(\w+)/', $fileContent, $interfaceMatches);
            $interfaceNames = $interfaceMatches[1];

            // Match classes that extend other classes
            preg_match_all('/class\s+(\w+)\s+extends\s+(\w+)/', $fileContent, $extendsMatches);
            $extendedClasses = array_combine($extendsMatches[1], $extendsMatches[2]);

            // Match traits used in classes
            preg_match_all('/class\s+\w+\s*(?:implements\s+\w+\s*)?{[^}]*use\s+([\w, ]+);/', $fileContent, $traitUsageMatches);
            $traitsUsed = array_map('trim', explode(',', implode(',', $traitUsageMatches[1])));

            $return_array = [
                'classes' => $classNames,
                'methods' => $methodDetails,
                'properties' => $propertyDetails,
                'method_variables' => $methodVariables,
                'traits' => $traitNames,
                'interfaces' => $interfaceNames,
                'extended_classes' => $extendedClasses,
                'traits_used' => $traitsUsed
            ];

            
            return $return_array;
        }


        /*
        function md_file_put_contents($file,$Contents){
			
			$current = file_get_contents($file);
            // Append a new person to the file
            $current .= $Contents;
            // Write the contents back to the file
            file_put_contents($file, $current);
		}

        function md_file($file,$Contents){
            $lines = file($file);

            // Loop through our array, show HTML source as HTML source; and line numbers too.
            foreach ($lines as $line_num => $line) {
                echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
            }

            // Using the optional flags parameter
            $trimmed = file('somefile.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }
        function streams($file){
            $existed = in_array("var", stream_get_wrappers());
            if ($existed) {
                stream_wrapper_unregister("var");
            }
            stream_wrapper_register("var", "VariableStream");
            $myvar = "";

            $fp = fopen("var://myvar", "r+");

            fwrite($fp, "line1\n");
            fwrite($fp, "line2\n");
            fwrite($fp, "line3\n");

            rewind($fp);
            while (!feof($fp)) {
                echo fgets($fp);
            }
            fclose($fp);
            var_dump($myvar);

            if ($existed) {
                stream_wrapper_restore("var");
            }
        }

        function md_filesystem($directoryPath){
            //$directoryPath = '/path/to/your/directory';

            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($directoryPath, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $fileinfo) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }

            rmdir($directoryPath);
        }
        */
    }