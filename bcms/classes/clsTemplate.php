<?php

    class clsTemplate{
        use trtBasic;

        
        function __construct(){
            
            
		}

        
        
        /*
        public function Run_Template_Import(){
            
            $template_code="";
            if(isset($this->var['template']["db"]['dir'])){
				$this->var['template']['My_Dir']=$this->var['app']['APPBASEDIR']."templates/".$this->var['template']["db"]['dir'];
				//$load_file=$this->var['template']['My_Dir']."/index.php";
                $load_file=$this->var['template']['My_Dir'];
				////$this->log->general("-End line-".$load_file,9);
				//print $load_file;
				//$this->log->general("-ar Loading Template->",9,$this->var['template']["db"]);
				//echo"\n\n-10----".$load_file."----------------------------------------------------\n\n";
                
				if(file_exists($load_file)){
					//$this->var['app']["include_callback"]="callback_template";
					$filepath=$load_file;
		            $template_code=$this->Load_File($load_file);
                    echo"\n\n-1001----".$template_code."----------------------------------------------------\n\n";
				}else{
					throw new Exception('Template not loading.');
				}
                
			}else{
				exit("No Template File");
			}
            //$template_code = wordwrap($template_code, 50, "\n<br>");
            //echo"\n\n-1001----\n\n".base64_decode($template_code)."\n\n----------------------------------------------------\n\n";
            //echo"\n\n-1001----\n\n".$template_code."\n\n----------------------------------------------------\n\n";
            
            return $template_code;
        }
        */
        
        public function Run_Template(){
            $template_code="";
            if(isset($this->var['template']["db"]['filedata'])){
                $template_size=strlen($this->var['template']["db"]['filedata']);
                ////$this->log->general("-RT Loading Template->".$template_size,9,$this->var['template']["db"]);
                if($template_size>0){
                    $template_code=base64_decode($this->var['template']["db"]['filedata']);
                    //print $template_code;
                    //clsClassFactory::$vrs->new_variables[]=$this->var;
                    return $template_code;
                    //echo"\n\n-1001--------------------------------------------------------\n\n";
                    //print_r($this->var['template']["db"]);
                    //return $this->var['template']["db"]['filedata'];
                    
                    
                }else{
                    exit("No Template File");
                }
            }
            
            
        }

        public function Modify_Template(){
            $template_code="";
            $this->output=$this->cls->clsHTMLContent->create_modify_template_form_fields();
            return $this->output;
            
            
        }

        public function Edit_Template(){
            $template_code="";
            $this->output=$this->cls->clsHTMLContent->create_modify_template_form_fields();
            return $this->output;
            
            
        }
        
        /*
        public function Load_File($file_wrapper){
            
            $template_code="";
            $normal=$file_wrapper."/index.php";
            $new=$file_wrapper."/index-new.php";
            $run_file="";
            if(file_exists($new)){
                $run_file=$new;
            }elseif(file_exists($normal)){
                $run_file=$normal;
            }
            
            //include($file_wrapper);
            $template_code = base64_encode(file_get_contents($run_file));

            //$this->log->general("-FFF Loading Template->".$run_file,9,$template_code);
            
            return $template_code;
        }
        */
        public function Template_Init(){
            //
            $this->Update_All_Vars();
            //$this->templatesID=0;
            //$this->domains_templatesID=0;
            //set sql result non capitalized
            //echo"--73RRR---------------------------------------------------------------------------\n";
            //print_r($this->var['content']);
            //echo"--73RRRXXDomain---------------------------------------------------------------------------\n";
            //print_r($this->var['domain']);
            //echo"--73RRRXX---------------------------------------------------------------------------\n";
            if(isset($this->var['content']["db"])){
                
                if(isset($this->var['content']["db"]['templatesID'])){
                    if($this->var['content']["db"]['templatesID']==0){
                        //echo"--In Content------------------------ff-|-".$this->var['content']["db"]['templatesID']."-|------------------------------------------------\n";
                        if(isset($this->var['domain']["db"]['templatesID'])){
                            if($this->var['domain']["db"]['templatesID']>0){
                                $templatesID=$this->var['domain']["db"]['templatesID'];
                            }else{
                                $templatesID=0;
                            }				
                        }else{
                            $templatesID=0;
                        }
                    }else{
                        $templatesID=$this->var['content']["db"]['templatesID'];
                    }			
                }elseif(isset($this->var['domain']["db"]['templatesID'])){
                    if($this->var['domain']["db"]['templatesID']>0){
                        $templatesID=$this->var['domain']["db"]['templatesID'];
                    }else{
                        $templatesID=0;
                    }
                
                }else{
                    $templatesID=0;
                }
                //echo "\n\n 123QQQ---".$templatesID."----\n\n";
                //if content page has a custom template then overwrite the domain template
                if($templatesID>0){

                    //Exec_Retrieve($array_type="Assoc",$table_name,$retrieve_columns=array("*"),$where_array=array(),$order_by="id",$max_rows=0,$page_number=1){
			
                    //trigger_error("Cannot divide by zero", E_USER_ERROR);

                    $sql="SELECT * FROM templates WHERE id='".$templatesID."'";
                    //$sql="SELECT * FROM templates WHERE id='27'";
                    //$sql="SELECT * FROM templates";
                    $rslt=$this->db->rawQuery($sql);
                    $num_rows=$this->db->NumRows($rslt);
                    //echo "\n\n 123---".$sql."----\n\n";
                    if($num_rows>0){
                        $this->var['template']["db"]=$this->db->Fetch_Assoc($rslt);
                        //print_r($this->var['template']);
                        //print_r($sql);
                        //$this->log->general("DDD HTML Template",9,strlen($this->var['template']["db"]['filedata']));
                        $this->var['template']["db"] = $this->as->strip_capitals($this->var['template']["db"]);
                        if(count($this->var['template']["db"])==0){
                            //exit("No Template->".$sql);
                            //$error_message="No template found=>".$sql;
                            //echo $error_message;
                            //print_r($this->var['template']["db"]);
                            
                            //$this->log->general("No template found=>",4,$this->var['template']["db"]);
                        }
                        if(strlen($this->var['template']["db"]['filedata'])==0){
                            //$this->log->general("No HTML Template",9,strlen($this->var['template']["db"]['filedata']));
                        }
                        //echo "\n\n 123-------\n\n";
                        //print_r($this->var['template']["db"]);
                        $this->var['template']['TEMPLATEPATH']=$this->var['app']['APPBASEDIR']."templates/".$this->var['template']["db"]['dir'];
                        $this->var['template']['TEMPLATEDIR']=$this->var['template']['TEMPLATEPATH'];
                    }else{
                        //exit("No Template->".$sql);
                    }
                }
                
                
                
                //echo "xxx";
            }
        }
        
    }

