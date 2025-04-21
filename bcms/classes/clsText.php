<?php

    class clsText{
        use trtBasic;
        private $content_pagesID=0;

        
        function __construct($classes=array()){
            //$this->cls=$classes;
            //print "xxx33 \n";
		}

        

        


        function Pre_Display(){
            //$this->var=$this->vrs->do;
            //$this->Start_App_Vars();
            //echo"\n\n--D2222III---------------------------------------------------------------------------\n";
            //print_r($this->var['content']);
            //$sql="SELECT content_text FROM mod_text WHERE content_pagesID=".PAGESID;
            //$sql="SELECT content_text FROM mod_text WHERE content_pagesID=".$content_data["db"]['id'];
            //echo"700666-----------------------------------------------------------------------------\n";
            $this->Update_All_Vars();
            //print_r($this->var);
            if(isset($this->var['content']['db']['id'])){
                $content_pagesID=$this->var['content']['db']['id'];

                $sql="SELECT * FROM mod_text WHERE content_pagesID=".$content_pagesID;
                //print "\n".$sql."\n";
                //$this->log->general("-yyy Text Display->".$sql,3);
                $rows=array();
                $rslt=$this->db->RawQuery($sql);
                //print_r($rslt);
                //$num_rows=$this->db->NumRows($rslt);
                //echo"\n -".$num_rows."-0001-----------------------------------------------------------------------------\n";
                $rows=$this->db->Fetch_Assoc($rslt);
                //print_r($rows);
                //echo"\n 10001-----------------------------------------------------------------------------\n";
                if(count($rows)>0){
                    $this->var['text']["db"]=$rows;
                }else{
                    $this->var['text']["db"]=array();
                }
            }
            
            //print_r($this->var);
            //print_r($text_data);
            ////$this->log->general("-yx Text Display->".var_export($this->var['text']["db"],true),3);
            //print_r($this->var['text']);
            $this->Update_App_Vars();
            //$this->vrs->do=$this->var;
        }
        /*
        function Display_Text(){
            //$this->log->general("-yxz Text Display->",3);
            //print "-x-";
            if(isset($this->var['text']["db"]['content_text'])){
                
                $cur_str=ltrim($this->var['text']["db"]['content_text'],"\n\r\t\v\x00");
            }else{
                $cur_str="";
            }

            
            print $cur_str;
        }
        */
        /*
        function Pre_Display(){
            //$this->log->general("-yxz Text Display->",3);
            //print "-x-";
            if(isset($this->var['text']["db"]['content_text'])){
                
                $cur_str=ltrim($this->var['text']["db"]['content_text'],"\n\r\t\v\x00");
            }else{
                $cur_str="";
            }

            
            print $cur_str;
        }
        */
        public function Main_Display(){
            //$this->Update_All_Vars();
            //$this->Start_App_Vars();
            //print_r(clsClassFactory::$vrs);
            //print "xxx33 \n";
            //print_r($this->var);
            
            

            $ret_value="";
            if(isset( $this->var['text']["db"]['content_text'])){
                $ret_value=$this->var['text']["db"]['content_text'];
            }
            
            return $ret_value;
        }
	
    }