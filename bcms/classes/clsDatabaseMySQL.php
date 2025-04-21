<?php
    class clsDatabaseMySQL{
		use trtBasic;


        private $DB=array();

        private $Current_DB="";

        private $Current_DB_List=array();
        private $links;

        private $result;

        private $log=array();

        private $SQL="";
		
        function __construct(){
			
		}

       

        
		//-----------------------------------------------------------------------------------------------------------
		
		
		private function Set_Log(&$log){
			$this->log=$log;
			//$this->log->general('-Set Log Boot Success: $r->'.var_export($log,true),3);
		}

        private function Set_Links($links=false){
			if($links[$this->Current_DB]){
				$this->links[$this->Current_DB]=$links;
			}else{
			}
		}
		private function Get_Links(){
            
			if(!$this->links[$this->Current_DB]){
				return false;
			}else{
				return $this->links[$this->Current_DB];
			}
		}
		private function Set_Result($result=false){
			$this->result=$result;
			
		}
		private function Get_Result(){
			if(!$this->result){
				return false;
			}else{
				return $this->result;
			}
		}

        public function Connect($DB){
			$return_array=array();
			
			try{
				
					$TArr=$DB['db_server_id'];
					//$this->log->general("DB Login ",9,$DB);
					
					$host=$DB['hostname'].":".$DB['port'];
					$usernamedb=$DB['usernamedb'];
					$passworddb=$DB['passworddb'];
					$dbName=$DB['dbName'];
					print("\n host: ".$host." \n".$usernamedb." \n".$passworddb." \n".$dbName." \n");
					$links = new mysqli($host, $usernamedb,$passworddb,$dbName);
					if($links->connect_error) {
						//print("Connection failed: " . $links->connect_error);
					}else{
						//print("Connected successfully: " .var_export($DB,true));
					}
					$this->Current_DB=$TArr;
					$this->links[$TArr]=$links;
                    $this->Current_DB_List[]=$TArr;
					$return_array=$this->links[$TArr];
				
			}catch(Exception $e){
				
				$this->links[$TArr]=&$this->links[$this->original_server_tag];
				$TArr=$this->original_server_tag;
				//echo"\n\n<br>-110001----------".$TArr."------------".var_export($this->links[$TArr],true)."-------------------------------------";
				exit("Connect Error-1");
				//unset($this->links[$TArr]);
			}
			
			return $return_array;
		}

        public function rawQuery($query="",$link=false)
		{
			$result=false;
			if($query!=""){
				$this->SQL=$query;
				if(!$link){
					$link=$this->Get_Links();
				}
				try{
					if($link){
						$result = $link->query($query);
					}else{
					}
					if(!$result){
						//$this->log->general("No MySQL Result->".$query,9);
						return false;
					}else{
					}
				}catch(Exception $e){
					//$this->log->general("MySQL Exception->".var_export($e,true)." ".$query,3);
				}
			}else{
			}
			return $result;
		}
		
		public function NumRows($result=false){
			if(!$result){
				$result=$this->Get_Result();
			}
			$link=$this->Get_Links();
			$num_rows=0;
			if($result){
				try{
					$num_rows=0;
					$num_rows=$result->num_rows;
				}catch(Exception $e){
					//$this->log->general("MySQL NumRows Exception->".var_export($e,true)." ".$this->SQL,3);
					return 0;
				}
			}
			$this->num_rows=$num_rows;
            return $num_rows;
		}

        public function Fetch_Array($result=false)
		{
			$row=array();
			if(!$result) $result=$this->Get_Result();
            if($result){
				$row = $result->fetch_array(MYSQLI_NUM);
				if(is_array($row)){
					if(count($row)>0){
					}else{
						$row=array();
					}
				}else{
					$row=array();
				}
			}else{
				$row=array();
			}
			return $row;
		}
		
		public function Fetch_Assoc($result=false)
		{
			$row=array();
			if(!$result) $result=$this->Get_Result();
			if($result){
				$row = $result->fetch_array(MYSQLI_ASSOC);
				if(is_array($row)){
					return $row;
				}else{
					$row=array();
				}
			}else{
                $row=array();
			}
			return $row;
		}

		public function Fetch_Both($result=false)
		{
			//echo"fff-----------------------------------------------------------------------------";
			$row=array();
			$row = $result->fetch_array(MYSQLI_BOTH);
			return $row;
		}

        //===================================================================

        private function mb_escape(string $string)

		{
	
			return preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', $string);
	
		}
		
		
		public function Escape($string)
		{
			//echo"20-----------------------------------------------------------".var_export($this->links,true)."------------------";
			
			if(isset($string)){
				if(strlen($string)>0){
					if($this->links){
						$st = $this->links->real_escape_string($string);
					}else{
						$st="";
					}
					
				}else{
					$st="";
				}
			}else{
				$st="";
			}
			
			return $st;
			
		}
		
		public function Insert_Id(){
			try{
				$InsertID = $this->links->insert_id;
				return $InsertID;
			}catch(ErrorException $e){
				//$this->log->general("-Insert_Id failed--".var_export($e,true),3);
			}
		}
    }