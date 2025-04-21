<?php

    class clsDatabaseFactory{
        use trtBasic;

        private $DB=array();
        private $Databases=array();

        private $Current_Database="";
        private $result=null;

        
        function __construct(){
            //echo "x-456";
            //$this->set_database();
            //echo "yy-456";
		}

        public function export_data(){
            $output=array($this->DB,$this->Databases,$this->Current_Database,$this->result);   
            print_r($output);
        }

        

        public function set_database($db_server_id){
            $this->Current_Database=$db_server_id;
        }

        public function add_database($DB){
            
            //echo"kkk";
            
            //$this->get_globals();
            $this->Current_Database=$DB['db_server_id'];
			$this->DB[$this->Current_Database]=$DB;
            
            //print_r($this->DB);

            switch($this->DB[$this->Current_Database]['server_type']){
                case "MySQL":
                    //$new_db=new clsDatabaseMySQL();
                    $new_db=clsClassFactory::$cf_cls->Add_Class("clsDatabaseMySQL");
                break;
                case "Sqlite":
                    $new_db=clsClassFactory::$cf_cls->Add_Class("clsDatabaseSQLite3");
                    //$new_db=new clsDatabaseSQLite3();
                break;
                case "pgSQL":
                    //$new_db=new clsDatabasePGSql();
                    $new_db=clsClassFactory::$cf_cls->Add_Class("clsDatabasePGSql");
                break;
            }

            

            $this->Databases[$this->Current_Database]=$new_db;
            $this->Databases[$this->Current_Database]->Connect($DB);

            //echo"\n--213456---Class=>".__CLASS__."--Method=>".__METHOD__."---this->var-\n-".var_export($this->var,true)."--\n---------------\n";
           

		}

        public function rawQuery($query="")
		{
            if($query!=""){
                
                if(isset($this->Databases[$this->Current_Database])){
                    //echo "\n 64321-just".var_export($this->Databases[$this->Current_Database],true)." \n";
                    $this->result=$this->Databases[$this->Current_Database]->rawQuery($query);
                    //print_r($this->result);
                    return $this->result;//$this->Databases[$this->Current_Database]->rawQuery($query);
                }
                
            }
			
		}
		
		public function NumRows($result=null){
            if(is_null($result)){
				$result=$this->result;
			}
            if(isset($this->Databases[$this->Current_Database])){
			    return $this->Databases[$this->Current_Database]->NumRows($result);
            }
		}

        public function Fetch_Array($result=null)
		{
            if(is_null($result)){
				$result=$this->result;
			}
			return $this->Databases[$this->Current_Database]->Fetch_Array($result);
		}
		
		public function Fetch_Assoc($result=null)
		{
            if(is_null($result)){
				$result=$this->result;
			}
			return $this->Databases[$this->Current_Database]->Fetch_Assoc($result);
		}

		public function Fetch_Both($result=null)
		{
            if(is_null($result)){
				$result=$this->result;
			}
			return $this->Databases[$this->Current_Database]->Fetch_Both($result);
		}
		function Escape($string)
		{
			
			return $this->Databases[$this->Current_Database]->Escape($string);
			
		}
		
		function Insert_Id(){
			return $this->Databases[$this->Current_Database]->Insert_Id();
		}

        public function Set_Result($result=false){
			$this->result=$result;
		}

        public function Retrieve_all_tables($result=false){
			$return_array =$this->Databases[$this->Current_Database]->Retrieve_all_tables();
			return $return_array;
		}

        public function Retrieve_table_info($result=false){
			$return_array =$this->Databases[$this->Current_Database]->Retrieve_table_info();
			return $return_array;
		}
    }