<?php
    class clsDatabasePGSql{
		use trtBasic;

        private $DB=array();

        private $Current_DB="";
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
            $TArr=$DB['db_server_id'];
            $this->DB[$DB['db_server_id']]=$DB;
			$db_login=$DB;//$this->server_login[$TArr];
			/*
			$DB['server_tag']="db-pgSQL.php";
			$this->current_server_tag=$DB['server_tag'];
			$TArr=$this->current_server_tag;
			*/
			$login_txt = "host=".$db_login['hostname']." dbname=".$db_login['dbName'];
			$login_txt.=" user=".$db_login['usernamedb']." password=".$db_login['passworddb'];
			
			$db = pg_connect($login_txt);// die('Could not connect: ' . pg_last_error("db-errror"));
			$this->links[$TArr]=$db;
			$this->Current_DB_List[]=$TArr;
			$this->Current_DB=$TArr;
			return $this->links[$TArr];
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
						$result = pg_query($query);
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
					$num_rows = pg_num_rows($result);
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
				$row =pg_fetch_array($result);
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
				$row =pg_fetch_assoc($result);
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
			$row=pg_fetch_array($result,Null,PGSQL_BOTH);
			return $row;
		}
        //===================================================================

        function mb_escape(string $string)

		{
	
			return preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', $string);
	
		}
		
		
		function Escape($string)
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
		
		function Insert_Id(){
			try{
				$InsertID = $this->links->insert_id;
				return $InsertID;
			}catch(ErrorException $e){
				//$this->log->general("-Insert_Id failed--".var_export($e,true),3);
			}
		}
    }