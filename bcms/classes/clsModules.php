<?php

    class clsModules{
        use trtBasic;
       
        
        function __construct(){
                
                
		}

        

        

        function Find_Module($modules_viewsID=0){
           
                if(isset($this->var['module']['views']['modulesID'])){
                    $modulesID=$this->var['module']['views']['modulesID'];
                }else{
                    $this->Find_Module_View();
                    $modulesID=$this->var['module']['views']['modulesID'];
                }
                
            
            $sql='SELECT * FROM modules WHERE id="'.$modulesID.'"';
            
            $rslt=$this->db->RawQuery($sql);
            $num_rows=0;
            $num_rows=$this->db->NumRows($rslt);
            if($num_rows>0){
                $this->var['module']['db']=$this->db->Fetch_Assoc();
            }
            
            //return $this->var['module']['db'];
		}

        function Find_Module_View($modules_viewsID=0){
           if(isset($this->var['content']["db"]['module_viewsID'])){
                if($modules_viewsID==0){
                    $modules_viewsID=$this->var['content']["db"]['module_viewsID'];
                }
                $sql='SELECT * FROM module_views WHERE id="'.$modules_viewsID.'"';
                
                $rslt=$this->db->RawQuery($sql);
                $num_rows=0;
                $num_rows=$this->db->NumRows($rslt);
                if($num_rows>0){
                    $this->var['module']['views']=$this->db->Fetch_Assoc();
                }
           }
            
            
            //return $this->var['module']['views'];
		}

        public function Module_Get_Data_Arrays(){
           
            //$output_array=array($this->all_data_names[2]=>$this->template_data,$this->all_data_names[3]=>$this->var['content'],
            //$this->all_data_names[1]=>$this->var['domain'],$this->all_data_names[0]=>$this->app_data);

            $output_array=array($this->var['module']);
            
			return $output_array;
		}
       
    }

