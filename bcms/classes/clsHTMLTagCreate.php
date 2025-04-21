<?php

    class clsHTMLTagCreate{
        use trtBasic;
        //var $output="";

        function __construct(){
			
			
		}
        
        public function Create_DropDown($config=array(),$default=null,$items=array()){
            //print_r($items);
          $output="";
          $config_output=$this->Create_Config($config);
          $output='<select '.$config_output.'>';
      
          foreach($items as $key=>$val){
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
                       
          }
          $output.="</select>";
          
          return $output;
          
        }
      
        public function Create_TextBox($config=array(),$default=""){
          //print_r($items);
          $output="";
          $config_output=$this->Create_Config($config);
          $output='<input '.$config_output.' value="'.$default.'">';
      
                      
          return $output;
          
        }
      
        public function Create_Button($config=array(),$default=""){
            //print_r($items);
            $output="";
            $config_output=$this->Create_Config($config);
            $output='<input '.$config_output.' value="'.$default.'">';
      
                        
            return $output;
            
          }
      
          public function Create_Label($config=array(),$default=""){
          //print_r($items);
          $output="";
          $config_output=$this->Create_Config($config);
          
          $output='<span '.$config_output.' >'.$default.'</span>';
      
                      
          return $output;
          
        }

        public function Create_Config($config=array()){
            
            $config_output="";
            foreach($config as $key=>$val){
              $config_output.=" ".$key."='".$val."' ";
            }     
            return $config_output;
        }


        public function Create_Table_TH($config=array(),$item=""){
      
            $output="";
            $config_output=$this->Create_Config($config);
            $output='<th '.$config_output.'>';
            $output.=$item;
            
            $output.="</th>";
            
            return $output;
            
          }
      
          public function Create_Table_TD($config=array(),$item=""){
            
          $output="";
          $config_output=$this->Create_Config($config);
          $output='<td '.$config_output.'>';
          $output.=$item;
          
          $output.="</td>";
          
          return $output;
          
        }
      
        public function Create_Table_TR($config=array(),$item=""){
            
          $output="";
          $config_output=$this->Create_Config($config);
          $output='<tr '.$config_output.'>';
          $output.=$item;
          
          $output.="</tr>";
          
          return $output;
          
        }
      
        public function Create_Table($config=array(),$item=""){
            
          $output="";
          $config_output=$this->Create_Config($config);
          ///$select_details=implode("=",$config);
          $output='<table '.$config_output.'>';
          $output.=$item;
          
          $output.="</table>";
          
          return $output;
          
        }
      
        public function Create_Form($config=array(),$item=""){
            
            $output="";
            //print_r($config);
            $config_output=$this->Create_Config($config);
            //$select_details=implode("=",$config);
            //print $select_details;
            $output='<form '.$config_output.'>';
            $output.=$item;
            
            $output.="</form>";
            
            return $output;
            
        }
        
  }

