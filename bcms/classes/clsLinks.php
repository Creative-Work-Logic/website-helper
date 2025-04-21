<?php

    class clsLinks{
        use trtBasic;
        var $secure_domain="https://";
        var $domain="";
        //var $guid="";
        var $seo_friendly=false;
        

        function __construct(){
			$this->Setup_Domain();//echo"crap";
            if($this->var['app']['guid']!=""){
                $this->guid=$this->var['app']['guid'];//$this->cls->clsSession->get_guid();
            }
			
            if($this->var['domain']["original_db"]['SEOFriendlyLT']==13){
                $this->seo_friendly=true;
            }
		}

        public function Setup_Domain($secure_domain="",$domain=""){
            
            if($secure_domain==""){
                /*
                if(strlen($_SERVER['HTTPS'])!=""){
                    $secure_domain="https://";
                }else{
                    $secure_domain="http://";
                }
                    */
                    //echo "<br>--hh-\n".$_SERVER['HTTPS']."--- \n<br>";
                    /*
                    if($_SERVER['HTTPS']!="off"){
                        $protocal="https://";
                    }else{
                        $protocal="http://";
                    }
                        */
                        if($_SERVER['SERVER_PORT']==80){
                            $protocal="http://";
                        }else{
                            $protocal="https://";
                        }
                        
            }
            if($domain==""){
                if($this->var['domain']["dcmshost"]!=""){
                    $domain=$this->var['domain']["dcmshost"];
                }else{
                    $domain=$_SERVER['SERVER_NAME'];  
                    
                }
                if($_SERVER['SERVER_PORT']!=80){
                    if($_SERVER['SERVER_PORT']!=443){
                        $domain.=":".$_SERVER['SERVER_PORT'];
                    }
                    
                    //print $_SERVER['SERVER_PORT'];
                }
                
            }
            //print $_SERVER['SERVER_PORT'];
            $this->domain=$protocal.$domain;
            $this->secure_domain=$protocal.$domain;
            $this->guid=$this->var['app']['guid'];
            //$this->guid=$this->cls->clsSession->get_guid();
		}

        public function Get_Current_Page_Link(){
            $Current_Page="";
            if(isset($this->var['module']['db']['id'])){
                $module_viewsID=$this->var['module']['db']['id'];
                if(isset($this->var['domain']["original_db"]['id'])){
                    $domainsID=$this->var['domain']["original_db"]['id'];
                }else{
                    $domainsID=$this->var['domain']["db"]['id'];
                }
                
                $Current_Page=$this->Lookup_Local_Link_Target($module_viewsID,$domainsID);
                print "\n $Current_Page | $module_viewsID | $domainsID \n";
            }
            			
            return $Current_Page;
		}

        public function Create_SEO_Friendly_Link($seo_friendly=""){
			//echo "ll";
            return $this->Create_Link($seo_friendly,"",0,0);
		}

        public function Create_Remote_Url_Link($remote_url=""){
			
            return $this->Create_Link("",$remote_url,0,0);
		}

        public function Create_Content_Pages_Link($content_pagesID=0){
			
            return $this->Create_Link("","",$content_pagesID,0);
		}

        public function Create_Module_Views_Link($module_viewsID=0){
			
            return $this->Create_Link("","",0,$module_viewsID);
		}

        public function Create_HTML_Link($title="",$href=""){
			$return_url='<a href="'.$href.'">'.$title.'</a>';
            return $return_url;
		}

        public function Create_Local_Link($title="",$module_viewsID=0,$domainsID=0,$edit_item=0){
			
            $return_array=array();
            $return_url="";
            $return_url=$this->Lookup_Local_Link_Target($module_viewsID,$domainsID);
            if($edit_item>0){
                if($this->var['domain']["original_db"]['SEOFriendlyLT']==13){
                    $return_url.="&id=".$edit_item;
                }else{
                    $return_url.="?id=".$edit_item;
                }
            }
            //$return_url='<a href="'.$return_url.'">'.$title.'</a>';
            //$return_url='<a href="'.$return_url.'">'.$title.'</a>';
            return $return_url;
		}

        public function Create_Page_Link($Page_Number){
			
            $return_array=array();
            $return_url=$this->Get_Current_Page_Link();//$this->secure_domain;//$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
            //print $return_url;
            if(strpos($return_url,'?')){
                $return_url.="&page=".$Page_Number;
            }else{
                $return_url.="?page=".$Page_Number;
            }
            $return_url=$this->Create_HTML_Link($Page_Number,$return_url);
            //print $return_url;
            return $return_url;
		}

        public function Lookup_Local_Link_Target($module_viewsID=0,$domainsID=0){
			$this->Setup_Domain();
            if($module_viewsID==0){
                if(isset($this->var['content']['db']['module_viewsID'])){
                    $module_viewsID=$this->var['content']['db']['module_viewsID'];
                }
                
            }
            if($domainsID==0){
                //if(isset($this->var['domain']['db']['id'])){
                //    $domainsID=$this->var['domain']['db']['id'];
                //}
            }
            $retrieve_array=array('id',"URI");
            
            $table_where_array=array("module_viewsID"=>$module_viewsID,"domainsID"=>$domainsID);
            $page_array=$this->cls->clsDatabaseCRUD->Exec_Retrieve("content_pages","Assoc",$retrieve_array,$table_where_array);
            
            //$return_url=$this->secure_domain;//$this->get_domain_details();
            
            if(isset($this->var['domain']["original_db"]['SEOFriendlyLT'])){
                $current_seo=$this->var['domain']["original_db"]['SEOFriendlyLT'];
            }else{
                $current_seo=$this->var['domain']["db"]['SEOFriendlyLT'];
            }
            if($current_seo==13){
                
                $return_url='/index.php?guid='.$this->guid.'&cpid='.$module_viewsID;
            }else{
                $return_url.=$page_array['URI'];
            }
            //print " \n hh2 $current_seo | ";
            //print_r($page_array['URI']);
            //print "  hh3 \n";
            
            return $return_url;
		}

        
        public function Create_Form_Action($module_viewsID=0,$domainsID=0){
			$return_array=array();
            $return_url="";
            $return_url=$this->Lookup_Local_Link_Target($module_viewsID,$domainsID);
            return $return_url;
		}

        

        public function get_domain_details(){
            $return_url="";
            if($this->domain!=""){
                //$return_url=$this->secure_domain.$this->domain;
                $return_url=$this->domain;
            }else{
                //$return_url=$this->secure_domain.$_SERVER['SERVER_NAME' ];
                $return_url=$this->secure_domain.$_SERVER['SERVER_NAME' ];
            }
            return $return_url;
        }

        private function Create_Link($seo_friendly="",$remote_url="",$content_pagesID=0,$module_viewsID=0){
			//$this->Setup_Domain();
            //echo "\n fff |".$seo_friendly."|".$remote_url."|".$content_pagesID." \n";
            $return_url="";
            $this->guid=$this->var['app']['guid'];
            $return_url=$this->domain;//$this->get_domain_details();

            if($seo_friendly!=""){
                $return_url.=$seo_friendly;
            }
            if($remote_url!=""){
                $return_url.=$remote_url;
            }
            if($content_pagesID!=0){
                $return_url.='/index.php?guid='.$this->guid.'&cpid='.$content_pagesID;
            }
            if($module_viewsID!=0){
                $return_url.='/index.php?guid='.$this->guid.'&mvid='.$module_viewsID;
            }
			return $return_url;
		}
        
    }

