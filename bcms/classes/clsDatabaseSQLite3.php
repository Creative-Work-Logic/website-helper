<?php
    class clsDatabaseSQLite3{
        use trtBasic;

        private $DB=array();

        private $Current_DB="";

		private $Current_DB_List="";
        private $links;

		private $num_rows;

        private $result;

        //private $log=array();

        private $SQL="";
		
        function __construct(){
			
		}
		//-----------------------------------------------------------------------------------------------------------
		
		
		private function Set_Log(&$log){
			//$this->log=$log;
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
            $this->DB[$DB['db_server_id']]=$DB;
			//$DB['server_tag']="db-sqlite3.php";
			$TArr=$DB['db_server_id'];
			//$this->current_server_tag=$DB['server_tag'];
			//$TArr=$this->current_server_tag;
			//$server_login[$DB['server_tag']]=array();
			//print "\n yousqluite \n\n";
			$db = new SQLite3($DB['dbName']);
			$this->links[$TArr]=$db;
			//$this->Current_DB_List[]=$TArr;
            $this->Current_DB=$TArr;
			return $this->links[$TArr];
		}

        public function rawQuery($query="",$link=false)
		{
            //print "\n you".$query." \n\n";
			$result=false;
			if($query!=""){
				$this->SQL=$query;
				if(!$link){
					$link=$this->Get_Links();
				}
				try{
					if($link){
						$result = $link->query($query);
						//print "\n just 11 query =>".var_export($result,true)."\n\n";
						$this->result=$result;
						$rows=$this->NumRows($result);
						
						if($result){
							$this->Set_Result($result);
						}else{
							print "\n failed query =>".$query." \n\n";
						}
                        
					}else{
					}
					if(!$result){
						////$this->log->general("No MySQL Result->".$query,9);
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
					//$result->reset();
                    $nrows = 0;
                    while ($this->Fetch_Array($result)){
                        $nrows++;
                    }
                    //$result->reset();
                    $num_rows=$nrows;
				}catch(Exception $e){
					//$this->log->general("MySQL NumRows Exception->".var_export($e,true)." ".$this->SQL,3);
					return 0;
				}
			}
			//print "\n xx rows=>".$num_rows;
			//print "<=end | sql=>".$this->SQL. "<= \n";
			$this->num_rows=$num_rows;
            return $num_rows;
		}

        public function Fetch_Array($result=false)
		{
			$row=array();
			if(!$result) $result=$this->Get_Result();
            if($result){
				//$row = $result->fetchArray(SQLITE3_NUM);
				//$link->query($query);
				$link=$this->Get_Links();
				$row = $this->result->fetchArray(SQLITE3_NUM);
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
			$return_array=array();
			if(!$result) $result=$this->Get_Result();
			if($result){
				$link=$this->Get_Links();
				//$row = $this->FetchArray(SQLITE3_ASSOC);
				$row = $this->result->fetchArray(1);
				//print_r($row);
				$return_array=$row;
				
				
				if(is_array($return_array)){
					return $return_array;
				}else{
					$return_array=array();
				}
				
			}else{
                $return_array=array();
			}
			//print_r($return_array);
			return $return_array;
		}

		public function Fetch_Both($result=false)
		{
			//echo"fff-----------------------------------------------------------------------------";
			$row=array();
			$row = $this->FetchArray(SQLITE3_BOTH);
			return $row;
		}

        //===================================================================

        function mb_escape(string $string)

		{
	
			return preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', $string);
	
		}
		
		
		public function Escape($string)
		{
			//echo"20-----------------------------------------------------------".var_export($this->links,true)."------------------";
			
			if(isset($string)){
				if(strlen($string)>0){
					if($this->links){
						$st = $this->mb_escape($string);
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
		
		function Insert_Id($result=false){
			/*
			try{
				//$InsertID = $this->links->insert_id;
				$InsertID = $this->links->lastInsertRowID();
				return $InsertID;
			}catch(ErrorException $e){
				//$this->log->general("-Insert_Id failed--".var_export($e,true),3);
			}
			*/
			$row=array();
			$return_array=array();
			if(!$result) $result=$this->Get_Result();
			if($result){
				$row = $result->lastInsertRowID();
				//print_r($row);
				$return_array=$row;
				
				
				if(is_array($return_array)){
					return $return_array;
				}else{
					$return_array=array();
				}
				
			}else{
                $return_array=array();
			}
			//print_r($return_array);
			return $return_array;
		}

		public function Fetch_Multi_Assoc($result=null)
		{
			if(is_null($result)){
				$result=$this->result;
			}
			$row=array();
			$return_array=array();
			//while($row=$this->cls->clsDatabaseFactory->Fetch_Assoc()){
			while($row=$this->Fetch_Assoc($result)){
				
				$return_array[]=$row;
			}
			return $return_array;
		}

		public function Fetch_Multi_Array($result=null)
		{
			if(is_null($result)){
				$result=$this->result;
			}
			$row=array();
			$return_array=array();
			//while($row=$this->cls->clsDatabaseFactory->Fetch_Assoc()){
			while($row=$this->Fetch_Array($result)){
				
				$return_array[]=$row;
			}
			return $return_array;
		}

		public function Retrieve_all_tables($result=false){
			$return_array=array();
			$link=$this->Get_Links();
			$query='SELECT name FROM sqlite_master WHERE type="table" ORDER BY name';
			$result=$this->rawQuery($query,$link);
			$return_array=$this->Fetch_Multi_Array($result);
			//print_r($return_array);
            return $return_array;
		}

		public function Retrieve_table_info($result=false){
			$table_name="assets";
			$return_array=array();
			$link=$this->Get_Links();
			$query='PRAGMA table_info('.$table_name.');';
			$result=$this->rawQuery($query,$link);
			$return_array=$this->Fetch_Multi_Array($result);
			//print_r($return_array);
            return $return_array;
		}
        
    }