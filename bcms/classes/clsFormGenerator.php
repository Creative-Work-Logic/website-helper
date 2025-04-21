<?php

    class clsFormGenerator{
      use trtBasic;
        public $html_data;     
        

        public $rslt;

        
        function __construct(){
            
		    }

       // ==================================================================  new form builder types | create html Form Field
        public function Create_HTML_Form($input_html="",$Form_Action="",$hidden_item=""){
            if($Form_Action==""){
              $Form_Action=$_SERVER['REQUEST_URI'];
            }
            $this->output='<form action="'.$Form_Action.'"  method="post" name="form2"  >';
            $this->output.=$input_html;
            $this->output.$hidden_item;
            $this->output.="</form>";
            return $this->output;
          }

          function Create_Select($name,$id,$item_array,$defaultID=0){
            //print_r($item_array);
            $output="";
            $output='<select name="'.$name.'" id="'.$id.'">';
            
            
            foreach($item_array as $key=>$val){
                if($defaultID==$key){
                    $output.="<option value='".$val[0]."' selected>$val[1]</option>";
                }else{
                    $output.="<option value='".$val[0]."'>".$val[1]."</option>";
                };
            }
            $output.="</select>";
            
            return $output;
            
        }

          // ==================================================================  new form builder types | DB Selections

        public function List_Table_Rows($table_name,$retrieve_array=array(),$order_by="id",$max_rows=0,$page_number=1){
            $retrieve_list="*";
            if(count($retrieve_array)>0){
              $retrieve_list=implode(",",$retrieve_array);
              /*foreach($retrieve_array as $key=>$val){
                $retrieve_list.=$val
              } 
              */
            }
            if($order_by!=""){
              $order_by_sql=" ORDER BY ".$order_by;
              if($max_rows>0){
                  $sql_limits=" LIMIT 0,10";
              }else{
                  $sql_limits="";
              }
            }else{
              $order_by_sql="";
              $sql_limits="";
            }
            
            
            $sql="SELECT ".$retrieve_list." FROM ".$table_name." ".$order_by_sql." ".$sql_limits;
            //print $sql;
            $return_array=array();
            $sql=$this->db->rawQuery($sql);
            //$this->dbslt=$this->Database_Raw_Query($sql);
            while($myrow=$this->db->Fetch_Array($sql)){
            //while($myrow=$this->Fetch_Array($this->dbslt)){
              $return_array[]=$myrow;
            }
            //print_r($return_array);
            //print_r("ggg=> \n");
            return $return_array;
          }

          public function Edit_Table_Rows($table_name,$retrieve_array=array(),$edit_id=0){
            $retrieve_list="*";
            if(count($retrieve_array)>0){
              $retrieve_list=implode(",",$retrieve_array);
            }
             
            $sql="SELECT ".$retrieve_list." FROM ".$table_name." WHERE  id=".$edit_id;
            //print $sql;
            $return_array=array();
            $rslt=$this->db->rawQuery($sql);
            
            $return_array=$this->db->Fetch_Array($rslt);
            return $return_array;
          }

          
          // ==================================================================  new form builder types | Constants

        public function Create_Table_Constants(){
            $return_array=array();
            $table_array=array('width'=>"40%", 'border'=>0,'align'=>"center",'cellpadding'=>2,
            'cellspacing'=>"1" ,'bgcolor'=>"#EBEBEB", 'id'=>"table");
            $table_th_array=array('align'=>"left",'bgcolor'=>"#CCC");
            $table_cols_array=array('align'=>"left",'bgcolor'=>"#FFFFFF");
            $table_cols_array_odd=array('align'=>"left",'bgcolor'=>"#EBEBEB");
            $return_array=array($table_array,$table_th_array,$table_cols_array,$table_cols_array_odd);
            //print_r($return_array);
            return $return_array;
        }

        public function Create_Edit_Table_Constants(){
            $table_array=array('width'=>"40%", 'border'=>0,'align'=>"center",'cellpadding'=>2,
                'cellspacing'=>"1" ,'bgcolor'=>"#EBEBEB", 'id'=>"table");
              
            $table_cols_array=array();
            $table_cols_array[]=array('align'=>"left",'bgcolor'=>"#CCC");
            $table_cols_array[]=array('align'=>"right",'bgcolor'=>"#FFFFFF");
            
            //$input['tags'][]=array('type'=>"submit",'value'=>'<input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save">');

            //$total_cols=$table_total['tags_columns'];
           //$total_rows=$table_total['tags_rows'];
            $return_array=array($table_array,$table_cols_array);
            return $return_array;
        }

        // ==================================================================  new form builder types | Create HTML Tag Types

        public function Create_Table_Elements($item_values=array()){
          $return_array=array();
          //$text_input_item=array('type'=>"text",'value'=>"",'size'=>"45",'style'=>"",'class'=>"");
          //$drop_down_input_item=array('type'=>"drop_down",'value'=>"",'size'=>"45",'style'=>"",'class'=>"",'db_table'=>"mod_organization");
          $text_input_item=array('type'=>"text",'size'=>"45",'style'=>"",'class'=>"","value"=>'');
          $drop_down_input_item=array('type'=>"drop_down",'size'=>"45",'style'=>"",'class'=>"",'db_table'=>"mod_organization");
          $blank_item=array('type'=>'blank');
          $hidden_item=array('type'=>'hidden',"value"=>'',"html"=>'<input type="hidden" value="">');
          $button_item=array('type'=>"submit_button","value"=>'Submit',"name"=>'Submit',"id"=>'','class'=>"formbuttons");
          $return_array=array($text_input_item,$drop_down_input_item,$blank_item,$hidden_item,$button_item);
          return $return_array;
        }


        public function Get_Table_Elements(){
          $return_array=array();
          $return_array["text"]=array('type'=>"text",'size'=>"45",'style'=>"",'class'=>"","value"=>'');
          $return_array["drop_down"]=array('type'=>"drop_down",'size'=>"45",'style'=>"",'class'=>"");
          $return_array["blank"]=array('type'=>'blank');
          $return_array["hidden"]=array('type'=>'hidden',"value"=>'',"html"=>'<input type="hidden" value="">');
          $return_array["submit_button"]=array('type'=>"submit_button","value"=>'Submit',"name"=>'Submit',"id"=>'','class'=>"formbuttons");
          return $return_array;
        }

        public function Create_Table_Items($input_type="label",$input_value="",$input_variables=array()){
            //print " \n iv=>".$input_value." \n ";
            $table_content="";
            switch($input_type){
              case "blank":
                $table_content="";
              break;
              case "label":
                $table_content=$input_value;
              break;
              case "edit_link":
                if((isset($input_variables['id']))&&(isset($input_variables['REQUEST_URI']))){
                  $id=$input_variables['id'];
                  $table_content="<a href='".$input_variables['REQUEST_URI'].'id='.$id."/'> Edit </a>";

                  
                }else{
                  $table_content="";
                }
                
                break;
                case "text_field":
                  case "text":
                    $text_field_value=0;
                    if(isset($input_value)) $text_field_value=$input_value;
                    if(isset($input_variables['value'])) $text_field_value=$input_variables['value'];
                    //$table_content=var_export($input_variables,true);
                    $table_content='<input name="'.$input_variables['id'].'" type="text"  size="'.$input_variables['size'].'"  id="'.$input_variables['id'].'" value="'.$text_field_value.'">';
                  break;
                case "drop_down":
                    //$this->Create_Select($name,$id,$item_array,$defaultID=0);
                    $drop_down_field_value=0;
                    if(isset($input_value)) $drop_down_field_value=$input_value;
                    if(isset($input_variables['value'])) $drop_down_field_value=$input_variables['value'];

                    $retrieve_array=array('id','Name');
                    $organization_array=$this->List_Table_Rows($input_variables['db_table'],$retrieve_array,$order_by="Name");
                    $table_content=$this->Create_Select($input_variables['id'],$input_variables['id'],$organization_array,$drop_down_field_value);
                    //$table_content=var_export($input_variables);
                  break;
                case "submit_button":
                  $button=array('type'=>"submit",'value'=>'<input name="Submit" type="submit"  class="formbuttons" id="Submit" value="Save">');
                  $table_content=$button['value'];
                break;
            }
            return $table_content;
          }

          // ==================================================================  new form builder types | list


        public function Create_List_Table($sql_table,$input=array(),$order_by="id"){
            //print_r($input);
              
              
              /*

              $input['header_tags']=array('id','Page','Title','Menu Title','Changed','Exposure','Sort Order','Edit');
              $input['header_tags_type']=array('blank','label','label','label','label','label','label','label');
              $input['select_items']=array('id','URI','Title','MenuTitle','Changed','Exposure','Sort_Order','id');
              $input['item_types']=array('blank','label','label','label','label','label','label','edit_link');
              
            */

              $column_count=0;
              if(isset($input['item_types'])){
                foreach($input['item_types'] as $keys=>$values){
                  if($values!="blank"){
                    $column_count++;
                  }
                }
              }
              
                          /*   
              $table_total=array('tags_columns'=>$column_count,'tags_rows'=>2,'end_rows'=>1);
              echo"kk";
              print($input);
              $input['table_dimentions']=array();
              $input['table_dimentions']=$table_total;

              $table_constants=$this->Create_Table_Constants();
              
              $input['table_properties']=$table_constants[0];
              $input['table_tags_th']=$table_constants[1];
              $input['table_tags_td']=$table_constants[2];
              $input['table_tags_td_odd']=$table_constants[3];
              
              //print_r($input['select_items']);
              $input['row_outputs']=array();
              //$input['edit_page']=array('target_uri'=>$_SERVER['REQUEST_URI']);
              //$list_rows=$this->List_Content_Pages_Rows($input['select_items']);
              //$list_rows=$this->List_Table_Rows("content_pages",$input['select_items'],"id");
              if(isset($input['select_items'])){
                if(is_array($input['select_items'])){
                  if(count($input['select_items'])>0){
                    $list_rows=$this->List_Table_Rows($sql_table,$input['select_items'],$order_by);
                    $input['row_outputs']=$list_rows;
                  }
                }
              }
              
              
              //print_r($input);
              $this->output=$this->Create_List_Form($input);
              $this->output=$this->Create_HTML_Form($this->output,$_SERVER['REQUEST_URI']);
              
              */
              return $this->output;
          }

          // ==================================================================  new form builder types | edit

          public function Create_Edit_Table($sql_table,$input=array(),$edit_id=0,$order_by="id"){
            
            
            $column_count=0;
            foreach($input['item_types'] as $keys=>$values){
                if($values!="blank"){
                    $column_count++;
                }
            }
            $table_total=$input['table_total'];         
            //$table_total=array('tags_columns'=>$column_count,'tags_rows'=>2,'end_rows'=>1);

            $input['table_dimentions']=$table_total;

            $table_constants=$this->Create_Edit_Table_Constants();
            $table_array=$table_constants[0];
            $table_cols_array=$table_constants[1];

            $input['table_tags']['cols']=$table_constants[1];
            $input['table_tags']['rows']=array();
            $input['table_properties']=$table_constants[0];

              
            
            
            $list_rows=$this->Edit_Table_Rows($sql_table,$input['select_items'],$edit_id);
            //print_r($list_rows);
            $input['row_outputs']=$list_rows;
            
            $this->output=$this->Create_Editor_Form($input);
            $this->output=$this->Create_HTML_Form($this->output,$_SERVER['REQUEST_URI']);
            
            
            return $this->output;
          }

          // ==================================================================  new form builder types | edit

          public function Build_Edit_Table($input=array(),$edit_id=0){
            
            //print_r($input);
            
            $column_count=0;
            foreach($input['item_types'] as $keys=>$values){
                if($values!="blank"){
                    $column_count++;
                }
            }
            $table_total=$input['table_total'];         
            //$table_total=array('tags_columns'=>$column_count,'tags_rows'=>2,'end_rows'=>1);

            $input['table_dimentions']=$table_total;

            $table_constants=$this->Create_Edit_Table_Constants();
            $table_array=$table_constants[0];
            $table_cols_array=$table_constants[1];

            $input['table_tags']['cols']=$table_constants[1];
            $input['table_tags']['rows']=array();
            $input['table_properties']=$table_constants[0];

              
            
            
            $list_rows=$this->Edit_Table_Rows($sql_table,$input['select_items'],$edit_id);
            //print_r($list_rows);
            $input['row_outputs']=$list_rows;
            
            $this->output=$this->Create_Editor_Form($input);
            $this->output=$this->Create_HTML_Form($this->output,$_SERVER['REQUEST_URI']);
            
            
            return $this->output;
          }

          // ==================================================================  new form builder types | list


        public function Create_List_Form($input=array()){
            //print_r($input);
            $table_properties=" \n ".' <table ';
            
            $table_properties_tags="";
            foreach($input['table_properties'] as $key=>$val){
              $table_properties_tags.=$key."='".$val."' ";
            }
            $table_properties.=$table_properties_tags.">";
            $form_rows=count($input['row_outputs']);
            $form_cols=$input['table_dimentions']['tags_columns'];
            $form_output="";
            $input_tag='';
            $row_data=$input['row_outputs'];
            
            if($form_rows==0){
              $form_rows=count($input['header_tags']);
            }
            if($form_rows>0){
              for($row=0;$row<=$form_rows;$row++){
                $input_tag.=' <tr>';
                for($col=0;$col<=$form_cols;$col++){
                  //print "\n ".$row."->".$col." \n";
                  if($row==0){
                    $header_tag='th';
                    if(isset($input['header_tags'][$col])){//['value'])){
                      //print_r($input['header_tags'][$col]);
                      //$table_content=$input['header_tags'][$col]['value'];
                      if($input['header_tags_type'][$col]!="blank"){
                        $table_content=$input['header_tags'][$col];
                      }
                      
                    }
                  }else{
                    $header_tag="td";
                    $row_items=$row-1;
                    //print_r($input);
                    $input_variables=array();
                    if(isset($input['item_types'][$col])){
                      if($input['item_types'][$col]=="edit_link"){
                        $id=$input['row_outputs'][$row_items][0];
                          //$target_domain=$_SERVER['REQUEST_URI'];
                          $target_domain=$input['edit_page']['target_uri'];//=array('target_uri'=>$_SERVER['REQUEST_URI']);
                          ///management-edit-administrator/
                          $input_variables=array("id"=>$id,'REQUEST_URI'=>$target_domain);
                      }
                    }
                    
                    
                    if(isset($input['row_outputs'][$row_items][$col])){
                      //echo"--666------Call Function--------------Method=>------------vls=>--".__CLASS__."-----------------------------------------\n";
               
                      //print_r($input);
                      $table_content=$this->Create_Table_Items($input['item_types'][$col],$input['row_outputs'][$row_items][$col],$input_variables);
                    }else{
                      $table_content=$this->Create_Table_Items($input['item_types'][$col],array(),$input_variables);
                    }
                    
                              
                  }
                  //print_r($input);
                  if($row==0){
                    $table_column=$input['table_tags_th'];
                  }else{
                    if(($row % 2)==0){
                      $table_column=$input['table_tags_td_odd'];
                    }else{
                      $table_column=$input['table_tags_td'];
                    }
                    
                  }
                  if(isset($input['header_tags_type'][$col])){
                    if($input['header_tags_type'][$col]!="blank"){
                        foreach($table_column as $key=>$val){
                          $table_column_spread=$key."='".$val."' ";
                        }
                        $input_tag.=" \n".' <'.$header_tag.' '.$table_column_spread.' >';
                        $input_tag.=$table_content;
                        $input_tag.=' </'.$header_tag.'>';
                    }
                  }
                  
                }
                $input_tag.=' </tr>'; 
              }
              $form_output.=$input_tag."\n".' <tr>';
            }
            $table_properties.=$form_output."</table>";
            $this->output=$table_properties;
            $this->output=$this->Create_HTML_Form($this->output,$_SERVER['REQUEST_URI']);
            return $this->output;
          }


          // ==================================================================  new form builder types | create
          public function Create_Input_Form($input=array()){
            //echo"--66677------Call Function--------------Method=>------------vls=>--".__CLASS__."-----------------------------------------\n";
            //print "\n =>".var_export($input,true)." \n";
            $table_properties=" \n ".' <table ';
            
            $table_properties_tags="";
            foreach($input['table_properties'] as $key=>$val){
              $table_properties_tags.=$key."='".$val."' ";
            }
            $table_properties.=$table_properties_tags.">";
            $form_rows=$input['table_dimentions']['tags_rows'];
            $form_cols=$input['table_dimentions']['tags_columns'];
            $form_output="";
            $input_tag='';
            if($form_rows>0){
              for($row=0;$row<$form_rows;$row++){
                $input_tag.=" \n".' <tr> ';
                //$total_rows=$input['table_dimentions']['tag_rows'];
                $end_rows=$input['table_dimentions']['end_rows'];
                if($row==($form_rows-$end_rows)){
                  
                  //print "\nDDD =>".$row." \n";
                  $table_column=$input['table_tags']['cols'];
                  $table_column_spread="";
                  foreach($table_column as $key=>$val){
                    if($key=="align"){
                      $val="right";
                    }
                      $table_column_spread.=$key."='".$val."' ";
                  }
                  $input_tag.=' <td '.$table_column_spread.' colspan="2" >';

                  //print "\nDDD =>".var_export($input['item_type_properties'][$row],true)." \n";
                  $table_content=$this->Create_Table_Items($input['item_type_properties'][$row]['type'],$variable_value,$input_variables);
                  $input_tag.=$table_content;//$input['item_types'][$row];
                  $input_tag.=' </td>';
                  $input_tag.=' </tr>';
                }else{
                  
                  //print "\n =>".$input['table_dimentions']['end_rows']." \n";
                  if($input['item_types'][$row]=="blank"){
                      $input_tag="";
                  }else{
                    
                      for($col=0;$col<$form_cols;$col++){
                        /*
                        if($col==0){
                          $input_tag.=$input['header_tags'][$row];
                        }
                        
                        */ 
                        //echo"--1234------Call Function------Col--".$col."------Method=>-----".var_export($input['item_type_properties'],true)."-------vls=>--".__CLASS__."-----------------------------------------\n";
                  
                        if(isset($input['table_tags']['cols'])){
                          
                          $table_column=$input['table_tags']['cols'];
                          $table_column_spread="";
                          foreach($table_column as $key=>$val){
                              $table_column_spread.=$key."='".$val."' ";
                          }
                          $input_tag.=' <td '.$table_column_spread.' >';
                          if($col==0){
                            //echo"--001234------Call Function------Col--".$col."------Method=>-----".var_export($input,true)."-------vls=>--".__CLASS__."-----------------------------------------\n";
                  
                              $input_tag.=$input['header_tags'][$row];
                          }else{
                              //print_r($input['item_types'][$row]);
                              $inputID=array('id'=>$input['select_items'][$row]);
                              $properties=$input['item_type_properties'][$row];
                              $input_variables=array_merge($inputID,$properties);
                              //echo"--889------Call Function------Col--".$col."------Method=>-----".var_export($properties,true)."-------vls=>--".__CLASS__."-----------------------------------------\n";
                  
                              //print_r($properties);
                              if(isset($input['row_outputs'][$row])){
                                  $variable_value=$input['row_outputs'][$row];
                              }else{
                                  $variable_value="";
                              }
                              
                              $table_content=$this->Create_Table_Items($input['item_types'][$row],$variable_value,$input_variables);
                              $input_tag.=$table_content;//$input['item_types'][$row];
                          }   

                        }else{
                          //echo"--3334------Call Function--------------Method=>------------vls=>--".__CLASS__."-----------------------------------------\n";
                          //print_r($input['table_tags']);
                        }
                                        
                    
                          $input_tag.=' </td>';
                      }
                      $input_tag.=' </tr>'; 
                  }
                  
                }
                
              }
              
                $form_output.=$input_tag."\n";
                
            }
            $table_properties.=$form_output."</table>";
            
            $this->output=$table_properties;
            
            return $this->output;

          }
          // ==================================================================  new form builder types | update

          // ==================================================================  new form builder types | retrieve

          // ==================================================================  new form builder types | Delete

          
          // ==================================================================  new form builder types | edit
          public function Create_Editor_Form($input=array()){
            //print_r($input);
            $table_properties=" \n ".' <table ';
            
            $table_properties_tags="";
            foreach($input['table_properties'] as $key=>$val){
              $table_properties_tags.=$key."='".$val."' ";
            }
            $table_properties.=$table_properties_tags.">";
            $form_rows=$input['table_dimentions']['tags_rows'];
            $form_cols=$input['table_dimentions']['tags_columns'];
            $form_output="";
            $input_tag='';
            if($form_rows>0){
              for($row=0;$row<$form_rows;$row++){
                $input_tag.=' <tr>';
                //print "\n =>".$input['item_types'][$row]." \n";
                if($input['item_types'][$row]=="blank"){
                    $input_tag="";
                }else{
                    for($col=0;$col<$form_cols;$col++){
                        $table_column=$input['table_tags']['cols'][$col];
                        $table_column_spread="";
                        foreach($table_column as $key=>$val){
                            $table_column_spread.=$key."='".$val."' ";
                        }
                        $input_tag.=' <td '.$table_column_spread.' >';
                        if($col==0){
                            $input_tag.=$input['header_tags'][$row];
                        }else{
                            //print_r($input['item_types'][$row]);
                            $inputID=array('id'=>$input['select_items'][$row]);
                            $properties=$input['item_type_properties'][$row];
                            $input_variables=array_merge($inputID,$properties);
                            if(isset($input['row_outputs'][$row])){
                                $variable_value=$input['row_outputs'][$row];
                            }else{
                                $variable_value="";
                            }
                            
                            $table_content=$this->Create_Table_Items($input['item_types'][$row],$variable_value,$input_variables);
                            $input_tag.=$table_content;//$input['item_types'][$row];
                        }                  
                  
                        $input_tag.=' </td>';
                    }
                    $input_tag.=' </tr>'; 
                }
              }
              
                $form_output.=$input_tag."\n".' <tr>';
                
            }
            $table_properties.=$form_output."</table>";
            
            $this->output=$table_properties;
            
            return $this->output;

          }

          

    }