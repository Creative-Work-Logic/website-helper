<?php

    class clsContent{
        use trtBasic;
        
        private $input_data=array();

        private $input_post_data=array();

        private $input_get_data=array();

        private $target=array();

        private $target_class="";

        
        

        
        function __construct(){
            $this->Set_Input_Variables();
            
		}

        

        
           
        
        

        public function Set_Input_Variables(){
            foreach($_GET as $key=>$val){
                $this->input_data[$key]=$val;
            }
            $this->input_get_data=$this->input_data;
            foreach($_POST as $key=>$val){
                $this->input_post_data[$key]=$val;
            }

            if(isset($_SESSION['membersID'])){
                $this->input_data['membersID']=$_SESSION['membersID'];
            }else{
                $this->input_data['membersID']=0;
            }
            if(isset($_SESSION['LanguagesID'])){
                $this->input_data['LanguagesID']=$_SESSION['LanguagesID'];
            }else{
                $this->input_data['LanguagesID']=1;
            }
            /*
            if(isset($_GET['cpid'])){
                $this->input_data['cpid']=$_GET['cpid'];
                
            }else{
                if(isset($_POST['cpid'])){
                    $this->input_data['cpid']=$_POST['cpid'];
                }else{
                    $this->input_data['cpid']=0;
                }
            }
            if(isset($_GET['mvid'])){
                $this->input_data['mvid']=$_GET['mvid'];
                
            }else{
                if(isset($_POST['mvid'])){
                    $this->input_data['mvid']=$_POST['mvid'];
                }else{
                    $this->input_data['mvid']=0;
                }
            }
            if(isset($_GET['dcmsuri'])){
                $this->input_data['dcmsuri']=$_GET['dcmsuri'];
            }else{
                $this->input_data['dcmsuri']=0;
            }
            if(isset($_GET['change'])){
                $this->input_data['change']=$_GET['change'];
            }else{
                $this->input_data['change']=0;
            }           
                */
                //print_r($this->input_data);
            $this->input_data['REQUEST_URI']=$_SERVER['REQUEST_URI'];
            if(isset($this->input_data['cpid'])){
                if($this->input_data['cpid']>0){
                    $this->var['content']['cpid']=$this->input_data['cpid'];
                }else{
                    if($this->input_post_data['cpid']>0){
                        $this->var['content']['cpid']=$this->input_post_data['cpid'];
                    }else{
                        $this->var['content']['cpid']=0;
                    }
                    
                }
            }
            
            $original_page=$this->input_data['REQUEST_URI'];
            $this->var['content']["original_uri"]=$original_page;
            //$original_page=$this->input_data['REQUEST_URI'];
            //$this->var['content']["original_uri"]=$original_page;
            
            if(!isset($this->input_data['membersID'])) $this->input_data['membersID']=0;
            //$this->vrs->do=$this->var;
            
		}
        
        public function Content_Init_Page_Details(){
            $this->Set_Input_Variables();
            if(isset($this->var['content_domain']["db"])){
                if(count($this->var['content_domain']["db"])>0){
                    $this->var['content']["db"]=$this->var['content_domain']["db"];
                }
            }
            
            ////$this->cls->clsLog->general("-Content init Start->",1);
            if(!isset($this->input_data['membersID'])) $this->input_data['membersID']=0;
            $original_page=$this->input_data['REQUEST_URI'];
            $this->var['content']["original_uri"]=$original_page;
            $this->var['content']['cpid']=0;
            
            if(isset($this->input_data['dcmsuri'])){
                if($this->input_data['dcmsuri']>0){
                    $this->var['content']["URI"]=$this->input_data['dcmsuri'];
                    if($this->input_data['dcmsuri']>0){
                        $PArr=preg_split("/\//",$this->input_data['dcmsuri']);
                        
                    }else{
                        $PArr=preg_split("/\//",$original_page);
                    }
                    $this->var['content']["proxy_uri"]=$this->var['content']["URI"];
                }else{
                    $this->var['content']["URI"]=$original_page;
                    $PArr = preg_split("/\//",$original_page);
                    $this->var['content']["PArr"]=$PArr;
                    if($PArr[1]==""){
                        $this->var['content']["URI"]='/';
                    }else{
                        $this->var['content']["URI"]='/'.$PArr[1].'/';
                    }
                    
                }
            }
            //$this->vrs->do=$this->var;
            $this->var['content']['input']=$this->input_data;
            $this->var['content']['input']['get']=$this->input_get_data;
            $this->var['content']['input']['post']=$this->input_post_data;
            
        }
        

        public function Content_Init(){
            $this->Update_All_Vars();
            
            
            //echo"\n\n--D22222XXX---------------------------------------------------------------------------\n";
            //print_r($this->var['domain']);
            /*
            if(isset($this->var['content_domain']["db"])){
                if(count($this->var['content_domain']["db"])>0){
                    $this->var['content']["db"]=$this->var['content_domain']["db"];
                }
            }
            //$this->cls->clsLog->general("-Content init Start->",1);
            */
            
            //if($this->input_data['cpid']>0){
            //    $this->var['content']['cpid']=$this->input_data['cpid'];
           // }
           
            $this->Content_Init_Page_Details();
            //print_r($this->var['content']);
            //print_r($this->input_data);
            //$this->var['content']=$this->input_data;
            //print_r($this->var['content']);
            $original_page=$this->input_data['REQUEST_URI'];
            //$original_page=$_SERVER['REQUEST_URI'];
            $OriginalPageName=$original_page;
            if(isset($this->var['content']["PArr"])){
                $PArr=$this->var['content']["PArr"];
            }else{
                $PArr=array();
            }
            //echo"\n\n--D22hello---------------------------------------------------------------------------\n";
            
            //print_r($this->var['content']);
            if(isset($this->input_data['dcmsuri'])){
                //if($this->input_data['dcmsuri']>0){
                    $this->var['content']["URI"]=$this->input_data['dcmsuri'];
                    if($this->input_data['dcmsuri']>0){
                        $PArr=preg_split("/\//",$this->input_data['dcmsuri']);
                        
                    }else{
                        $PArr=preg_split("/\//",$original_page);
                    }
                    $this->var['content']["proxy_uri"]=$this->var['content']["URI"];
                }else{
                    $this->var['content']["URI"]="";
                    
                    $PArr = preg_split("/\//",$original_page);
                    //print "tpn5".$original_page;
                    //print_r($PArr);
                    if($PArr[1]==""){
                        $this->var['content']["URI"]='/';
                    }else{
                        $this->var['content']["URI"]=$OriginalPageName;
                        
                    }
                    
                }
            //}
            
            
            $content_data_uri=array();
            if(isset($this->input_data['dcmsuri'])){
                $this->var['content']["dcmsuri"]=$this->input_data['dcmsuri'];
                if($this->input_data['change']>0){
                    $this->var['content']["change_datetime"]=urldecode($this->input_data['change']);
                    $change_sql=" ,TIMESTAMPDIFF(HOUR,Changed,'".$this->var['content']["change_datetime"]."') AS cache_count";
                }else{
                    $change_sql="";
                }
            }
            //print_r($this->var);
            
            //if(isset($_GET['cpid'])){
                //echo"\n\n--D22bye--------------------------------------------------------------------------\n";
            
            if(isset($this->var['content']['cpid'])){
                if($this->var['content']['cpid']>0){
                    
                    //$this->var['content']["content_pagesID"]=$_GET['cpid'
                    $this->var['content']["content_pagesID"]=$this->var['content']['cpid'];
                    if($this->input_data['change']>0){
                        $sql='SELECT DISTINCT URI'.$change_sql.' FROM content_pages WHERE id='.$this->var['content']["content_pagesID"].' LIMIT 0,1';
                    }else{
                        $sql='SELECT DISTINCT URI,Changed AS cache_count FROM content_pages WHERE id='.$this->var['content']["content_pagesID"].' LIMIT 0,1';
                    }
                    $rslt=$this->db->RawQuery($sql);
                    $num_rows=0;
                    $num_rows=$this->db->NumRows($rslt);
                    if($num_rows>0){
                        if(isset($this->var['content']["change_datetime"])){
                            exit("Use Cached File");
                        }else{
                        }
                        $content_data_uri=$this->db->Fetch_Assoc();
                    }
                    if(isset($content_data_uri['URI'])){
                        $this->var['content']["URI"]=$content_data_uri['URI'];
                        $this->var['content']["uri"]=$this->var['content']["URI"];
                    }
                }else{
                    $this->var['content']["content_pagesID"]=0;
                    if(isset($this->var['content']["URI"])){
                        $this->var['content']["uri"]=$this->var['content']["URI"];
                    }
                }
                
            }else{
                $this->var['content']["content_pagesID"]=0;
                $this->var['content']["uri"]=$this->var['content']["URI"];
            }
            
            $this->var['content']["uri_split_array"]=$PArr;
            $current_page="/";
            $get_variables=array();
            foreach($this->var['content']["uri_split_array"] as $key=>$val){
                $pos = strpos($val, '=');
                if($pos){
                    $parts = explode('=', $val);
                    $get_variables[$parts[0]]=$parts[1];
                }else{
                    if(strlen($val)>0){
                        $current_page.=$val."/";
                    }
                }
            }
            
            $this->var['content']['get_variables']=$get_variables;
            //echo"\n\n--D22goodbye--------------------------------------------------------------------------\n";
            //print_r($this->var['content']['get_variables']);
            if(isset($this->var['content']["dcmsuri"])){
                $TotalPageName=$this->var['content']["dcmsuri"];
            }else{
                if(!isset($this->var['content']["TOTALPAGENAME"])){
                    $this->var['content']['RESET']=true;
                    $TotalPageName=$current_page;
                    $this->var['content']["TOTALPAGENAME"]=$TotalPageName;
                }
                
                if(substr($TotalPageName,strlen($TotalPageName)-1)!="/"){
                    $TotalPageName.="/";
                    $this->var['content']["TOTALPAGENAME"]=$TotalPageName;
                }
            }
            
            $this->var['content']['PAGENAME']=$this->var['content']["TOTALPAGENAME"];
            $VariableArray=array();
            $csearch=true;
            $notfound=true;
            $csearch=true;
            $segment=0;// times we go around
            ////$this->cls->clsLog->general("-Content Biz Cats-",1);
            //print "tpn".$TotalPageName;
            //======================================================================== If user home page
            if(isset($this->var['domain_user'])>0){
                if(count($this->var['domain_user'])>0){
                    if(isset($this->var['domain']["db"]['id'])){
                        $sql="SELECT * FROM content_pages WHERE module_viewsID='25' AND domainsID=".$this->var['domain']["db"]['id']." AND languagesID=".$this->input_data['LanguagesID']." LIMIT 0,1";
                        $rslt=$this->db->RawQuery($sql);
                        if($this->db->NumRows($rslt)>0){
                            $csearch=false;
                            $notfound=false;
                            //if(!defined("PAGENAME")){
                                //define('PAGENAME',$TotalPageName);
                                $this->var['content']["PAGENAME"]=$TotalPageName;
                            //}
                            $this->var['content']["db"]=$this->db->Fetch_Assoc($rslt);	
                            if(isset($this->var['domain_user']['mod_business_categoriesID'])){
                                $sql="SELECT * FROM mod_business_categories WHERE id=".$this->var['domain_user']['mod_business_categoriesID'];
                        
                                $rslt=$this->db->RawQuery($sql);
                                $this->var['bizcat']["db"]=$this->db->Fetch_Assoc($rslt);	
                                
                                $this->var['content']["db"]['Meta_Title']=$this->var['domain_user']['name']." - ".$this->var['bizcat']['CategoryTitle']." - ".$this->var['content']["db"]['Meta_Title'];
                            }
                            
                        }
                    }
                    
                }
            }
            //======================================================================== If page updated for cache
            $sql="";
            if(isset($this->var['content']["change_datetime"])){
                $change_sql=" ,TIMESTAMPDIFF(HOUR,Changed,'".$this->var['content']["change_datetime"]."') AS cache_count";
                $change_sql_where=" AND cache_count<1";
            }else{
                $change_sql_where="";
                $change_sql="";
            }
            //echo"\n\n--D22casbe--------------------------------------------------------------------------\n";
            
            //print_r($this->var);
            //======================================================================== If site is search engine friendly
            $content_pagesID=$this->var['content']['input']["cpid"];
            $seo_friendly=$this->var['domain']["db"]["SEOFriendlyLT"];
            $item_no=$this->as->select_item("item_groups_Boolean_ModalID","No");
            $item_yes=$this->as->select_item("item_groups_Boolean_ModalID","Yes");

            //echo"\n\n--D22couldbe---------$seo_friendly-----------------------------------------------------------------\n";
                //print_r($this->var['domain']);
            
            if(isset($seo_friendly)){
                
                
                
                //print_r($group_item);
                if($seo_friendly==$item_no){
                    //if($this->var['content']["content_pagesID"]>0){
                        
                    if($content_pagesID>0){
                        $sql="SELECT * FROM content_pages WHERE id='".$content_pagesID."'  LIMIT 0,1";

                        $sql="SELECT *".$change_sql." FROM content_pages WHERE id='".$content_pagesID."'   LIMIT 0,1";
                    }else{
                        $sql="SELECT *".$change_sql." FROM content_pages WHERE  URI='".$this->var['content']["URI"]."'  AND domainsID=".$this->var['domain']['db']['id']."  LIMIT 0,1";
                    }
                    
                //}elseif($seo_friendly==$item_yes){
                }else{
                    //print_r($this->var['domain']);
                    $sql="SELECT DISTINCT *".$change_sql." FROM content_pages WHERE URI='".$this->var['content']["URI"]."'   AND domainsID=".$this->var['domain']['db']['id']."";
                    //print $sql;
                    //print_r($this->var['domain']);
                }
            }elseif($this->var['content']["content_pagesID"]>0){
                $sql="SELECT *".$change_sql." FROM content_pages WHERE id='".$content_pagesID."'  LIMIT 0,1";
            }else{
                $sql="SELECT *".$change_sql." FROM content_pages WHERE HomePageLT=".$this->as->select_item("item_groups_Boolean_ModalID","Yes")."   LIMIT 0,1";
            }
            
            //echo"\n\n--D22maybe------------------------$sql--------------------------------------------------\n";
            
            //print " \n DB=>".$sql." \n";
            $rslt=$this->db->rawQuery($sql);
            $num_rows=0;
            $num_rows=$this->db->NumRows($rslt);
            //print_r($this->var['content']);
            
            if($num_rows>0){
                
                
                $this->var['content']['PAGENAME']=$OriginalPageName;
                $this->var['content']['db']=$this->db->Fetch_Assoc($rslt);
                
                $this->var['content']["content_pagesID"]=$this->var['content']['db']['id'];
                $notfound=false;
                $csearch=false;
                if(isset($this->var['content']['db']['cache_count'])){
                    if($this->var['content']['db']['cache_count']<0){
                        exit("Use Cached File");
                    }
                }
                
                //print_r($this->var['content']);
                //print_r($_SESSION);
                /*
                if($this->var['content']['db']['ExposureLT']==37){
                    if($_SESSION['membersID']==0){
                        $TotalPageName="/";
                        $csearch=true;
                    }else{
                        $TotalPageName="/login/";
                        $csearch=true;
                    }
                    $_SESSION['PAGENAME']=$this->var['content']['PAGENAME'];
                }
                
                if(($_SESSION['membersID']==0)&&($this->var['content']['db']['Exposure']=="Member")){
                    $TotalPageName="/login/";
                    //define('PAGENAME',$TotalPageName);
                    $csearch=true;
                    //echo"Member Page";
                    //exit();
                    header("Location: /");
                    $_SESSION['PAGENAME']=$this->var['content']['PAGENAME'];
                    print_r($_SESSION);
                }else{
                    //define('PAGENAME',$OriginalPageName);
                }
                */
            }else{
            }
            //print"\n XX \n";
            //print_r($this->var['domain']);
            ////$this->cls->clsLog->general("-Content Search-",1);
            if(isset($this->var['domain']['db']['id'])){
                $domain_search=$this->var['domain']['db']['id'];
            }else{
                $domain_search="";
            }
            
            $max_count=0;
           //print_r($this->var['domain']['db']['id']);
            
            // retrieve the header location target if you are logged in | works for management and members
            $location_action=$this->Get_Location_Target();
            //print($locaion_action);
            //echo $csearch."Member Page 1".$sql;
            //print_r($this->var['content']);
            while(($csearch)&&($max_count<10)){
                $max_count++;
                $sql="SELECT * FROM content_pages WHERE URI='".$TotalPageName."' AND domainsID=".$domain_search." AND languagesID=".$this->input_data['LanguagesID']."";
                $rslt=$this->db->RawQuery($sql);
                $num_rows=$this->db->NumRows($rslt);
                
                if($num_rows>0){
                    $csearch=false;
                    $notfound=false;
                    //if(!isset(PAGENAME)) define('PAGENAME',$TotalPageName);
                    $this->var['content']['PAGENAME']=$OriginalPageName;
                    $this->var['content']['db']=$this->db->Fetch_Assoc($rslt);	
                    
                    
                    if(!isset($_SESSION['membersID'])&&($this->var['content']['db']['ExposureLT']==$this->as->select_item("item_groups_page_exposureID","Member"))){
                        //echo"Member Page";
                        //exit("Member Page");
                        //header("Location: /");
                    }
                    
                    if($this->var['content']["db"]['domainsID']==0){
                        // what group is the page in => management
                        //print_r($this->var);
                        if($_SESSION['membersID']>0){
                            // member logged in
                            if($this->var['content']["db"]['ExposureLT']>$this->as->select_item("item_groups_page_exposureID","Public")){
                                // page either member or both
                                //echo"Member Page 1";
                            }else{
                                //$location_target="/login-management/";
                                $this->as->Redirect_Current_Page($location_action);
                                //header("Location: ".$location_action);
                            }
                        }else{
                            //$this->as->Redirect_Current_Page($location_action);
                            //header("Location: ".$location_action);
                            break;
                        }
                    }else{
                        // what group is the page in => public
                        //echo"Public Page 1";
                    }
                    
                    
                    
                }else{
                    
                    //exit("XX Find Page=>".$sql."  <=>".$TotalPageName);
                    $TArr=explode('/',$TotalPageName);
                    if(count($TArr)>2){
                        $VariableArray[]=$TArr[count($TArr)-2];
                        $TotalPageName="";
                        for($x=0;$x<(count($TArr)-2);$x++){
                            $TotalPageName.=$TArr[$x]."/";
                        }
                    }
                    //print "\n xxx uri=>".$TotalPageName;
                    if($TotalPageName=="/"){
                        if($domain_search>0){
                            $domain_search=0;
                            $csearch=true;
                            $TotalPageName=$OriginalPageName;
                        }else{
                            $csearch=false;
                            $this->var['content']['PAGENAME']=$OriginalPageName;
                            //print "\n xxx uri=>".$OriginalPageName;
                            //define('PAGENAME',TOTALPAGENAME);
                        }
                        
                    }else{
                        $csearch=true;
                    }
                    //print $TotalPageName;
                };
                
                //print "--".$sql."==\n";
            };
            
            //print "x-$notfound-DDD==";
            if($notfound){
                //print "x-$notfound-DDD==";
                $sql="SELECT * FROM content_pages WHERE URI='".$this->var['content']['PAGENAME']."' AND domainsID=".$this->var['domain']["db"]['id']."";
                $rslt=$this->db->RawQuery($sql);
                if($this->db->NumRows($rslt)==0){// cant find page so load homepage for language/site
                    //$sql="SELECT * FROM content_pages WHERE URI='".$this->var['content']['PAGENAME']."' AND domainsID=0";
                    $sql="SELECT * FROM content_pages WHERE URI='".$this->var['content']["URI"]."' AND domainsID=0";
                    //print "\n $num_rows uri=>".$this->var['content']["URI"];
                    $rslt=$this->db->RawQuery($sql);
                    $num_rows=$this->db->NumRows($rslt);
                    
                    if($num_rows>0){
                        

                        $this->var['content']['db']=$this->db->Fetch_Assoc($rslt);
                        //print "x--DDD==";
                        //print_r($this->var['content']);
                    }else{
                        if($this->var['content']["original_uri"]=="/"){
                            // on homepage
                            //Exec_Retrieve
                            $where_array=array("HomePage_item-groups-Boolean-ModalID"=>$this->as->select_item("item_groups_Boolean_ModalID","Yes"),"languagesID"=>$_SESSION['LanguagesID'],"domainsID"=>$this->var['domain']["db"]['id']);
                            $this->var['content']['db']=$this->adb->Exec_Retrieve("content_pages","Assoc",array("*"),$where_array);
			
                            //$this->var['content']['db']=$this->adb->Execute_Database_Query("Retrieve","content_pages",
                           // array("HomePage_item-groups-Boolean-ModalID"=>12,"languagesID"=>$_SESSION['LanguagesID'],"domainsID"=>$this->var['domain']["db"]['id']));
                            //$sql="SELECT * FROM content_pages WHERE HomePage='Yes' AND languagesID=".$_SESSION['LanguagesID']." AND domainsID=".$this->var['domain']["db"]['id'];
                        }elseif($this->var['content']["original_uri"]!="/"){
                            // on homepage
                            /*
                            $this->var['content']['db']=$this->adb->Execute_Database_Query("Retrieve","content_pages",
                            array("URI"=>$this->var['content']['PAGENAME'],"languagesID"=>$_SESSION['LanguagesID'],"domainsID"=>0));
                            */
                             $where_array=array("URI"=>$this->var['content']['PAGENAME'],"languagesID"=>$_SESSION['LanguagesID'],"domainsID"=>0);
                            $this->var['content']['db']=$this->adb->Exec_Retrieve("content_pages","Assoc",array("*"),$where_array);
                            //$sql="SELECT * FROM content_pages WHERE URI='".$this->var['content']['PAGENAME']."' AND languagesID=".$_SESSION['LanguagesID']." AND domainsID=0";
                        }else{
                            $this->var['content']['db']=$this->adb->Execute_Database_Query("Retrieve","content_pages",
                            array("module_viewsID"=>801));
                            // when no page has been created - 404 error page
                            //$sql="SELECT * FROM content_pages WHERE module_viewsID='801'";
                        }
                        
                        //$rslt=$this->db->RawQuery($sql);
                        //$num_rows=$this->db->NumRows($rslt);

                        //print "\n uri=>".$num_rows." | ".$sql." | ".$this->var['content']['PAGENAME']." |";
                        
                        //exit();
                        /*
                        if($num_rows>0){
                            //http_response_code(404);
                            $this->var['content']['db']=$this->db->Fetch_Assoc($rslt);
                        }else{
                            if($this->var['content']['PAGENAME']!="/404/"){
                            
                                //http_response_code(404);
                                //header("Location: /404.shtml");
                                header("HTTP/1.1 404 Not Found");
                                $page_missing_url='/404/';
                                header("Location: ".$page_missing_url);
                            }
                        }
                            */
                        //print $this->var['content']['PAGENAME'];
                        
                        
                    }
                }else{
                    $this->var['content']['db']=$this->db->Fetch_Assoc($rslt);
                    $_SESSION['LanguagesID']=$this->var['content']['languagesID'];
                };
                
            };
            //print_r($this->var);
            $this->var['content']["db"] = $this->as->strip_capitals($this->var['content']["db"]);
            //print_r($this->var['content']);
            $module_viewsID=$this->var['content']['input']['mvid'];
            if($module_viewsID>0){
                $content_id=$module_viewsID;
            }else{
                if(isset($this->var['content']['db']['module_viewsid'])){
                    $content_id=$this->var['content']['db']['module_viewsid'];
                }else{
                    $content_id=0;
                }
            }
            
            $sql="SELECT * FROM modules,module_views WHERE modules.id=module_views.modulesID AND module_views.id=".$content_id;
            //$sql="SELECT * FROM modules,module_views WHERE modules.id=module_views.modulesID AND module_views.id=".$module_viewsID;
            $rslt=$this->db->RawQuery($sql);
            $num_rows=$this->db->NumRows($rslt);
            
            if($num_rows==0){
                
                //header("Location: /");
            }else{
                //$this->var['content']['db']['title']=
                
                //clsSystem::$vars->content_data=$this->var['content'];
                //echo"321012345555-----------------------------------------------------------------------------\n";
                $this->var['module']["db"]=$this->db->Fetch_Assoc($rslt);
                //echo"2234321012345555-----------------------------------------------------------------------------\n";
                $this->var['module']["db"] = $this->as->strip_capitals($this->var['module']["db"]);
                //echo"112234321012345555-----------------------------------------------------------------------------\n";
                //print_r($this->var['module']["db"]);
                if($module_viewsID>0){
                    $this->var['content']['db']['title']=$this->var['module']["db"]['viewname'];
                }
                $this->target_class=$this->var['module']["db"]['class'];
                $target_class=$this->target_class;
                //echo $target_class."-00001112234321012345555-----------------------------------------------------------------------------\n";
                //$this->target=new $target_class();
                $new_db=clsClassFactory::$cf_cls->Add_Class($target_class);
                //clsClassFactory::Add_Class($target_class);
                //Add_Class($this->target);
                //echo"1112234321012345555-----------------------------------------------------------------------------\n";
                //print_r($this->var['module']);
                //if($this->var['module']["db"]['Pre_FileName']!=""){
                $pre_method=$this->var['module']["db"]['Pre_Method'];
                //echo"54321012345555----$pre_method-------------------------------------------------------------------------\n";
                if($pre_method!=""){
                    //$this->target->$pre_method();
                    //$this->cls->$this->target_class->$pre_method();
                    //$this->cls->__call($this->target_class,$pre_method);
                    clsClassFactory::$cf_cls->$target_class->$pre_method();
                    /*
                    $lfile=$this->cls->clsAssortedFunctionspp_data['MODULEBASEDIR'].$this->var['module']["db"]['Dir']."/".$pre_file;
                    //print $lfile;
                    if (file_exists($lfile)) {
                        include($lfile);
                    }else{
                        ////$this->cls->clsLog->general("AA error->",1);
                        //echo"AA error";
                    }
                    */
                }

                //print_r($_SESSION);
                
                    if($this->var['content']["db"]['domainsID']==0){
                        // what group is the page in => management
                        //print_r($this->var);
                        if($_SESSION['membersID']>0){
                            // member logged in
                            //if($this->var['content']["db"]['ExposureLT']>36){
                            if($this->var['content']["db"]['ExposureLT']>$this->as->select_item("item_groups_page_exposureID","Public")){
                                // page either member or both
                                //echo"Member Page 1";
                            }else{
                                // if member logged in to management on public page=>redirect
                                //$location_target="/login-management/";
                                $this->as->Redirect_Current_Page($location_action);
                                //header("Location: ".$location_action);
                            }
                        }else{
                            //if($this->var['content']["db"]['ExposureLT']>36){
                            if($this->var['content']["db"]['ExposureLT']>$this->as->select_item("item_groups_page_exposureID","Public")){
                                
                                $this->as->Redirect_Current_Page($location_action);
                                //header("Location: ".$location_action);
                            }
                        }
                    }else{
                        
                        if(isset($_SESSION['membersID'])){
                            if($_SESSION['membersID']==0){
                                // what group is the page in => public
                                //echo"Public Page 1";
                            }else{
                                if($this->var['content']["db"]['ExposureLT']==$this->as->select_item("item_groups_page_exposureID","Public")){
                                    // if member logged in on public page=>redirect
                                    $this->as->Redirect_Current_Page($location_action);
                                    //header("Location: ".$location_action);
                                    
                                }else{
    
                                }
                            }
                        }
                        
                    }

                
                /*
                if(!isset($_SESSION['membersID'])&&($this->var['content']["db"]['ExposureLT']==37)){
                    //echo"Member Page";
                    ////$this->cls->clsLog->general("Member Page->",1);
                    //header("Location: /");
                }
                */
            }
            if(isset($this->var['content']["content_pagesID"])){
                $this->var['content']["content_pagesid"]=$this->var['content']["content_pagesID"];
            }
            
            ////$this->cls->clsLog->general("-End Content init->",1);
            if(isset($_GET['ajax'])){
                $this->var['domain']["db"]['templatesID']=35;
                $this->var['content']["db"]['templatesID']=35;
            }
            //echo"\n\n--22222GGG-------------------------".$sql."--------------------------------------------------\n";
            //print_r($this->var);
            
            //$this->vrs->do=$this->var;
            
        }

        public function Get_Location_Target(){
            $locaion_action="";
            $domainsID=$this->var['domain']['db']['id'];
            //print_r($this->var);
            $management_welcome_pagesURI='/management/';
            $management_home_pagesURI='/management/home/';
            $members_home_pagesURI='/members-home/';
            $content_domainsID=$this->var['domain']['db']['id'];//$this->var['content']['db']['domainsID'];
            $languagesID=$this->var['content']['input']['LanguagesID'];
            $var_array=array();
            if($this->var['domain']["db"]['SEOFriendlyLT']==$this->as->select_item("item_groups_Boolean_ModalID","Yes")){
                if($content_domainsID==0){
                    // management administrators home page
                    if($_SESSION['membersID']>0){
                        $content_pagesID=512;
                    }else{
                        $content_pagesID=447;
                    }
                    //echo"\n JJJ55 ".$content_pagesID." \n";
                }else{
                    // members home page
                    $var_array=$this->Get_Location_DB($content_domainsID,$languagesID,0,$members_home_pagesURI);
                    //echo"\n JJJ44  \n";
                    //print_r($var_array);
                    $content_pagesID=$var_array['content_pagesID'];
                }
                //echo"\n JJJ33 ".$content_pagesID." \n";
                $location_action=$this->cls->clsLinks->Create_Content_Pages_Link($content_pagesID);
            }else{
                if($content_domainsID==0){
                    if($_SESSION['membersID']>0){
                        // management administrators home page
                        $content_pagesURI=$management_home_pagesURI;
                    }else{
                        $content_pagesURI=$management_welcome_pagesURI;
                    }
                    
                }else{
                    // members home page
                    $content_pagesURI=$members_home_pagesURI;
                }
                //echo"\n JJJ22 \n";
                $location_action=$this->cls->clsLinks->Create_SEO_Friendly_Link($content_pagesURI);
            }
            //print $location_action;
            return $location_action;
        }

        public function Get_Location_DB($domainsID,$languagesID,$content_pagesID=0,$content_pagesURI="/members-home/"){
            $var_array=array();
            if($content_pagesID==0){
                $extra_sql='URI="'.$content_pagesURI.'"';
            }else{
                $extra_sql='id="'.$content_pagesID.'"';
            }
            $sql="SELECT id AS content_pagesID,URI FROM content_pages WHERE ".$extra_sql." AND domainsID=".$domainsID." AND languagesID=".$languagesID."";
            //print $sql;
            $rslt=$this->db->RawQuery($sql);
            $num_rows=$this->db->NumRows($rslt);
            
            if($num_rows>0){
                $var_array=$this->db->Fetch_Assoc($rslt);
            }
            return $var_array;
        }

        public function Display(){
            
            //$this->cls->clsLog->general("-ab Text Display->",3);
            $return_html="";
            //$target=new $this->var['module']["db"]['class']();
            //print_r($this->var['module']);
            if(isset($this->var['module']["db"]['Method'])){
                $method=$this->var['module']["db"]['Method'];
            }else{
                $method="";
            }
            
            if($method!=""){
                //$return_html=$this->cls->$this->target_class->$method();
                $this->Update_All_Vars();
                $target_class=$this->target_class;
                //print "1xxx".$this->target_class."->".$method." \n";
                //clsClassFactory::Add_Class($target_class);
                $return_html=clsClassFactory::$cf_cls->$target_class->$method();
                //print "xxx".$return_html."->".$method." \n";
                //$return_html=$this->target->$method();
            }
            //$this->vrs->do=$this->var;
            return $return_html;
            /*
            if(isset($module_data["db"]['dir'])){
                $module_template_display=$app_data['MODULEBASEDIR'].$module_data["db"]['dir']."/".$module_data["db"]['filename'];
                if(file_exists($module_template_display)){
                    //print $module_template_display;
                    //$this->cls->clsLog->general("-ar Text Display->".$module_template_display."-".var_export($module_data,true),3);
                    $text_data['debug'][]=$module_template_display;
                    include($module_template_display);
                }else{
                }
            }
            */
        }


        public function Content_Pages_Add_Table(){
            $this->output=__METHOD__;

            $this->output=$this->cls->clsHTMLContent->create_add_page_form_fields();
            return $this->output;
        }

        public function Content_Pages_Edit_Table(){
            $this->output=__METHOD__;

            //$this->output=$this->cls->clsHTMLContent->create_member_form_fields();
            return $this->output;
        }

        public function Content_Pages_List_Table(){
            $this->output=__METHOD__;
            //$this->output=$this->cls->clsHTMLContent->create_page_list();
            //$this->output="";
            return $this->output;
        }

        public function Pre_Modify_Page(){

        }

        public function Pre_Add_Page(){
            
        }

        public function Pre_Edit_Page(){
            
        }
    }