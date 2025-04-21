<?php

class clsDatabaseInterface{
	use trtBasic;

		var $SQL;
		var $Table;
		var $TargetField="id";
		var $SearchVar;
		var $NewSearchVar=array();
		public $m;
		//var $vs;
		var $links=false;
		var $result;
		var $DBFile="db-local.php";
		var $default_db="bubblelite2";
		//public $log="";
		var $log_text="";
		var $db_type_list=array("MySQL","Sqlite","pgSQL");
		private $server_db_list=array();
		//var $current_db_type="MySQL";
		var $current_db_type="Sqlite";
		//var $current_db_type="pgSQL";
		var $num_rows=0;
		var $Retreive_All_Variables=false;
		var $app_data=array();

		private $DB_Factory;

		var $server_name="Hostgator Cloud";
		
        function __construct(){
			//$this->cls=&clsClassFactory::$cf_cls;
            //print_r($this->cls);
			//echo "\n 11-xx \n";
			
            $this->get_database_details();
			
			//echo "\n 1777-xx \n";
            
		}

        

		

        
		/*
		public function Add_App_Data(&$app_data){
			
			$this->app_data=$app_data;
		}
		
		
		public function Set_Log(&$log=null){
			$this->log=clsClassFactory::$cf_all_vars['log']->get_object();
			//$this->log->general('M Log Success:',1);
		}
		
		public function Set_Vs(&$vs=false){
			$this->vs=$vs;
		}
		*/
		public function Set_Links($links=false){
			if($links){
				$this->links=$links;
			}else{
			}
		}
		public function Get_Links(){
			if(!$this->links){
				return false;
			}else{
				return $this->links;
			}	
		}
		public function Set_Result($result=false){
			$this->result=$result;
		}
		public function Get_Result(){
			if(!$this->result){
				return false;
			}else{
				return $this->result;
			}
		}
		
		public function get_database_details(){
			//print"\n 19988af \n";
			$this->Update_Globals();
			
			//echo "\n 1122777-hello \n";
			$file_return = "";//include "bcms/classes/db.php";
			$load_file="./bcms/classes/db.php";
			if (file_exists($load_file)) {
				
				//echo "\n File Exits \n";
				$file_return = include ($load_file);
				$this->server_db_list=$server_DB_list;
				
				//$this->var=array();
				$this->var['database']=array();
				$this->var['database']['db']=array();
				
				foreach($this->server_db_list as $key=>$val){
					
					$this->var['database']['db'][]=$val;
					//$this->cls->export_data();
					//print_r($this->cls);
					//$this->cls->clsDatabaseFactory->export_data();
					$this->cls->clsDatabaseFactory->add_database($val);
				}
				
				//echo "\n File Exits 2 \n";
				
			}else{
				echo "\n No File \n";
			}
				 
				return $file_return;
		}
		
		
		public function rawQuery($query="")
		{
			//echo "\n 666-xx".$query." \n";
			//$this->log->add_tag("DB Interface raw query");
			if($query!=""){
				//$this->log->add_sql_command($query);
				//$this->log->add_sql_command($query);
				$this->SQL=$query;
				$this->result=$this->cls->clsDatabaseFactory->rawQuery($query);
				//$this->log->add_array($this->result);
				//print_r($this->result);
			}else{
				$this->log->add_error("Error No SQL");
				$this->result="Error No SQL";
			}
			
			return $this->result;
		}
		/*
		public function RawQuery($query="")
		{
			echo "\n 12666-xx".$query." \n";
			$result=false;
			if($query!=""){
				
				$result=$this->rawQuery($query);
				//print_r($this->result);
			}else{
				$result="Error No SQL";
			}
			
			return $result;
		}
		*/
		public function NumRows($result=null){
			if(is_null($result)){
				$result=$this->result;
			}
			$num_rows=$this->cls->clsDatabaseFactory->NumRows($result);
			$this->num_rows=$num_rows;
			return $num_rows;
		}
		
		public function Fetch_Array($result=null)
		{
			if(is_null($result)){
				$result=$this->result;
			}
			$row=array();
			$row=$this->cls->clsDatabaseFactory->Fetch_Array($result);
			return $row;
		}
		
		public function Fetch_Assoc($result=null)
		{
			if(is_null($result)){
				$result=$this->result;
			}
			$row=array();
			$row=$this->cls->clsDatabaseFactory->Fetch_Assoc($result);
			//print "\n row->".var_dump($row,true)."\n |".$this->SQL." \n";	
			return $row;
		}

		public function Fetch_Both($result=null)
		{
			if(is_null($result)){
				$result=$this->result;
			}
			$row=array();
			$row=$this->cls->clsDatabaseFactory->Fetch_Both($result);
			return $row;
		}

		public function Fetch_Multi_Array($result=null)
		{
			if(is_null($result)){
				$result=$this->result;
			}
			$row=array();
			$return_array=array();
			while($row=$this->cls->clsDatabaseFactory->Fetch_Array($result)){
				$return_array[]=$row;
			}
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
			while($row=$this->cls->clsDatabaseFactory->Fetch_Assoc($result)){
				
				$return_array[]=$row;
			}
			return $return_array;
		}
		
		public function Error($result=null)
		{
			$return_error=false;
			$link=$this->Get_Links();
			if (!$link) {
				$return_error=mysqli_connect_error();
				return $return_error;
			}else{
				return $return_error;
			}
		}
		
		public function Escape($string)
		{
			$st=$this->cls->clsDatabaseFactory->Escape($string);
			return $st;
		}
		
		public function Insert_Id(){
			$InsertID =$this->cls->clsDatabaseFactory->Insert_Id();
			return $InsertID;
		}

		public function Retrieve_all_tables($result=false){
			$return_array =$this->cls->clsDatabaseFactory->Retrieve_all_tables();
			return $return_array;
		}

		public function Retrieve_table_info($result=false){
			$return_array =$this->cls->clsDatabaseFactory->Retrieve_table_info();
			return $return_array;
		}

		
		
	}