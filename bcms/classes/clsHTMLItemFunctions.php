<?php

    class clsHTMLItemFunctions{
        use trtBasic;
        //var $output="";

        function __construct(){
			
			
		}

        public function get_test($input_variables=array()){
           //print_r($input_variables);
			//return $this->call_method($input_variables['method'],$input_variables);
            $out="";
            $method=$input_variables['method'];
            $variables=$input_variables;
            if(is_string($method)){
                

                $out=$this->$method($variables);
            }else{
                print $method;
            }
            
            return $out;//$this->call_method($input_variables['method'],$input_variables);
		}

        public function call_method($method_name,$input_variables=array()){
            $this->output="";
			$this->output=call_user_func_array([$this, $method_name], $input_variables);
			return $this->output;
		}

        public function call_check_variables($input_variables=array(),$allowed_variables=array()){
            $config_details=array();
            $config=array();
            $default="";

            if(isset($input_variables['default'])){
                $default=$input_variables['default'];
            }else{
                $default="";
            }
            if(count($input_variables)>0){
                foreach($input_variables as $key=>$val){
                    if(in_array($key,$allowed_variables)){
                        $config[$key]=$val;
                    }
                }
            }
            
            $config_details=array("config"=>$config,"default"=>$default);
			return $config_details;
			
		}

        public function get_text_box($input_variables=array()){
            $this->output="";
            $allowed_variables=array('type','id','name');

            $checked_variables=$this->call_check_variables($input_variables,$allowed_variables);

            
            $this->output=$this->Create_TextBox($checked_variables["config"],$checked_variables["default"]);
			return $this->output;
			
		}

        public function get_languages($input_variables=array()){
			$this->output="";
            $table_name="";
            $default_item="";
            $table_where_variables=array();
            $database_return_values=array();
            $allowed_variables=array('type','id','name');

            $checked_variables=$this->call_check_variables($input_variables,$allowed_variables);
            if($checked_variables["default"]!=""){
                $default_item=$checked_variables["default"];
            }
            
            $where_array=array();
            $database_return_values=$this->get_database_lists("languages",$where_array);
            
            $this->output=$this->Create_DropDown($checked_variables["config"],$default_item,$database_return_values);
			return $this->output;
		}

        public function  get_servers($input_variables=array()){
			$this->output="";
            
			return $this->output;
		}

        public function  get_mirrors($input_variables=array()){
			$this->output="";
            
			return $this->output;
		}

        public function  get_clients($input_variables=array()){
			$this->output="";
            
			return $this->output;
		}

        public function get_templates($input_variables=array()){
			$this->output="";
            $table_name="";
            $default_item="";
            $table_where_variables=array();
            $database_return_values=array();
            $allowed_variables=array('type','id','name');

            $checked_variables=$this->call_check_variables($input_variables,$allowed_variables);
            if($checked_variables["default"]!=""){
                $default_item=$checked_variables["default"];
            }
            
            $where_array=array();
            $database_return_values=$this->get_database_lists("templates",$where_array,array("id","Name"));
            
            $this->output=$this->Create_DropDown($checked_variables["config"],$default_item,$database_return_values);
			return $this->output;
		}

        public function get_group_items($input_variables=array()){
            
			$this->output="";
            $table_name="";
            $default_item="";
            $table_where_variables=array();
            $database_return_values=array();
            //$allowed_variables=array("group_code",'type','id','name');
            $allowed_variables=array('type','id','name');

            $checked_variables=$this->call_check_variables($input_variables,$allowed_variables);
            if($checked_variables["default"]!=""){
                $default_item=$checked_variables["default"];
            }
            //print_r($checked_variables["config"]);
            $where_array=array("group_code"=>$input_variables["group_code"]);
            $database_return_group_values=$this->get_database_lists("list_multi_select_item_groups",$where_array);
            //print("\n id=>".$database_return_group_values['id']." \n");
            //print_r($database_return_group_values);
            $where_array=array("list_multi_select_item_groupsID"=>$database_return_group_values['id']);
            $database_return_values=$this->get_database_lists("list_multi_select_items",$where_array,array("id","item_label AS Name"));
            //print_r($database_return_values);
            $this->output=$this->Create_DropDown($checked_variables["config"],$default_item,$database_return_values);
			return $this->output;
			
		}

        public function get_page_lineage($input_variables=array()){
			
			$this->output="";
            $allowed_variables=array('type','id','name');

            $checked_variables=$this->call_check_variables($input_variables,$allowed_variables);

            $database_recursive_values=$this->get_page_lineage_recursive(0,"");
            //print_r($database_recursive_values);
            $this->output=$this->Create_DropDown($checked_variables["config"],$default_item,$database_recursive_values);
            //print $this->output;
			return $this->output;
		}

        public function get_page_lineage_recursive($parentID,$seperator){
			$database_return_items=array();
            if(is_numeric($parentID)){
                $domainsID=1580;//$this->var['domain']['db']['id'];
                    
                $this->output="";
                $seperator.="-";
                
                $database_return_values=array();
                $database_recursive_values=array();
                $where_array=array("parentID"=>$parentID,"domainsID"=>$domainsID);
                //$retrieve_values=array("id","Title","parentID","domainsID");
                $retrieve_values=array("id","Title");
                $database_return_values=$this->get_database_lists("content_pages",$where_array,$retrieve_values,"Sort_Order");
                foreach($database_return_values as $key=>$val){
                    if(isset($val['id'])){
                        if(is_numeric($val['id'])){
                            $val['Name']=$seperator.$val['Title'];
                            //print($val['id']);
                            //$database_return_items[] =array($val['id'],$seperator.$val['Title']);
                            $database_return_items[] =$val;
                            $database_recursive_values=$this->get_page_lineage_recursive($val['id'],$seperator);
                            $database_return_items=array_merge($database_return_items,$database_recursive_values);
                            //print_r($database_return_items);
                        }
                    }
                }
            }
            
			return $database_return_items;
		}

        public function get_links($input_variables=array()){
            /*
			'type'=>"a",'id'=>"edit_id",'name'="edit_name"
            ,"href"=>"/management-page-modify/id='.$searchID.'/","title"=>"edit"
            */

            $this->output="";
            $allowed_variables=array('type','id','name');

            $checked_variables=$this->call_check_variables($input_variables,$allowed_variables);
            
            //$targe_link=$this->clsLinks->Create_Local_Link("edit","1112");
            $targe_link=$this->cls->clsLinks->Create_Local_Link("edit",1112,0);
            
            $this->output=$targe_link;
			return $this->output;
			
		}

        public function get_input_defaults($input_variables=array()){
			$this->output="";
            $allowed_variables=array('type','id','name');

            $checked_variables=$this->call_check_variables($input_variables,$allowed_variables);

            
            $this->output=$this->Create_TextBox($checked_variables["config"],$checked_variables["default"]);
			return $this->output;
			
		}

        
        public function get_database_lists($table_name,$table_where_array=array(),$retrieve_values=array("*"),$Sort_Order=""){
            //print "\n table name=>".$table_name." where=>".var_export($table_where_array,true)." \n";
            $html_output="";
            $return_array=array();
            //print_r($table_where_array);
            $return_array=$this->cls->clsDatabaseCRUD->Exec_Retrieve($table_name,"Assoc",$retrieve_values,$table_where_array,$Sort_Order);
            //print_r($return_array);
            return $return_array;
        }

        public function Create_DropDown($config=array(),$default=null,$items=array()){
            //print_r($items);
          $output="";
        //print_r($config);
          $config_output="";
          foreach($config as $key=>$val){
            $config_output.=" ".$key."='".$val."' ";
          }
          $output='<select '.$config_output.'>';
      
          foreach($items as $key=>$val){
            if(isset($val['id'])){
                if(!is_null($default)){
                    
                    if($default==$val['id']){
                        $selected_string="selected";
                    }else{
                        $selected_string="";
                    }
                
                }else{
                    $selected_string="";
                }
                $output.="<option value='".$val['id']."' ".$selected_string.">".$val['Name']."</option>";
            }else{
                //print("\n ff=>");
                //print_r($val);
                //print(" | \n");
            }
             
            
                      
          }
          $output.="</select>";
          
          return $output;
          
        }
      
        public function Create_TextBox($config=array(),$default=""){
          //print_r($items);
          $output="";
          $config_output="";
          foreach($config as $key=>$val){
            $config_output.=" ".$key."='".$val."' ";
          }
          $output='<input '.$config_output.' value="'.$default.'">';
      
                      
          return $output;
          
        }
      
        public function Create_Button($config=array(),$default=""){
            //print_r($items);
            $output="";
            $config_output="";
            foreach($config as $key=>$val){
              $config_output.=" ".$key."='".$val."' ";
            }
            $output='<input '.$config_output.' value="'.$default.'">';
      
                        
            return $output;
            
          }
      
          public function Create_Label($config=array(),$default=""){
          //print_r($items);
          $output="";
          $config_output="";
          foreach($config as $key=>$val){
            $config_output.=" ".$key."='".$val."' ";
          }
          $output='<span '.$config_output.' >'.$default.'</span>';
      
                      
          return $output;
          
        }
        
  }

