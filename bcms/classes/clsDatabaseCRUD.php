<?php
    class clsDatabaseCRUD{
		use trtBasic;

		public function __construct(){
            //print "\n start now \n";
            //$this->Update_All_Vars();
		}
        //=================================================================================================
		//public function Exec_Create($array_type="Assoc",$table_name="",$columns_array=array()){
		/*
			public function Exec_Create($array_type,$table_name,$columns_array){
				//$query_type="Create";
	
				//$columns_array
				//$table_name
				//$query_type
				//$array_type
				//$max_rows
				//$page_number
	
				$specific_columns=array();
				$order_by="";
				$max_rows=0;
				$page_number=0;
	
				//$sql="INSERT (".$retrieve_list.") INTO  ".$table_name." VALUES  (".$values_list.")";
	
				return $this->Execute_Database_Query($array_type,$query_type,$table_name,$columns_array,$specific_columns,$order_by,$max_rows,$page_number);
			}
				*/
		public function Exec_Create($query_type="Create",$array_type="Assoc",$table_name="",$columns_array=array()){
			//$query_type="Create";
			$specific_columns=array();
			$order_by="";
			$max_rows=0;
			$page_number=0;
			if($table_name!=""){
				return $this->Execute_Database_Query($query_type,$table_name,"Assoc",$columns_array);
			}else{
				return false;
			}
			
			//return $this->Execute_Database_Query($array_type,$query_type,$table_name,$columns_array,$specific_columns,$order_by,$max_rows,$page_number);
		}
		
		public function Exec_Retrieve($table_name,$array_type="Assoc",$retrieve_columns=array("*"),$where_array=array(),$order_by="",$max_rows=0,$page_number=1){
			//print "\n whatnow xxx \n";
			if(!isset($this->db)){
				$this->Update_All_Vars();
			}
			//
			//print "\n whatnow xxx2 \n";
			/*
			$numargs = func_num_args();
			$arg_list = func_get_args();
			for ($i = 0; $i < $numargs; $i++) {
				if(is_array($arg_list[$i])){
					echo "Argument $i is array: " . var_export($arg_list[$i],true) . "\n";
				}else{
					echo "Argument $i is: " . $arg_list[$i] . "\n";
				}
				
			}
			*/
			//$this->Update_All_Vars();
			
			

			$query_type="Retrieve";
			$where_list="";
			
			
			if(is_array($where_array)){
				$acount=0;
				foreach($where_array as $key=>$val){
					if($acount==0){
						//$where_list.=" WHERE ".implode("=",$val);
						$where_list.=" WHERE ".$key."='".$val."'";
					}else{
						//$where_list.=" AND '".implode("'='",$val)."'";
						$where_list.=" AND ".$key."='".$val."'";
					}
					$acount++;
				}
				
			}
			//print_r($where_list);

			if(is_array($retrieve_columns)){
				$retrieve_list=implode(",",$retrieve_columns);
			}else{
				$retrieve_list="";
			}
			$order_by_sql="";
			if($order_by!=""){
				$order_by_sql=" ORDER BY ".$order_by;
			}
			
			//$max_rows=0;
			//$page_number
			if($max_rows>0){
				$sql_limits="LIMIT ".($page_number*$max_rows).",".$max_rows;
			}else{
				$sql_limits="";
			}
			
			$sql="SELECT ".$retrieve_list." FROM ".$table_name." ".$where_list." ".$order_by_sql." ".$sql_limits;

			//print "\n whatnow what ".$sql." \n";
            $return_array=array();
            //$rslt=$this->cls->clsDatabaseFactory->rawQuery($sql);
			$rslt=$this->db->rawQuery($sql);
			$NumRows=$this->db->NumRows($rslt);

			//print "\n where is ".$sql."-".$NumRows." \n";
			/*
			if($rslt){
				//$this->db->Set_Result($rslt);
				
				$NumRows=$this->db->NumRows($rslt);
				print "\n all rows=>".$NumRows;
			}
				*/
            //$this->rslt=$this->Database_Raw_Query($sql);
			if($NumRows>0){
				if($array_type=="Assoc"){
					$return_array=$this->db->Fetch_Multi_Assoc($rslt);
					//print_r($return_array);
					/*
					while($myrow=$this->db->Fetch_Assoc($rslt)){
						$return_array[]=$myrow;
					}
					*/
				}else{

					$return_array=$this->db->Fetch_Multi_Array($rslt);
					/*
					while($myrow=$this->db->Fetch_Array($rslt)){
						$return_array[]=$myrow;
					}
						*/
				}
				
				//print_r($return_array);
			}else{
				if($array_type=="Assoc"){
					$return_array=$this->db->Fetch_Assoc($rslt);
				}else{
					$return_array=$this->db->Fetch_Array($rslt);
				}
			}
			
			//print " \n cool ".$sql." \n";
			$sql="SELECT COUNT(*) AS Total FROM ".$table_name." ".$where_list;
			$rslt=$this->db->rawQuery($sql);
			$return=$this->db->Fetch_Assoc($rslt);
			$return_array['details']['Total_Rows']=$return['Total'];
			
            
            //print "\n ra=>".var_export($return_array,true);

			//print "<=end | \n ";
            //print_r("ggg=> \n");
            return $return_array;
			
			//return $this->Execute_Database_Query($array_type,$query_type,$table_name,$retrieve_columns,$where_array,$order_by,$max_rows,$page_number);
		}

		public function Exec_Delete($table_name,$array_type="Assoc",$columns_array=array(),$specific_columns=array()){
			$query_type="Delete";
			/*
			,$order_by="id",$max_rows=0,$page_number=1

			if($specific_list!=""){
				$where_list=" WHERE ".$specific_list;
			}else{
				$where_list="";
			}
			$sql="DELETE FROM ".$table_name." ".$where_list;
			*/

			$order_by="";
			$max_rows=0;
			$page_number=0;

			return $this->Execute_Database_Query($array_type,$query_type,$table_name,$columns_array,$specific_columns,$order_by,$max_rows,$page_number);
		}

		public function Exec_Update($table_name,$array_type="Assoc",$columns_array=array(),$specific_columns=array()){
			$query_type="Update";
			/*
			,$order_by="id",$max_rows=0,$page_number=1
			$sql="UPDATE ".$table_name." SET ".$values_list." WHERE  ".$specific_list;
			*/

			$order_by="";
			$max_rows=0;
			$page_number=0;
			return $this->Execute_Database_Query($array_type,$query_type,$table_name,$columns_array,$specific_columns,$order_by,$max_rows,$page_number);
		}

		//============================================================================

		public function Execute_Database_Query($query_type,$table_name,$array_type="Assoc",$columns_array=array(),$specific_columns=array(),$order_by="id",$max_rows=0,$page_number=1){
            $update_list="*";
			$specific_list="";
			$values_list="";
			$retrieve_array=array();
			$insert_values=array();
			foreach($specific_columns as $key=>$val){
				$specific_list.=$val['name']."='".$val['value']."'";
			}
			//print_r($columns_array);
			if(count($columns_array)>0){
				foreach($columns_array as $key=>$val){
					$retrieve_array[]=$key;
					$insert_values[]=$val;
					$values_list.="'".$key."'='".$val."'";
				}
			}
			$retrieve_list="*";
            if(count($retrieve_array)>0){
              $retrieve_list=implode("','",$retrieve_array);
            }
			$values_list="";
			if(count($insert_values)>0){
				$values_list=implode("','",$insert_values);
				$values_list="'".$values_list."'";
			}
            $order_by_sql=" ORDER BY ".$order_by;
            if($max_rows>0){
                $sql_limits=" LIMIT 0,10";
            }else{
                $sql_limits="";
            }
			
            switch($query_type){
				case "REPLACE":
					$sql="REPLACE INTO  ".$table_name." ('".$retrieve_list."')  VALUES  (".$values_list.");";
					
				break;
				case "Create":
					$sql="INSERT INTO  ".$table_name." ('".$retrieve_list."')  VALUES  (".$values_list.");";
				break;
				case "Retrieve":
					if($specific_list!=""){
						$where_list=" WHERE ".$specific_list;
					}else{
						$where_list="";
					}
					
					$sql="SELECT ".$retrieve_list." FROM ".$table_name." ".$where_list." ".$order_by_sql." ".$sql_limits;
				break;
				case "Update":
					$sql="UPDATE ".$table_name." SET ".$values_list." WHERE  ".$specific_list;
				break;
				case "Delete":
					if($specific_list!=""){
						$where_list=" WHERE ".$specific_list;
					}else{
						$where_list="";
					}
					$sql="DELETE FROM ".$table_name." ".$where_list;
				break;
			}
            //print($sql);
            
            $return_array=array();
            $rslt=$this->db->rawQuery($sql);
			print($sql);
			if($rslt){
				$this->db->Set_Result($rslt);
			}
			//print_r($rslt);
			switch($query_type){
				case "Replace":
				case "Create":
					$return_array["new_insert_id"]=$this->db->Insert_Id();
				break;
				case "Retrieve":
					if($array_type=="Assoc"){
						while($myrow=$this->db->Fetch_Assoc($rslt)){
							$return_array[]=$myrow;
						}
					}else{
						while($myrow=$this->db->Fetch_Array($rslt)){
							$return_array[]=$myrow;
						}
					}
				break;
				
			}

            //$this->rslt=$this->Database_Raw_Query($sql);
			
            
            //print_r($return_array);
            //print_r("ggg=> \n");
            return $return_array;
          }

    }