<?php

    class clsFileSystem_DB{
        use trtBasic;
         
        function __construct(){
			
			//$this->cls->clsDatabaseCRUD->Exec_Create("REPLACE","Assoc","list_classes",array("id"=>$count,"class_name"=>$val));
		}

        public function create_file($name,$contents){
            $return=false;
            $return=$this->cls->clsDatabaseCRUD->Exec_Create("REPLACE","Assoc","File_Engine",array("Name"=>$name,"Contents"=>$contents));
			return $return;
		}

        public function open_file($file,$type){
            $return=false;
            /*
            if($this->check_file_all_clear($file)){
                $handle = fopen($file, $type);
                $return=$handle;
            }else{
                $return=false;
            }
                */
			return $return;
		}

        public function read_file($file){
            $return=false;
            /*
            $handle =$this->open_file($file,"r");
            $contents = fread($handle, filesize($filename));
            fclose($handle);
            */
            $contents=$this->cls->clsDatabaseCRUD->Exec_Retrieve("File_Engine","Assoc",array("id"),array("Name"=>$file));
            
            
			return $contents;
		}

        public function write_file($file,$contents){
            $return=false;
            /*
            $handle =$this->open_file($file,"w");
            fwrite($handle, $contents);
            fclose($handle);
            */
            $return=$this->cls->clsDatabaseCRUD->Exec_Update("File_Engine","Assoc",array("Contents"=>$contents),array("Name"=>$file));
            return $contents;
		}

        public function file_details($file){
            $return=false;
            if($this->check_file_all_clear($file)){
                
                $lines = file($file);
                $return=$lines;
            }else{
                $return=false;
            }
			return $return;
		}

        

        public function delete_file($file){
			
			$return=false;
            /*
            if($this->check_file_all_clear($file)){
                
                  unlink($file);
                    
            }else{
                $return=false;
            }
                */
            $return=$this->cls->clsDatabaseCRUD->("File_Engine","Assoc",array("Contents"=>$contents),array("Name"=>$file));
			return $return;
		}

        public function rename_file($from,$to){
			
			
            $return=false;
            /*
            if($this->check_file_all_clear($from)){
                if($this->check_file_all_clear($to)){
                    rename($from,$to);
                    $return=true;
                }else{
                    $return=false;
                }
            }else{
                $return=false;
            }
                */
			return $return;
		}

        public function copy_file($from,$to){
            $return=false;
            /*
            if($this->check_file_all_clear($from)){
                if($this->check_file_all_clear($to)){
                    if (!copy($from, $to)) {
                        $return=false;
                    }else{
                        $return=true;
                    }
                }else{
                    $return=false;
                }
            }else{
                $return=false;
            }
                */
			return $return;
			
		}

        public function include_file($file){
			$return=false;
            /*
            if($this->check_file_all_clear($file)){
                include($file);
                $return=true;
            }else{
                $return=false;
            }
                */
			return $return;
		}

        public function check_file_exists($file){
			
			$return=false;
            /*
            if (file_exists($file)) {
                $return=true;
            } else {
                $return=false;
            }
                */
            return $return;
		}

        public function check_file_all_clear($file){
			
			$return=false;
            /*
            if ($this->check_file_exists($file)){
                $return=true;
            } else {
                $return=false;
            }
            */
            return $return;
		}

        public function move_file(){
			
			
		}
        
    }

