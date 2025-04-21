<?php

    class clsFileSystem{
        use trtBasic;
         
        function __construct(){
			
			
		}

        public function open_file($file,$type){
            $return=false;
            if($this->check_file_all_clear($file)){
                $handle = fopen($file, $type);
                $return=$handle;
            }else{
                $return=false;
            }
			return $return;
		}

        public function read_file($file){
            $return=false;
            $handle =$this->open_file($file,"r");
            $contents = fread($handle, filesize($filename));
            fclose($handle);
			return $contents;
		}

        public function write_file($file,$contents){
            $return=false;
            $handle =$this->open_file($file,"w");
            fwrite($handle, $contents);
            fclose($handle);
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
            if($this->check_file_all_clear($file)){
                
                  unlink($file);
                    
            }else{
                $return=false;
            }
			return $return;
		}

        public function rename_file($from,$to){
			
			
            $return=false;
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
			return $return;
		}

        public function copy_file($from,$to){
            $return=false;
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
			return $return;
			
		}

        public function include_file($file){
			$return=false;
            if($this->check_file_all_clear($file)){
                include($file);
                $return=true;
            }else{
                $return=false;
            }
			return $return;
		}

        public function check_file_exists($file){
			
			$return=false;

            if (file_exists($file)) {
                $return=true;
            } else {
                $return=false;
            }
            return $return;
		}

        public function check_file_all_clear($file){
			
			$return=false;

            if ($this->check_file_exists($file)){
                $return=true;
            } else {
                $return=false;
            }

            return $return;
		}

        public function move_file(){
			
			
		}

        

        public function write_file(){
			
			
		}
        
    }

