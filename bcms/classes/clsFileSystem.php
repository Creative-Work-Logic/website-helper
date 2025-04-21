<?php

    class clsFileSystem{
        use trtBasic;
        
        var $all_os_type=array("Linux","Windows","DB");
        var $current_os_type="Linux";
        var $os_class=array();
        var $current_os_class=false;

        function __construct(){
			
			$this->os_class[$all_os_type[0]]=new clsFileSystem_Linux();
            $this->os_class[$all_os_type[1]]=new clsFileSystem_Windows();
            $this->os_class[$all_os_type[2]]=new clsFileSystem_DB();
		}

        public function choose_current_os($os_type){
            $this->current_os_type="Linux";
            $this->current_os_class=$this->os_class[$this->current_os_type];
		}

        public function create_file($name,$contents){
            $return=false;
            $this->current_os_class->create_file($name,$contents);
			return $return;
		}

        public function open_file($file,$type){
            $return=false;
            $this->current_os_class->open_file($file,$type);
			return $return;
		}

        public function read_file($file){
            $return=false;
            
            $this->current_os_class->read_file($file);
			return $return;
		}

        public function write_file($file,$contents){
            $return=false;
            $this->current_os_class->write_file($file,$contents);
			return $return;
		}

        public function file_details($file){
            $return=false;
            $this->current_os_class->file_details($file);
			return $return;
		}

        

        public function delete_file($file){
			
			$return=false;
            $this->current_os_class->delete_file($file);
			return $return;
		}

        public function rename_file($from,$to){
			$return=false;
            $this->current_os_class->rename_file($from,$to);
			return $return;
		}

        public function copy_file($from,$to){
            $return=false;
            $this->current_os_class->copy_file($from,$to);
			return $return;
		}

        public function include_file($file){
			$return=false;
            $this->current_os_class->include_file($file);
			return $return;
		}

        public function check_file_exists($file){
			$return=false;
            $this->current_os_class->check_file_exists($file);
			return $return;
		}

        public function check_file_all_clear($file){
			$return=false;
            $this->current_os_class->check_file_all_clear($file);
			return $return;
		}

        public function move_file(){
			$return=false;
            $this->current_os_class->move_file();
			return $return;
		}

        
    }

